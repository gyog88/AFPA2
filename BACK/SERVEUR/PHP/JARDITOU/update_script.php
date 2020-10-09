<?php


  //paramétrage de la base de données
  require "connexion_db.php";
  //connexion à la base de données
  $db = connexionBase();

 $pro_id= $_POST['pro_id'];
 $pro_cat_id=$_POST['pro_cat_id'];
 date_default_timezone_set('Europe/Paris');
 $pro_d_modif=date("Y-m-d H:i:s");
 $pro_photo=$_POST['pro_photo'];

  //requête retournant la liste des référence de produits
$requeteReferences = $db->prepare("SELECT pro_ref FROM produits WHERE pro_id!=:pro_id");
$requeteReferences->bindValue(":pro_id", $pro_id);
$requeteReferences->execute();

//$tab_Ref[] représente un tableau des références déjà utilisées. On ne prend pas en compte la référénce du produit en cours dans le cas où l'utilisateur choisit de ne pas modifier la référence produit
$tab_Ref=array();
while ($ligneRef = $requeteReferences->fetch()) {
    $tab_Ref[]=$ligneRef->pro_ref;
}

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

if($_POST['pro_bloque']=='1'){
  $pro_bloque=1;
}else $pro_bloque=0;


//--------VERIFICATION + UPLOAD DE L'IMAGE----------------

if(!empty($_FILES["photoProduit"]['name'])){
$target_dir = "jarditou_css/src/img/";
$target_file = $target_dir.basename($_FILES["photoProduit"]["name"]);
$uploadOk = true;
$imageFileType = substr(strrchr($_FILES["photoProduit"]["name"], "."), 1);
$renamed_target_file=$target_dir.$pro_id.'.'.$imageFileType;

// On vérifie si l'image est vraiment une image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["photoProduit"]["tmp_name"]);
  if($check == false) {
    $tabError[]="File is not an image.";
    $uploadOk = false;
  }
}

$effacerImage=false;
// On vérifie s'il y a déjà une image pour ce produit. Si oui, on la supprimera pour la remplacer
if (file_exists($_POST['pro_id'].'.'.$_POST['pro_photo'])) {
  $effacerImage= true;
}

// On limite la taille maximale du fichier image (max size = 800 KB)
if ($_FILES["photoProduit"]["size"] > 1000000) {
  $tabError[]="Sorry, your file is too large.";
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
}

// Si $uploadOk est resté à TRUE, on peut avancer dans l'upload
if ($uploadOk){
  if($effacerImage){
    unlink($_POST['pro_id'].'.'.$_POST['pro_photo']);
  }
  move_uploaded_file($_FILES["photoProduit"]["tmp_name"], $renamed_target_file);
  $pro_photo=$_FILES["photoProduit"]["type"];
  clearstatcache();
}
}
//--------------------------------------------------------------
//On met le tableau d'erreurs dans une STRING, chaque élément du tableau est maintenant séparé par '&&'
$listError=implode('&&',$tabError);

if($listError!=""){
  $listData="pro_id=".$pro_id."&&pro_cat_id=".$pro_cat_id."&&pro_ref=".$pro_ref."&&pro_libelle=".$pro_libelle."&&pro_description=".$pro_description."&&pro_prix=".$pro_prix."&&pro_stock=".$pro_stock."&&pro_couleur=".$pro_couleur."&&pro_bloque=".$pro_bloque."&&pro_photo=".$pro_photo;
  header("Location:update.php?$listData&&$listError");
  exit();
}else{
  //construction de la requête UPDATE sans injection SQL
  $requete = $db->prepare("UPDATE produits SET
  pro_cat_id=:pro_cat_id,
  pro_ref=:pro_ref,
  pro_libelle=:pro_libelle,
  pro_description=:pro_description,
  pro_prix=:pro_prix,
  pro_stock=:pro_stock,
  pro_couleur=:pro_couleur,
  pro_bloque=:pro_bloque,
  pro_photo=:pro_photo,
  pro_d_modif=:pro_d_modif
  WHERE pro_id=:pro_id");


  $requete->bindValue(':pro_cat_id', $pro_cat_id, PDO::PARAM_INT);
  $requete->bindValue(':pro_ref', $pro_ref, PDO::PARAM_STR);
  $requete->bindValue(':pro_libelle', $pro_libelle, PDO::PARAM_STR);
  $requete->bindValue(':pro_description', $pro_description, PDO::PARAM_STR);
  $requete->bindValue(':pro_prix', $pro_prix_float, PDO::PARAM_INT);
  $requete->bindValue(':pro_stock', $pro_stock_int, PDO::PARAM_INT);
  $requete->bindValue(':pro_couleur', $pro_couleur, PDO::PARAM_STR);
  $requete->bindValue(':pro_bloque', $pro_bloque, PDO::PARAM_INT);
  $requete->bindValue(':pro_photo',$pro_photo, PDO::PARAM_STR);
  $requete->bindValue(':pro_d_modif',$pro_d_modif, PDO::PARAM_STR);
  $requete->bindValue(':pro_id',  $pro_id, PDO::PARAM_INT);
  $requete->execute();

  //libère la connection au serveur de BDD
  $requete->closeCursor();

  header("Location:tableau.php?pro_id=$pro_id&&modif=ok");
  exit();

  
}


?>