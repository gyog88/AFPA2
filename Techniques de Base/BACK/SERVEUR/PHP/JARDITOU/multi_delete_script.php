<?php
//paramétrage de la base de données
require "connexion_db.php";
//connexion à la base de données
$db = connexionBase();

$nbsuppression=0;
foreach($_POST["pro_id"] as $produit){
  $prod=explode("_",$produit);
$pro_id=$prod[0];
$pro_photo=$prod[1];
  //on supprime le produit dans la base de données
  $requete = $db->prepare("DELETE FROM produits WHERE pro_id=:pro_id");
  $requete->bindValue(":pro_id", $pro_id, PDO::PARAM_INT);
  $requete->execute();
  $requete->closeCursor();

  //on supprime le fichier s'il existe
    $photo="./jarditou/src/img/".$pro_id.".".$pro_photo;
  if(file_exists($photo)){
    unlink($photo);
  }
  $nbsuppression++;
 }

 switch($nbsuppression){
  case(0):
    header("Location:multi_delete.php?supp=0");
    exit();
  break;
  case(1):
    header("Location:multi_delete.php?supp=1");
    exit();
  break;
  case($nbsuppression>1):
    header("Location:multi_delete?supp=2");
  exit(); break;
 }
?>