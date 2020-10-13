<?php
//paramétrage de la base de données
require "connexion_db.php";
//connexion à la base de données
$db = connexionBase();

  //on supprime le produit dans la base de données
  $requete = $db->prepare("DELETE FROM produits WHERE pro_id=:pro_id");
  $requete->bindValue(":pro_id", $_POST['pro_id'], PDO::PARAM_INT);
  $requete->execute();
  $requete->closeCursor();

  //on supprime le fichier s'il existe
$photo="./jarditou/src/img/".$_POST['pro_id'].".".$_POST['pro_photo'];
  if(file_exists($photo)){
    unlink($photo);
  }
header("Location:delete.php?supp=ok");
exit(); 


?>