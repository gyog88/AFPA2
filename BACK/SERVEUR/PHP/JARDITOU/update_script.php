<?php

  //paramétrage de la base de données
  require "connexion_db.php";
  //connexion à la base de données
  $db = connexionBase();
  $produit=(object)$_POST;
  
  //requête retournant la liste des référence de produits
$requeteReferences = $db->prepare("SELECT pro_ref FROM produits WHERE pro_id!=:pro_id");
$requeteReferences->bindValue(":pro_id", $produit->pro_id);
$requeteReferences->execute();

//$tab_Ref[] représente un tableau des références déjà utilisées. On ne prend pas en compte la référénce du produit en cours dans le cas où l'utilisateur choisit de ne pas modifier la référence produit
$tab_Ref=array();
while ($ligneRef = $requeteReferences->fetch()) {
    $tab_Ref[]=$ligneRef->pro_ref;
}

//tableau d'erreurs qui seront par la suite notifiées dans l'URL 
$tabError=array();
 

//--------VERIFICATION DE LA REFERENCE PRODUIT----------------
$produit->pro_ref=strip_tags($produit->pro_ref);
// on vérifie si une nouvelle référence a été entrée
if(empty($produit->pro_ref)){
  $tabError[]="Err_ref=0";
}else{
  // on vérifie si la nouvelle référence n'existe pas déjà (pro_ref doit être unique)
  if(array_search($produit->pro_ref,$tab_Ref)){
    $tabError[]="Err_ref=1";
  }else{
    //on vérifie que la reférence entrée est valable (voir regex)
    if(!preg_match("/^[\w]{1}+([\wáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ\s\d\#\$\(\)\[\]\+\*\.\_\-]{1,9})$/", $produit->pro_ref)){
      $tabError[]="Err_ref=2";
    }
  }
}


//--------VERIFICATION DU LIBELLE PRODUIT---------------------------
$produit->pro_libelle=strip_tags($produit->pro_libelle);
// on vérifie si un nouveau libellé a été entrée
if($produit->pro_libelle==""){
  $tabError[]="Err_libelle=0";
}else{
  //on vérifie que le libellé entré est valable (voir regex)
  if(!preg_match("/^[\wáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]{1}+([\wáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ\s\d\.\_\-\#\!\?\,\:]{1,199})$/", $produit->pro_libelle)){
    $tabError[]="Err_libelle=1";
  }
}


//--------VERIFICATION DE LA DESCRIPTION DU PRODUIT----------------
// on supprime les potentielles balises HTML que l'utlisateur aurait entré dans la description
$produit->pro_description=strip_tags($produit->pro_description);


//--------VERIFICATION DU PRIX DU PRODUIT----------------------------
$produit->pro_prix=strip_tags($produit->pro_prix);
// on vérifie si un nouveau prix a été entré
if($produit->pro_prix==""){
  $tabError[]="Err_prix=0";
}else{
    //on gère aussi le problème virgule VS point pour le décimal
    if(strstr($produit->pro_prix, ",")) {
      $produit->pro_prix=str_replace(',','.',$produit->pro_prix);
    }
    $produit->pro_prix =number_format($produit->pro_prix, 2, '.', ' ');
  if(is_nan($produit->pro_prix)){
    $tabError[]="Err_prix=1";
  }elseif($produit->pro_prix<0) $tabError[]="Err_prix=2";  //on vérifie que le prix entré est un chiffre positif
}


//--------VERIFICATION DU STOCK DU PRODUIT----------------------------
$produit->pro_stock=strip_tags($produit->pro_stock);
// on vérifie si un nouveau stock a été entré
if($produit->pro_stock==""){
  $tabError[]="Err_stock=0";
}else{
  //on transforme la STRING $_POST['pro_stock'] en INT
  $pro_stock_int=intval($produit->pro_stock);
  // on vérifie qu'il s'agisse d'un chiffre
  if(is_nan($pro_stock_int)){
    $tabError[]="Err_stock=1";
  }else if($pro_stock_int<0) $tabError[]="Err_stock=2";
}


//--------VERIFICATION DE LA COULEUR DU PRODUIT----------------
// on supprime les potentielles balises HTML que l'utlisateur aurait entré
$produit->pro_couleur=strip_tags($produit->pro_couleur);
//on vérifie que la reférence entrée est valable (voir regex)
if(!preg_match("/^[\w]{1}+([\w\s]{1,29})$/", $produit->pro_couleur)){
  $tabError[]="Err_couleur=0";
}

//--------VERIFICATION DU BLOQUAGE PRODUIT----------------

if($produit->pro_bloque=='1'){
  $pro_bloque=1;
}else $pro_bloque=0;


//--------VERIFICATION + UPLOAD DE L'IMAGE----------------

if(!empty($_FILES["photoProduit"]['name'])){
$target_dir = "jarditou_css/src/img/";
$target_file = $target_dir.basename($_FILES["photoProduit"]["name"]);
$uploadOk = true;
$imageFileType = substr(strrchr($_FILES["photoProduit"]["name"], "."), 1);
$renamed_target_file=$target_dir.$produit->pro_id.'.'.$imageFileType;

// On vérifie si l'image est vraiment une image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["photoProduit"]["tmp_name"]);
  if($check == false) {
    $tabError[]="Err_pro_photo=0";
    $uploadOk = false;
  }
}

// On limite la taille maximale du fichier image (max size = 500 KB)
if ($_FILES["photoProduit"]["size"] > 500000) {
  $tabError[]="Err_pro_photo=1";
  $uploadOk = false;
}

// On n'autorise que certains types de fichiers image (ici, ce sera .jpeg, .jpg, .gif et .png)
$extension = pathinfo($_FILES["photoProduit"]["name"], PATHINFO_EXTENSION);
$tabExtensions = array("jpg", "jpeg", "png");
if (!(in_array($extension, $tabExtensions))){
  $tabError[]="Err_pro_photo=2";
  $uploadOk = false;
}

// Si $uploadOk est resté à TRUE, on peut avancer dans l'upload
if ($uploadOk){

  //on efface l'ancienne image (si elle existe)
  if (file_exists($produit->pro_id.'.'.$produit->pro_photo)) {
    unlink($produit->pro_id.'.'.$produit->pro_photo);
  }

  move_uploaded_file($_FILES["photoProduit"]["tmp_name"], $renamed_target_file);
  $produit->pro_photo= $extension;
}
}

//--------------------------------------------------------------
//On met le tableau d'erreurs dans une STRING, chaque élément du tableau est maintenant séparé par '&&'
$listError=implode('&&',$tabError);

if($listError!=""){
    //on récupère le nom de catégorie du produit
    $requeteCat = $db->prepare("SELECT cat_nom FROM categories WHERE categories.cat_id=:pro_cat_id");
    $requeteCat->bindValue(":pro_cat_id", $produit->pro_cat_id, PDO::PARAM_INT);
    $requeteCat->execute();
    $cat_nom= $requeteCat->fetch();
    $requeteCat->closeCursor();

    $listData="pro_id=".$produit->pro_id."&&pro_cat_id=".$produit->pro_cat_id."&&pro_cat_nom=".$produit->pro_cat_nom."&&pro_ref=".$produit->pro_ref."&&pro_libelle=".$produit->pro_libelle."&&pro_description=".$produit->pro_description."&&pro_prix=".$produit->pro_prix."&&pro_stock=".$produit->pro_stock."&&pro_couleur=".$produit->pro_couleur."&&pro_bloque=".$produit->pro_bloque."&&pro_photo=".$produit->pro_photo;
    header("Location:update.php?$listData&&$listError");
    apcu_clear_cache();
    exit();
}else{
  date_default_timezone_set('Europe/Paris');
  $produit->pro_d_modif=date("Y-m-d H:i:s");
 
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


  $requete->bindValue(':pro_cat_id', $produit->pro_cat_id, PDO::PARAM_INT);
  $requete->bindValue(':pro_ref', $produit->pro_ref, PDO::PARAM_STR);
  $requete->bindValue(':pro_libelle', $produit->pro_libelle, PDO::PARAM_STR);
  $requete->bindValue(':pro_description', $produit->pro_description, PDO::PARAM_STR);
  $requete->bindValue(':pro_prix', $produit->pro_prix, PDO::PARAM_STR);
  $requete->bindValue(':pro_stock', $pro_stock_int, PDO::PARAM_INT);
  $requete->bindValue(':pro_couleur', $produit->pro_couleur, PDO::PARAM_STR);
  $requete->bindValue(':pro_bloque', $pro_bloque, PDO::PARAM_INT);
  $requete->bindValue(':pro_photo',$produit->pro_photo, PDO::PARAM_STR);
  $requete->bindValue(':pro_d_modif',$produit->pro_d_modif, PDO::PARAM_STR);
  $requete->bindValue(':pro_id', $produit->pro_id, PDO::PARAM_INT);
  $requete->execute();

  //libère la connexion au serveur de BDD
  $requete->closeCursor();

  header("Location:tableau.php?pro_id=$pro_id&&modif=ok");
  apcu_clear_cache();
  exit();
}
?>