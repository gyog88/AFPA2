<?php   
    //paramétrage de la base de données
    require "connexion_db.php";

    //connexion à la base de données
    $db = connexionBase();

    //recupération de l'id du produit dont il faut afficher le détail
    $pro_id = intval($_GET["pro_id"]);

    //lancement de la requête qui permettra de recupérer toutes les infos sur le produit $pro_id
    $requeteProduit = $db->prepare("SELECT * FROM produits INNER JOIN categories ON produits.pro_cat_id=categories.cat_id AND produits.pro_id=:pro_id");
    $requeteProduit->bindValue(':pro_id', $pro_id, PDO::PARAM_INT);
    $requeteProduit->execute();
    // Renvoi de l'enregistrement sous forme d'un objet:
    $produit = $requeteProduit->fetch();

    include 'header.php';
?>


<div class="row m-0 p-0 mt-0 ">
    <div class="col-12 col-sm-12 p-3 p-sm-3 mb-3 mb-sm-3 shadow">
        <section>
            <!-- on masque le titre de la page. Balise H1 aide au référencement Google-->
            <h1><?=$produit->pro_libelle;?></h1>
           
            <article class="w-100 w-sm-100">
            <div class="d-flex justify-content-center">
                <img src="./jarditou_css/src/img/<?php echo $produit->pro_id.'.'.$produit->pro_photo; ?>" class="img-responsive-details img-thumbnail"
                      alt="<?php echo $produit->cat_nom." ".$produit->pro_libelle; ?>" title="<?php echo $produit->cat_nom." ".$produit->pro_libelle; ?>" />
            </div>

                <!--Début du Formulaire---------------------------------------->
                <form method="POST" action="#"
                    id="formulaire_details" name="formulaire_details" class="form-block">
                    <div class="form-group ">

                            <div class="form-row">
                                <div class="col">
                                    <lable for="name">R&eacute;f&eacute;rence :</lable>
                                    <input type="text" class="form-control form-control-sm" name="pro_ref" id="pro_ref" value="<?php echo $produit->pro_ref; ?>" disabled />
                                    <div id="errorRef" class="text-danger"></div>
                                </div>
                                <!--fin de col-->
                            </div>
                            <!--fin de form-row-->

                            <div class="form-row">
                                <div class="col">
                                    <lable for="name">Cat&eacute;gorie :</lable>
                                    <input type="text" class="form-control form-control-sm" name="cat_nom" id="cat_nom" value="<?php echo $produit->cat_nom; ?>" disabled />
                                    <div id="errorCat" class="text-danger"></div>
                                </div>
                                </div>
                            <!--fin de form-row-->

                                <div class="form-row">
                                <div class="col">
                                    <lable for="name">Libell&eacute; :</lable>
                                    <input type="text" class="form-control form-control-sm" name="pro_libelle" id="pro_libelle" value="<?php echo $produit->pro_libelle; ?>" disabled />
                                    <div id="errorLib" class="text-danger"></div>
                                </div>
                                <!--fin de col-->
                            </div>
                            <!--fin de form-row-->

                            <div class="form-row">
                                <div class="col">
                                    <lable for="name">Description :</lable>
                                   <textarea class="form-control form-control-sm" name="pro_description" id="pro_description" disabled><?php echo $produit->pro_description; ?></textarea>
                                    <div id="errorDesc" class="text-danger"></div>
                                </div>
                                <!--fin de col-->
                            </div>
                            <!--fin de form-row-->

                            <div class="form-row">
                                <div class="col">
                                    <lable for="name">Prix :</lable>
                                    <input type="text" class="form-control form-control-sm" name="pro_prix" id="pro_prix" value="<?php echo $produit->pro_prix; ?>" disabled />
                                    <div id="errorPrix" class="text-danger"></div>
                                </div>
                                <!--fin de col-->
                            </div>
                            <!--fin de form-row-->
                            
                            <div class="form-row">
                                <div class="col">
                                    <lable for="pro_stock">Stock : <?php if ($produit->pro_stock==0) echo "<img src='./jarditou_css/src/img/attention.jpg' class='icon' alt='Attention! Rupture de stock!' title='Attention! Rupture de stock.' />"; ?></lable>
                                    <input type="number" class="form-control form-control-sm" name="pro_stock" id="pro_stock" value="<?php echo $produit->pro_stock; ?>" disabled />
                                    <div id="errorStock" class="text-danger"></div>
                                </div>
                                <!--fin de col-->
                            </div>
                            <!--fin de form-row-->

                            <div class="form-row">
                                <div class="col">
                                    <lable for="pro_couleur">Couleur :</lable>
                                    <input type="text" class="form-control form-control-sm" name="pro_couleur" id="pro_couleur" value="<?php echo $produit->pro_couleur; ?>" disabled />
                                    <div id="errorDesc" class="text-danger"></div>
                                </div>
                                <!--fin de col-->
                            </div>
                            <!--fin de form-row-->

                            <div class="form-row">
                                <div class="col">
                                    Produit bloqué?

                                    <div class="custom-control custom-radio custom-control-inline">
  <input type="radio" id="pro_yes" name="pro_bloque" class="custom-control-input" <?php if(($produit->pro_bloque)!==null) echo "checked"; ?> disabled />
  <label class="custom-control-label" for="customRadioInline1">Oui</label>
</div>
<div class="custom-control custom-radio custom-control-inline">
  <input type="radio"id="pro_no" name="pro_bloque" class="custom-control-input" <?php if(($produit->pro_bloque)==null) echo "checked"; ?> disabled />
  <label class="custom-control-label" for="customRadioInline2">Non</label>
</div>
                                    <div id="errorBloq" class="text-danger"></div>
                                </div>
                                <!--fin de col-->
                            </div>
                            <!--fin de form-row-->

                            <div class="form-row">
                                <div class="col">
                                    <lable for="pro_d_ajout">Date d'ajout :</lable>
                                    <input type="text" class="form-control form-control-sm" name="pro_d_ajout" id="pro_d_ajout" value="<?php echo $produit->pro_d_ajout; ?>" disabled />
                                </div>
                                <!--fin de col-->
                            </div>
                            <!--fin de form-row-->

                            <div class="form-row">
                                <div class="col">
                                    <lable for="pro_modif">Date de modification :</lable>
                                    <input type="text" class="form-control form-control-sm" name="pro_d_ajout" id="pro_d_ajout" value="<?php echo $produit->pro_d_modif; ?>" disabled />
                                </div>
                                <!--fin de col-->
                            </div>
                            <!--fin de form-row-->

                            <div class="form-row">
                                <div class="col">
                                    <a href='tableau.php' class="btn btn-dark" name="btn_retour_tab" id="btn_retour_tab">Retour</a>
                                    <a href='update.php?pro_id=<?php echo $produit->pro_id; ?>' class="btn btn-warning" name="btn_suppr" id="btn_modif">Modifier</a>
                                    <a href='delete.php?pro_id=<?php echo $produit->pro_id; ?>' class="btn btn-danger" name="btn_suppr" id="btn_suppr">Supprimer</a>
                                </div>
                                <!--fin de col-->
                            </div>
                    </div>
                    <!--fin de div .form-group-->
                </form>
                <!--fin de form -->
            </article>
        </section>
    </div> <!-- fin de col-->
</div> <!-- fin de row-->





<?php 
unset($produit);
include 'footer.php'; ?>
