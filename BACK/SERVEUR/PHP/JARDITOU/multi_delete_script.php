<?php
//paramétrage de la base de données
require "connexion_db.php";
//connexion à la base de données
$db = connexionBase();

$produit=(object)$_POST['pro_id'];
 while ($produit->pro_id){

$tabProduit=explode("_",$produit->pro_id);
$pro_id=$tabProduit[0];
$pro_photo=$tabProduit[1];
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

 }

header("Location:tableau.php?toutsupp=ok");
exit(); 


?>