<?php    
include 'header.php';

 //paramétrage de la base de données
 require "connexion_db.php";

 //connexion à la base de données
 $db = connexionBase();


//si une pro_ref est dans l'URL, cela veut dire qu'on  vient de passer par la page update_script.php donc on récupère tout le $_GET[] dans un object $produit
//ce qui permettra l'affichage du formulaire avec les modifications "pré-sauvegardées" concernant le produit d'ID pro_id ainsi que les erreurs
$produit=(object)$_GET;

//-----RECUPERATION DES VARIABLES D'ERREUR DE MODIFICATION----------


//-------ERREUR DE REFERENCE----------------------------------------
$err_ref="";
if(isset($produit->Err_ref)){
    switch ($produit->Err_ref){
        case(0): $err_ref="Veuillez entrer une référence.";
        break;
        case(1): $err_ref="Référence déjà existante. Veuillez entrer une autre référence.";
        break;
        case(2): $err_ref="Veuillez entrer un format de référence correct. Seuls les lettres et les chiffres sont acceptés.";
        break;
    }
}

//-------ERREUR DE LIBELLE----------------------------------------
$err_libelle="";
if(isset($produit->Err_libelle)){
    switch ($produit->Err_libelle){
        case(0): $err_libelle="Veuillez entrer un libellé.";
        break;
        case(1): $err_libelle="Veuillez entrer un format de libellé correct. Seuls les lettres et les chiffres sont acceptés.";
        break;
    }
}
                                    
//-------ERREUR DE PRIX-------------------------------------------
$err_prix="";
if(isset($produit->Err_prix)){
    switch ($produit->Err_prix){
        case(0): $err_prix="Veuillez entrer un prix au produit.";
        break;
        case(1): $err_prix="Veuillez entrer un prix au format numérique.";
        break;
        case(2): $err_prix="Veuillez entrer un prix supérieur ou égal à 0.";
        break;
    }
}

//-------ERREUR DE STOCK-------------------------------------------
$err_stock="";
if(isset($produit->Err_stock)){
    switch ($produit->Err_stock){
        case(0): $err_stock="Veuillez identiquer le nombre d'articles en stock.";
        break;
        case(1): $err_stock="Veuillez entrer un stock au format numérique.";
        break;
        case(2): $err_stock="Veuillez entrer un stock positif.";
        break;
    }
}

//-------ERREUR DE COULEUR-------------------------------------------
$err_couleur="";
if(isset($produit->Err_couleur)){
    $err_couleur="Veuillez entrer une couleur dans un format correct. Seules les lettres sont acceptées.";
}

//-------ERREUR DE FICHIER IMAGE----------------------------------------
$err_pro_photo="";
if(isset($produit->Err_pro_photo)){
    switch($produit->Err_pro_photo){
    case(0): $err_pro_photo="Mauvais format de fichier.";
    break;
    case(1): $err_pro_photo="Le fichier n'a pas été uploadé (trop gros ?).";
    break;
    }
}

//-----------------------------------------------------------------------

//on récupére la liste des catégories "parents" (=sans parents eux même) dans la table catégories de la base de données (pour l'affichage d'une liste de catégories)
$requeteCategories = $db->prepare("SELECT * FROM categories where (cat_parent IS NULL)");
$requeteCategories->execute();
?>

<div class="row m-0 p-0 mt-0 ">
    <div class="col-12 col-sm-12 p-3 p-sm-3 mb-3 mb-sm-3 shadow">
        <section>
            <!-- on masque le titre de la page. Balise H1 aide au référencement Google-->
            <h1 class="p-3">Ajout d'un nouveau produit</h1>

            <article class="w-100 w-sm-100">
                
                <!--DEBUT DE FORMULAIRE------------------------------->
                <form method="POST" action="add_script.php" id="form_ADD_produit" name="form_ADD_produit"
                    class="form-block mt-3" enctype="multipart/form-data">
                    <div class="form-group ">

                        <!------AJOUT DU FICHIER IMAGE------>
                        <div class="form-row mt-1">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Image Produit</span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="photoProduit"
                                            name="photoProduit">
                                        <label class="custom-file-label" for="photoProduit">Choisissez un
                                            fichier</label>
                                    </div>
                                </div>
                                <small>* Seuls les fichiers .jpg, .jpeg et .png seront acceptés</small>
                            </div>
                        </div>

                        <!------REFERENCE----->
                        <div class="form-row mt-1">
                            <div class="col">
                                <lable for="pro_ref">R&eacute;f&eacute;rence :</lable>
                                <div id="errorRef" class="text-danger"><?=$err_ref;?></div>
                                <input type="text" class="form-control form-control-sm" name="pro_ref" id="pro_ref"
                                    maxlength="10" value="<?php if(!empty($produit->pro_ref)) echo $produit->pro_ref;?>" />
                            </div>
                        </div>

                        <!------CATEGORIE------>
                        <div class="form-row mt-1">
                            <div class="col">
                                <lable for="pro_cat">Cat&eacute;gorie :</lable>
                                <select class="form-control" name="pro_cat_id" id="pro_cat_id">
                                    <?php
                                        while($Categories = $requeteCategories->fetch()){

                                            echo '<optgroup label="'.$Categories->cat_nom.'">';
                                            //on récupére les informations concernant les catégories qui sont des sous catégories des catégories (c a d, celles qui ont un parent)
                                            $requeteSousCategories = $db->prepare("SELECT cat_id, cat_nom FROM categories where (cat_parent=:categorie) and (cat_parent IS NOT NULL)");
                                            $requeteSousCategories->bindValue(":categorie", $Categories->cat_id);
                                            $requeteSousCategories->execute();
                                            
                                            //on affiche les sous catégories
                                            while($SousCategorie = $requeteSousCategories->fetch()){
                                                if(!empty($SousCategorie->cat_id)){
                                                    echo '<option value="'.$SousCategorie->cat_id.'"';
                                                    if(!empty($produit->pro_cat_id)&&(($produit->pro_cat_id)==($SousCategorie->cat_id))){
                                                        echo " selected class='bg-dark text-light'";
                                                    }
                                                    echo '>'.$SousCategorie->cat_nom.'</option>';
                                                }
                                            }
                                            echo '</optgroup>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!------LIBELLE------>
                        <div class="form-row mt-1">
                            <div class="col">
                                <lable for="pro_libelle">Libell&eacute; :</lable>
                                <div id="errorLib" class="text-danger"><?=$err_libelle;?></div>
                                <input type="text" class="form-control form-control-sm" name="pro_libelle"
                                    id="pro_libelle" maxlength="200" value="<?php if(!empty($produit->pro_libelle)) echo $produit->pro_libelle;?>" />
                            </div>
                        </div>

                        <!------DESCRIPTION------>
                        <div class="form-row mt-1">
                            <div class="col">
                                <lable for="pro_description">Description :</lable>
                                <textarea class="form-control form-control-sm" name="pro_description" maxlength="1000"
                                    id="pro_description" placeholder='Tapez ici une description de votre produit'><?php if(!empty($produit->pro_description)) echo strip_tags($produit->pro_description);?></textarea>
                                <div id="errorDesc" class="text-danger"></div>
                            </div>
                        </div>

                        <!------PRIX------>
                        <div class="form-row mt-1">
                            <div class="col">
                                <lable for="pro_prix">Prix :</lable>
                                <div id="errorPrix" class="text-danger"><?=$err_prix;?></div>
                                <input type="number" step="0.01" min="0.00" max="999999.99" class="form-control form-control-sm" name="pro_prix" id="pro_prix"
                                    value="<?php if(!empty($produit->pro_prix)) echo $produit->pro_prix;?>" />
                            </div>
                        </div>

                        <!------STOCK------>
                        <div class="form-row mt-1">
                            <div class="col">
                                <lable for="pro_stock">Stock :
                                    <?php
                                        if ((isset($produit->pro_stock))&&($produit->pro_stock==0)){
                                            echo "<img src='./jarditou_css/src/img/attention.jpg' class='icon' alt='Rupture de stock!' title='Attention! Un stock à zéro annoncera une rupture de stock.' />";
                                        }
                                    ?>
                                </lable>
                                <div id="errorStock" class="text-danger"><?=$err_stock;?></div>
                                <input type="number" min="0" max="99999999999" class="form-control form-control-sm"
                                    name="pro_stock" id="pro_stock" value="<?php if (isset($produit->pro_stock)) echo $produit->pro_stock;?>" />
                            </div>
                        </div>
                        
                        <!------COULEUR------>
                        <div class="form-row mt-1">
                            <div class="col">
                                <lable for="pro_couleur">Couleur :</lable>
                                <div id="errorCouleur" class="text-danger"><?=$err_couleur;?></div>
                                <input type="text" maxlength="30" class="form-control form-control-sm"
                                    name="pro_couleur" id="pro_couleur" value="<?php if(!empty($produit->pro_couleur)) echo $produit->pro_couleur;?>" />

                            </div>
                        </div>

                        <!------BLOQUE------>
                        <div class="form-row mt-1">
                            <div class="col">Désirez-vous bloquer le produit à la vente?
                            
                                <label class="form-check-label" for="pro_yes">
                                    <input type="radio" id="pro_yes" name="pro_bloque" class="form-control-input" value='1'
                                        <?php if(isset(($produit->pro_bloque))&&(($produit->pro_bloque)==1)) echo "checked"; ?> />
                                    Oui</label>
                             
                                    <label class="form-check-label" for="pro_no">
                                    <input type="radio" id="pro_no" name="pro_bloque" class="form-control-input" value='0'
                                        <?php if(!isset($produit->pro_bloque)){
                                            echo "checked";                                            
                                        }elseif($produit->pro_bloque!=1) echo "checked"; ?> />
                                    Non</label>
                                
                            </div>
                        </div>

                        <!------LIENS retour, modifier, supprimer ------>
                        <div class="form-row mt-1">
                            <div class="col">
                                <a href='index.php' class="btn btn-dark"
                                    name="btn_retour_tab" id="btn_retour_tab">Annuler</a>
                                <input type='submit' name='btn_enregistrer' id='btn_enregistrer' value='Enregistrer'
                                    class="btn btn-success" />
                                <input type='reset' name='btn_reset' id='btn_reset' value='Effacer'
                                    class="btn btn-warning" />
                            </div>
                        </div>

                    </div>
                    <!--fin de div .form-group-->
                </form>
            </article>
        </section>
    </div> <!-- fin de container col-->
</div> <!-- fin de container row-->

<?php

if(isset($_GET['ajout'])){
    echo "<script>alert('Votre nouveau produit a bien été ajouté à la base de données');</script>";
  }

  
 include 'footer.php'; 
 ?>