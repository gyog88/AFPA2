<?php
function connexionBase(){
//vérifie si on désire se diriger vers le serveur dev.amorce.org ou bien vers le serveur local
//dans ce cas, host,login, password et BDD sont différents d'un serveur à l'autre


// Paramètres de connexion serveur distant
if ($_SERVER["SERVER_NAME"] == "dev.amorce.org") {
        $host = "localhost";
        $login= "gguilbert";     // Votre loggin d'accès au serveur de BDD 
        $password="gg20104";    // Le Password pour vous identifier auprès du serveur
        $base = "gguilbert";    // La BDD avec laquelle vous voulez travailler 
    }

     // Paramètres de connexion serveur local
    if (($_SERVER["SERVER_NAME"] == "developpementwebafpa")||($_SERVER["SERVER_NAME"] == "127.0.0.1")){   
        $host = "localhost";
        $login= "root";     // Votre login d'accès au serveur de BDD 
        $password="";    // Le Password pour vous identifier auprès du serveur
        $base = "jarditou";    // La bdd avec laquelle vous voulez travailler 
    }
    // https://regexone.com/lesson/whitespaces

    try{
        $db = new PDO("mysql:host=$host;charset=utf8;dbname=$base", $login, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        
    }

    catch (Exception $e) {
         echo "La connexion à la base de données a échoué !<br>";
         echo "Merci de bien vérifier vos paramètres de connexion...<br>";
        echo "Erreur : ".$e->getMessage()."<br>";
         echo "N° : ".$e->getCode()."<br>";
        die("Fin du script");
   }

   return $db;

}

?>