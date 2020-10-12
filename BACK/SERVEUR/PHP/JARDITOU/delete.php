<?php
//on nettoie le cache
header("Cache-Control: no-cache, must-revalidate" );
include 'header.php';



//-----SI l'ID PRODUIT EST INTROUVABLE, ON AFFICHE UN MSG D'ERREUR---------
if(empty($_GET["pro_id"])){
    echo"<p class='lead text-danger'>Impossible de récupérer les informations concernant ce produit. Identifiant produit introuvable.</p>";
}else { 


     //paramétrage de la base de données
    require "connexion_db.php";

    //connexion à la base de données
    $db = connexionBase();

    $requeteProduit = $db->prepare("SELECT pro_photo, pro_libelle, pro_ref FROM produits where produits.pro_id=:pro_id");
    $requeteProduit->bindValue(":pro_id", $_GET["pro_id"]);
    $requeteProduit->execute();
    $produit=$requeteProduit->fetch();
    $requeteProduit->closeCursor();


?>

<div class="row m-0 p-0 mt-0 ">
    <div class="col-12 col-sm-12 p-3 p-sm-3 mb-3 mb-sm-3 shadow">
        <section>
            <h1>Suppression d'un produit</h1>

            <article class="w-100 w-sm-100">

                <!--Début du Formulaire---------------------------------------->
                <form method="POST" action="delete_script.php" id="form_DEL_produit" name="form_DEL_produit"
                    class="form-block" enctype="multipart/form-data">
                    <div class="form-group ">

                        <!--AFFICHAGE DE L'IDENTIFIANT DU PRODUIT ET DE L'EXTENSION PHOTO EN HIDDEN---->
                        <input type='hidden' name="pro_id" id="pro_id" value="<?=$_GET['pro_id'];?>">
                        <input type='hidden' name="pro_photo" id="pro_photo" value="<?=$produit->pro_photo;?>">

                        <!--AFFICHAGE DE L'IMAGE DU PRODUIT---->
                        <div class="form-row mt-1">
                            <div class="col">
                            <div class="lead m-3">&Ecirc;tes-vous s&ucirc;r(e) de vouloir supprimer le produit &laquo; <?=$produit->pro_libelle;?> &raquo; (r&eacute;f: <i><?=$produit->pro_ref;?></i>) ?</div>
                            <?php
                                if (!empty($produit->pro_photo)){
                                    ?>
                                <input type='hidden' name="pro_photo" id="pro_photo" value="<?=$produit->pro_photo;?>">
                                <label for="pro_id" hidden></label>
                                <div class="d-flex justify-content-center">
                                    <img src="./jarditou_css/src/img/<?=$_GET['pro_id'].'.'.$produit->pro_photo;?>"
                                        class="img-responsive-details img-thumbnail"
                                        alt="<?=$produit->pro_libelle;?>" title="<?=$produit->pro_libelle;?>" />
                                </div>
                                <?php } ?>
                           
                        <!------ AFFICHAGE DES OUI ET NON ------>
                        <div class="form-row mt-3 ">
                            <div class="col d-flex justify-content-center">
                            <input type='submit' name="btn_enregistrer" id="btn_enregistrer" value='Oui'
                                    class="btn btn-success" />
                                <a href='details.php?pro_id=<?=$_GET['pro_id'];?>' class="btn btn-danger ml-2"
                                    name="btn_retour_tab" id="btn_retour_tab">Non</a>
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
} //accolade de la fin du ELSE (en case d'erreur ID INTROUVABLE) 
 include 'footer.php';?>