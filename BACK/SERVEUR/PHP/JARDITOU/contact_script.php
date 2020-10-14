<?php

//on met toute la variable $_POST dans un objet
$contact=(object)$_POST;

//tableau d'erreurs qui seront par la suite notifiées dans l'URL 
$tabError=array();

//--------VERIFICATION DU NOM----------------
$contact->name=strip_tags($contact->name);
// on vérifie si un nom a été entrée
if(empty($contact->name)){
  $tabError[]="Err_name=0";
}else{
  //on vérifie que le nom entré est valable (voir regex)
  if(!preg_match(("/^[A-Za-z\-\sáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ\d]{1,20}$/"), $contact->name)){
    $tabError[]="Err_name=1";
  }
}



//--------VERIFICATION DU PRENOM---------------------------
$contact->surname=strip_tags($contact->surname);
// on vérifie si un prénom a été entrée
if($contact->surname==""){
  $tabError[]="Err_surname=0";
}else{
  //on vérifie que le prenom entré est valable (voir regex)
  if(!preg_match(("/^[A-Za-z\-\sáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ\d]{1,20}$/"), $contact->surname)){
    $tabError[]="Err_surname=1";
  }
}


//--------VERIFICATION DU SEXE----------------
if(!isset($contact->sex)){
  $tabError[]="Err_sex=0";
}


//--------VERIFICATION DE LA DATE DE NAISSANCE----------------------------
// on vérifie si une DOB a été entrée
if($contact->DOB==""){
  $tabError[]="Err_DOB=0";
}else{
  date_default_timezone_set('Europe/Paris');
  $today=date("Y-m-d");
  if($contact->DOB>=$today){
    $tabError[]="Err_DOB=1";
  }
}


//--------VERIFICATION DE L'ADRESSE----------------------------
//N.B. champ adresse non obligatoire
if(!empty($contact->address)){
  $contact->address=strip_tags($contact->address);
  if(!preg_match("/^[\wáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ\s\d\#\(\)\.\,\_\-]{1,149}$/", $contact->address)){
    $tabError[]="Err_address=0";
  }
}



//--------VERIFICATION DU CODE POSTAL----------------
// on supprime les potentielles balises HTML que l'utlisateur aurait entré
$contact->postcode=strip_tags($contact->postcode);
//on vérifie que le code postal entrée est valable (voir regex)
if($contact->postcode==""){
  $tabError[]="Err_postcode=0";
}elseif(!preg_match(("/^[\d]{5}$/"), $contact->postcode)){
  $tabError[]="Err_postcode=0";
}


//--------VERIFICATION DE LA VILLE----------------
//N.B. champ ville non obligatoire
$contact->city=strip_tags($contact->city);
if(!empty($contact->city)){
  //on vérifie que la ville entrée est valable (voir regex)
  if(!preg_match(("/^[a-zA-Z\-\sáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ\s\d\(\)\.\-\/]{1,30}$/"), $contact->city)){
    $tabError[]="Err_city=0";
  }
}


//--------VERIFICATION DE L'EMAIL----------------
$contact->email=strip_tags($contact->email);
// on vérifie si un email a été entrée
if(empty($contact->email)){
  $tabError[]="Err_email=0";
}else{
  //on vérifie que la ville entrée est valable (voir regex)
  if(!preg_match(("/^[a-zA-Z0-9._-]+(.[a-zA-Z0-9._-]+)+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,3}$/"), $contact->email)){
    $tabError[]="Err_email=1";
  }
}

//--------VERIFICATION DU SUJET----------------
if(!isset($contact->subject)){
  $tabError[]="Err_subject=0";
  
}

//--------VERIFICATION DE LA QUESTION----------------
if(!isset($contact->question)){
  $tabError[]="Err_question=0";
}else{
  $contact->question=strip_tags($contact->question);
  //on vérifie que la ville entrée est valable (voir regex)
  if(!preg_match("/^[\w\-\sáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ\s\d\#\$\(\)\[\]\+\*\.\,\_\-]{1,400}$/", $contact->question)){
    $tabError[]="Err_question=1";
  }
}


//--------VERIFICATION DE LA CHECKBOX TRAITEMENT----------------
if(!isset($contact->traitement)){
  $tabError[]="Err_traitement=0";
}




//--------------------------------------------------------------
//On met le tableau d'erreurs dans une STRING, chaque élément du tableau est maintenant séparé par '&&'
$listError=implode('&&',$tabError);

if($listError!=""){
  $listData="name=".$contact->name."&&surname=".$contact->surname."&&sex=".$contact->sex."&&DOB=".$contact->DOB."&&address=".$contact->address."&&postcode=".$contact->postcode."&&city=".$contact->city."&&email=".$contact->email."&&subject=".$contact->subject."&&question=".$contact->question;
  header("Location:contact.php?$listData&&$listError");
  exit();
}else{
  header("Location:contact.php?envoi=ok");
  exit();
}

?>