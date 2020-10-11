<?php   
    //paramétrage de la base de données
    require "connexion_db.php";

    //connexion à la base de données
    $db = connexionBase();

    //lancement de la requête qui permettra de recupérer toutes les infos sur le produit $pro_id
    $requeteProduit = $db->prepare("SELECT * FROM produits INNER JOIN categories ON produits.pro_cat_id=categories.cat_id AND produits.pro_id=:pro_id");
    $requeteProduit->bindValue(':pro_id', $_GET["pro_id"], PDO::PARAM_INT);
    $requeteProduit->execute();
    // Renvoi de l'enregistrement sous forme d'un objet:
    $produit = $requeteProduit->fetch();
    // on libère la connexion au serveur de base de données
    $requeteProduit->closeCursor();

    include 'header.php';
?>

<div class="row m-0 p-0 mt-0 ">
    <div class="col-12 col-sm-12 p-3 p-sm-3 mb-3 mb-sm-3 shadow">
        <section>
            <h1><?=$produit->pro_libelle;?></h1>
            <article class="w-100 w-sm-100">

                <!--DEBUT DU FORMULAIRE D'AFFFICHAGE DES DETAILS DU PRODUIT----------->
                <form method="POST" action="update.php" id="form_details" name="form_details" class="form-block">
                    <div class="form-group ">

                        <!--IDENTIFIANT DU PRODUIT + EXTENSION PHOTO PRODUIT EN HIDDEN-->
                        <input type='hidden' value='<?=$produit->pro_id;?>' name='pro_id' id='pro_id' />
                        <input type='hidden' value='<?=$produit->pro_photo;?>' name='pro_photo' id='pro_photo' />
                        
                        <!--AFFICHAGE DE L'IMAGE PRODUIT (si elle existe)-->
                        <?php if(!empty($produit->pro_photo)){ ?>
                        <div class="form-row mt-1">
                            <div class="col">
                                <div class="d-flex justify-content-center">
                                    <img src="./jarditou_css/src/img/<?=$produit->pro_id.'.'.$produit->pro_photo;?>"
                                        class="img-responsive-details img-thumbnail"
                                        alt="<?=$produit->pro_libelle;?>"
                                        title="<?=$produit->pro_libelle;?>" />
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        <!--AFFICHAGE DE LA REFERENCE PRODUIT -->
                        <div class="form-row mt-1">
                            <div class="col">
                                <lable for="name">R&eacute;f&eacute;rence :</lable>
                                <input type="text" class="form-control form-control-sm" name="pro_ref" id="pro_ref"
                                    value="<?=$produit->pro_ref;?>" readonly  />
                            </div>
                        </div>

                        <!--AFFICHAGE DE LA CATEGORIE PRODUIT -->
                        <div class="form-row mt-1">
                            <div class="col">
                                <lable for="name">Cat&eacute;gorie :</lable>
                                <input type="hidden" name="pro_cat_id" id="pro_cat_id" value="<?=$produit->pro_cat_id;?>" />
                                <input type="text" class="form-control form-control-sm" name="pro_cat_nom" id="pro_cat_nom"
                                    value="<?=$produit->cat_nom;?>" readonly />
                            </div>
                        </div>

                        <!--AFFICHAGE DU LIBELLE PRODUIT -->
                        <div class="form-row mt-1">
                            <div class="col">
                                <lable for="name">Libell&eacute; :</lable>
                                <input type="text" class="form-control form-control-sm" name="pro_libelle"
                                    id="pro_libelle" value="<?=$produit->pro_libelle;?>" readonly  />
                            </div>
                        </div>

                        <!--AFFICHAGE DE LA DESCRIPTION PRODUIT -->
                        <div class="form-row mt-1">
                            <div class="col">
                                <lable for="name">Description :</lable>
                                <textarea class="form-control form-control-sm" name="pro_description"
                                    id="pro_description" readonly ><?=$produit->pro_description;?></textarea>
                            </div>
                        </div>

                        <!--AFFICHAGE DU PRIX PRODUIT -->
                        <div class="form-row mt-1">
                            <div class="col">
                                <lable for="name">Prix (€) :</lable>
                                <input type="text" class="form-control form-control-sm" name="pro_prix" id="pro_prix"
                                    value="<?=$produit->pro_prix;?>" readonly  />
                            </div>
                        </div>

                        <!--AFFICHAGE DU STOCK PRODUIT -->
                        <div class="form-row mt-1">
                            <div class="col">
                                <lable for="pro_stock">Stock :
                                    <?php if ($produit->pro_stock==0) echo "<img src='./jarditou_css/src/img/attention.jpg' class='icon' alt='Attention! Rupture de stock!' title='Attention! Rupture de stock.' />"; ?>
                                </lable>
                                <input type="number" class="form-control form-control-sm" name="pro_stock"
                                    id="pro_stock" value="<?=$produit->pro_stock;?>" readonly  />
                            </div>
                        </div>

                        <!--AFFICHAGE DE LA COULEUR PRODUIT -->
                        <div class="form-row mt-1">
                            <div class="col">
                                <lable for="pro_couleur">Couleur :</lable>
                                <input type="text" class="form-control form-control-sm" name="pro_couleur"
                                    id="pro_couleur" value="<?=$produit->pro_couleur;?>" readonly  />
                            </div>
                        </div>

                        <!--AFFICHAGE DE LA VALEUR DE BLOQUE PRODUIT -->
                        <div class="form-row mt-1">
                            <div class="col">
                                Produit bloqué?
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="pro_yes" name="pro_bloque" class="custom-control-input"
                                        <?php if(($produit->pro_bloque)!==null) echo "checked"; ?> readonly  />
                                    <label class="custom-control-label" for="customRadioInline1">Oui</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="pro_no" name="pro_bloque" class="custom-control-input"
                                        <?php if(($produit->pro_bloque)==null) echo "checked"; ?> readonly  />
                                    <label class="custom-control-label" for="customRadioInline2">Non</label>
                                </div>
                            </div>
                        </div>

                        <!--AFFICHAGE DE LA DATE D'AJOUT PRODUIT -->
                        <div class="form-row mt-1">
                            <div class="col">
                                <lable for="pro_d_ajout">Date d'ajout :</lable>
                                <input type="text" class="form-control form-control-sm" name="pro_d_ajout"
                                    id="pro_d_ajout" value="<?=$produit->pro_d_ajout;?>" readonly  />
                            </div>
                        </div>

                        <!--AFFICHAGE DE LA DATE DE MODIFICATION PRODUIT -->
                        <div class="form-row mt-1">
                            <div class="col">
                                <lable for="pro_modif">Date de modification :</lable>
                                <input type="text" class="form-control form-control-sm" name="pro_d_modif"
                                    id="pro_d_modif" value="<?=$produit->pro_d_modif;?>" readonly  />
                            </div>
                        </div>

                        <!--AFFICHAGE DES BOUTONS RETOUR, MODIFIER? SUPPRIMER -->
                        <div class="form-row mt-3">
                            <div class="col">
                                <a href='tableau.php' class="btn btn-dark" name="btn_retour_tab"
                                    id="btn_retour_tab">Retour</a>
                                <input type="submit" class="btn btn-warning" name="btn_modif" id="btn_modif"
                                    value="Modifier" />
                                <a href='delete.php?pro_id=<?=$produit->pro_id;?>' class="btn btn-danger"
                                    name="btn_suppr" id="btn_suppr">Supprimer</a>
                            </div>
                        </div>

                    </div>
                    <!--fin de div .form-group-->
                </form>
                <!--fin de <FORM> -->
            </article>
        </section>
    </div> <!-- fin de col-->
</div> <!-- fin de row-->





<?php 
unset($produit);
include 'footer.php'; ?>