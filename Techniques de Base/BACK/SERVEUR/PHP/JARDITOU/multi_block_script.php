<?php

if(isset($_POST["pro_id"])){
    //paramétrage de la base de données
    require "connexion_db.php";
    //connexion à la base de données
    $db = connexionBase();

    $nbbloquage=0; //nombre de produits bloqués lors de la MAJ
    $nbdebloquage=0; //nombre de produits débloqués lors de la MAJ

    if(empty($_POST["pro_bloque"])){
        //si la variable $_POST["pro_bloque"],'est pas retournée, cela veut dire qu'aucun produit n'a été caché à OUI pour le blocage. Donc on leur assigne NULL dans la base de données
        foreach($_POST["pro_id"] as $key=>$value){
            //on met à jour la base de données
            $requete = $db->prepare("UPDATE produits SET pro_bloque=NULL WHERE pro_id=:pro_id");
            $requete->bindValue(":pro_id", $value, PDO::PARAM_INT);
            $requete->execute();
            $requete->closeCursor();
            $nbbloquage++;
            
        }
    }
    
    else{
        // $_POST['pro_bloque']; array des ID produits qui sont à bloquer
        //$_POST["pro_id"]; array de TOUS les ID produits affichés sur la page multi_block.php (=les produits visibles sur la page, bloqués ou non)
        $produits_a_bloquer=$_POST['pro_bloque'];
        
        //array_diff($_POST["pro_id"],$_POST['pro_bloque']); //array des ID produits qui ont été bloqué et sont donc à mettre à jour dans la BDD
        $produits_a_debloquer=array_diff($_POST["pro_id"],$produits_a_bloquer); //array des ID produits qui ne sont pas cochés donc sera à débloquer dans la base de données


        foreach($produits_a_bloquer as $key_p_block=>$val_p_block){
        //on met à jour la base de données
        $requete = $db->prepare("UPDATE produits SET pro_bloque=1 WHERE pro_id=:pro_id");
        $requete->bindValue(":pro_id", $val_p_block, PDO::PARAM_INT);
        $requete->execute();
        $requete->closeCursor();
        $nbbloquage++;
        }

        foreach($produits_a_debloquer as $key_p_unblock=>$val_p_unblock){
            //on met à jour la base de données
            $requete = $db->prepare("UPDATE produits SET pro_bloque=NULL WHERE pro_id=:pro_id");
            $requete->bindValue(":pro_id", $val_p_unblock, PDO::PARAM_INT);
            $requete->execute();
            $requete->closeCursor();
            $nbdebloquage++;
        }
    }
    $block=$nbbloquage+$nbdebloquage;
    header("Location:multi_block.php?block=$block");
    exit();


}else echo "Impossible d'accéder aux variables de bloquage.";
?>