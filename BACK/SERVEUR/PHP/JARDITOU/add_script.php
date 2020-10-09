<?php
//paramétrage de la base de données
require "connexion_db.php";
//connexion à la base de données
$db = connexionBase();

$pro_cat_id=$_POST['pro_cat_id'];
 date_default_timezone_set('Europe/Paris');
 $pro_d_ajout=date("Y-m-d");

  //requête retournant la liste des référence de produits
$requeteReferences = $db->prepare("SELECT pro_ref FROM produits");
$requeteReferences->execute();

//$tab_Ref[] représente un tableau des références déjà utilisées. On ne prend pas en compte la référénce du produit en cours dans le cas où l'utilisateur choisit de ne pas modifier la référence produit
$tab_Ref=array();
while ($ligneRef = $requeteReferences->fetch()) {
    $tab_Ref[]=$ligneRef->pro_ref;
}
$requeteReferences->closeCursor();

//tableau d'erreurs qui seront par la suite notifiées dans l'URL 
$tabError=array();
 

//--------VERIFICATION DE LA REFERENCE PRODUIT----------------
$pro_ref=strip_tags($_POST['pro_ref']);
// on vérifie si une nouvelle référence a été entrée
if(empty($pro_ref)){
  $tabError[]="Err_ref=0";
}else{
  // on vérifie si la nouvelle référence n'existe pas déjà (pro_ref doit être unique)
  if(array_search($pro_ref,$tab_Ref)){
    $tabError[]="Err_ref=1";
  }else{
    //on vérifie que la reférence entrée est valable (voir regex)
    if(!preg_match("/^[\w]{1}+([\wáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ\s\d\#\$\(\)\[\]\+\*\.\_\-]{1,9})$/", $pro_ref)){
      $tabError[]="Err_ref=2";
    }
  }
}


//--------VERIFICATION DU LIBELLE PRODUIT---------------------------
$pro_libelle=strip_tags($_POST['pro_libelle']);
// on vérifie si un nouveau libellé a été entrée
if($pro_libelle==""){
  $tabError[]="Err_libelle=0";
}else{
  //on vérifie que le libellé entré est valable (voir regex)
  if(!preg_match("/^[\wáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]{1}+([\wáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ\s\d\.\_\-\#\!\?\,\:]{1,199})$/", $pro_libelle)){
    $tabError[]="Err_libelle=1";
  }
}


//--------VERIFICATION DE LA DESCRIPTION DU PRODUIT----------------
// on supprime les potentielles balises HTML que l'utlisateur aurait entré dans la description
$pro_description=strip_tags($_POST['pro_description']);


//--------VERIFICATION DU PRIX DU PRODUIT----------------------------
$pro_prix=strip_tags($_POST['pro_prix']);
// on vérifie si un nouveau prix a été entré
if($pro_prix==""){
  $tabError[]="Err_prix=0";
}else{
  //on transforme la STRING $_POST['pro_prix'] en FLOAT
  $pro_prix_float=floatval($pro_prix);
  // on vérifie qu'il s'agisse d'un chiffre
  if(is_nan($pro_prix_float)){
    $tabError[]="Err_prix=1";
  }else if($pro_prix_float<0) $tabError[]="Err_prix=2";
}


//--------VERIFICATION DU STOCK DU PRODUIT----------------------------
$pro_stock=strip_tags($_POST['pro_stock']);
// on vérifie si un nouveau stock a été entré
if($pro_stock==""){
  $tabError[]="Err_stock=0";
}else{
  //on transforme la STRING $_POST['pro_stock'] en INT
  $pro_stock_int=intval($pro_stock);
  // on vérifie qu'il s'agisse d'un chiffre
  if(is_nan($pro_stock_int)){
    $tabError[]="Err_stock=1";
  }else if($pro_stock_int<0) $tabError[]="Err_stock=2";
}


//--------VERIFICATION DE LA COULEUR DU PRODUIT----------------
// on supprime les potentielles balises HTML que l'utlisateur aurait entré
$pro_couleur=strip_tags($_POST['pro_couleur']);
//on vérifie que la reférence entrée est valable (voir regex)
if(!preg_match("/^[\w]{1}+([\w\s]{1,29})$/", $pro_couleur)){
  $tabError[]="Err_couleur=0";
}

//--------VERIFICATION DU BLOQUAGE PRODUIT----------------

if(isset($_POST['pro_bloque'])){
    if($_POST['pro_bloque']=='1'){
        $pro_bloque=1;
    }else $pro_bloque=0;
}else $tabError[]="Err_bloque=0";


//--------VERIFICATION + UPLOAD DE L'IMAGE----------------
$uploadOk=false;
if(!empty($_FILES["photoProduit"]['name'])){
    

    // On vérifie si l'image est vraiment une image
    if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["photoProduit"]["tmp_name"]);
    if($check == false) {
        $tabError[]="File is not an image.";
        $uploadOk = false;
    }
    }

    // On limite la taille maximale du fichier image (max size = 500 KB)
    if ($_FILES["photoProduit"]["size"] > 500000) {
    $tabError[]="Err_photo=1";
    $uploadOk = false;
    }

    // On n'autorise que certains types de fichiers image (ici, ce sera .jpeg, .jpg, .gif et .png)
    $tabMimeTypes = array("image/gif", "image/jpeg", "image/pjpeg", "image/x-png", "image/tiff", "image/png");
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimetype = finfo_file($finfo, $_FILES["photoProduit"]["tmp_name"]);
    finfo_close($finfo);
    if (!(in_array($mimetype, $tabMimeTypes))){
    $tabError[]="Sorry, only JPG, JPEG, PNG, TIFF & GIF files are allowed.";
    $uploadOk = false;
    } else $uploadOk = true;

}
//--------------------------------------------------------------
//On met le tableau d'erreurs dans une STRING, chaque élément du tableau est maintenant séparé par '&&'
$listError=implode('&&',$tabError);

if($listError!=""){
  $listData="pro_id=".$pro_id."&&pro_cat_id=".$pro_cat_id."&&pro_ref=".$pro_ref."&&pro_libelle=".$pro_libelle."&&pro_description=".$pro_description."&&pro_prix=".$pro_prix."&&pro_stock=".$pro_stock."&&pro_couleur=".$pro_couleur."&&pro_bloque=".$pro_bloque."&&pro_photo=".$pro_photo;
  header("Location:add.php?$listData&&$listError");
  exit();
}else{
  //construction de la requête INSERT sans injection SQL
  $requete = $db->prepare("INSERT INTO produits VALUES
  pro_cat_id=:pro_cat_id,
  pro_ref=:pro_ref,
  pro_libelle=:pro_libelle,
  pro_description=:pro_description,
  pro_prix=:pro_prix,
  pro_stock=:pro_stock,
  pro_couleur=:pro_couleur,
  pro_d_ajout=:pro_d_ajout");


  $requeteADD->bindValue(':pro_cat_id', $pro_cat_id, PDO::PARAM_INT);
  $requeteADD->bindValue(':pro_ref', $pro_ref, PDO::PARAM_STR);
  $requeteADD->bindValue(':pro_libelle', $pro_libelle, PDO::PARAM_STR);
  $requeteADD->bindValue(':pro_description', $pro_description, PDO::PARAM_STR);
  $requeteADD->bindValue(':pro_prix', $pro_prix_float, PDO::PARAM_INT);
  $requeteADD->bindValue(':pro_stock', $pro_stock_int, PDO::PARAM_INT);
  $requeteADD->bindValue(':pro_couleur', $pro_couleur, PDO::PARAM_STR);
  $requeteADD->bindValue(':pro_bloque', $pro_bloque, PDO::PARAM_INT);
  $requeteADD->bindValue(':pro_d_ajout',$pro_d_ajout, PDO::PARAM_STR);
  $requeteADD->execute();
  //libère la connection au serveur de BDD
  $requeteADD->closeCursor();




// Si $uploadOk est resté à TRUE, on peut avancer dans l'upload de la photo ainsi que son enregistrement dans la base de données

if(!empty($_FILES['photo']['name'])){
if ($uploadOk){
    //on va chercher l'id du nouveau produit
    $requeteGET = $db->prepare("SELECT pro_id produits WHERE pro_ref=:pro_ref");
    $requeteGET->bindValue(':pro_ref',$pro_ref, PDO::PARAM_STR);
    $requeteGET->execute();

    $pro_photo=$_FILES["photoProduit"]["type"];
    $pro_id=$requeteGET->fetch();
    $requeteGET->closeCursor();
    $target_file = "jarditou_css/src/img/".$pro_id.".".$pro_photo;
    if(move_uploaded_file($_FILES["photoProduit"]["tmp_name"], $target_file)){
    $requeteMAJ = $db->prepare("UPDATE produits SET pro_photo=:pro_photo WHERE pro_id=:pro_id;");
    $requeteMAJ->bindValue(':pro_photo',$pro_photo, PDO::PARAM_STR);
    $requeteMAJ->bindValue(':pro_id', $pro_id, PDO::PARAM_INT);
    $requeteMAJ->closeCursor();
    clearstatcache();
  }
}
}
  header("Location:tableau.php?pro_id=$pro_id&&ajout=ok");
  exit();

  
}


?>