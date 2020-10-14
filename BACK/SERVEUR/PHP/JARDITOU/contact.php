<?php include 'header.php'; 



// Si $_GET['pro_id'] est défini, cela veut dire que l'on vient de la page contact_script.php
if(isset($_GET['name'])){
    $contact=(object)$_GET;
}

//-----RECUPERATION DES VARIABLES D'ERREUR DE MODIFICATION----------


//-------ERREUR DE NOM----------------------------------------
$err_name="";
if(isset($contact->Err_name)){
    switch ($contact->Err_name){
        case(0): $err_name="Veuillez entrer un nom.";
        break;
        case(1): $err_name="Veuillez entrer un nom au format correct.";
        break;
    }
}

//-------ERREUR DE PRENOM----------------------------------------
$err_surname="";
if(isset($contact->Err_surname)){
    switch ($contact->Err_surname){
        case(0): $err_surname="Veuillez entrer un pr&eacute;nom.";
        break;
        case(1): $err_surname="Veuillez entrer un pr&eacute;nom au format correct.";
        break;
    }
}
                                    
//-------ERREUR DE SEXE-------------------------------------------
$err_sex="";
if(isset($contact->Err_sex)){
    $err_sex="Veuillez identifier votre sexe.";
}

//-------ERREUR DE LA DATE DE NAISSANCE-------------------------------------------
$err_DOB="";
if(isset($contact->Err_DOB)){
    switch ($contact->Err_DOB){
        case(0): $err_DOB="Veuillez renseigner votre date de naissance.";
        break;
        case(1): $err_DOB="Veuillez renseigner une date de naissance correcte.";
        break;
    }
}

//-------ERREUR DE L'ADRESSE-------------------------------------------
$err_address="";
if(isset($contact->Err_address)){
    $err_address="Veuillez entrer une adresse dans un format correct.";
}

//-------ERREUR DU CODE POSTAL----------------------------------------
$err_postcode="";
if(isset($contact->Err_postcode)){
    switch($contact->Err_postcode){
    case(0): $err_postcode="Veuillez renseigner votre code postal.";
    break;
    case(1): $err_postcode="Veuillez renseigner un code postal valide.";
    break;
    }
}

$err_city="";
if(isset($contact->Err_city)){
    $err_city="Veuillez renseigner une ville dans un format correct.";
}



//-------ERREUR D'EMAIL----------------------------------------
$err_email="";
if(isset($contact->Err_email)){
    switch($contact->Err_email){
    case(0): $err_email="Veuillez renseigner votre adresse email.";
    break;
    case(1): $err_email="Veuillez renseigner une adresse email valide.";
    break;
    }
}

//-------ERREUR DE SUJET----------------------------------------
$err_subject="";
if(isset($contact->Err_subject)){
    $err_subject="Veuillez sélectionner un sujet à votre demande.";
}


//-------ERREUR DE QUESTION----------------------------------------
$err_question="";
if(isset($contact->Err_question)){
    switch($contact->Err_question){
    case(0): $err_question="Quelle est votre question?";
    break;
    case(1): $err_question="Vous avez entré des caractères interdits.";
    break;
    }
}

//-------ERREUR DE CHECKBOX TRAITEMENT----------------------------------------
$err_traitement="";
if(isset($contact->Err_traitement)){
    $err_traitement="Veuillez accepter le traitement informatique de vos données.";
}

?>




<!-- CORPS DE PAGE -->
<div class="row m-0 p-0 mt-0 ">
    <div class="col-12 col-sm-12 p-3 p-sm-3 mb-3 mb-sm-3 shadow">
        <section>
            <!-- on masque le titre de la page. Balise H1 aide au référencement Google-->
            <h1 class="d-none">Contact</h1>
            <article class="w-100 w-sm-100">
                <p><i>* Ces zones sont obligatoires.</i></p>

                <!--Début du Formulaire---------------------------------------->
                <form method="POST" action="contact_script.php"
                    id="form_contact1" name="form_contact1" class="form-block">
                    <div class="form-group ">
                        <fieldset class="pb-4 pb-sm-4">
                            <legend class="h2">Vos coordonnées</legend>

                            <!---INPUT NOM ----->
                            <div class="form-row mt-2">
                                <div class="col">
                                    <lable for="name">Votre Nom* :</lable>
                                    <span id="errorName" class="text-danger"><?=$err_name;?></span>
                                    <input type="text" class="form-control form-control-sm" name="name" id="name" 
                                    <?php if(empty($contact->name)) echo "placeholder='Votre nom'"; else echo "value='".$contact->name."'"; ?> autofocus />
                                    
                                </div>
                            </div>

                            <!---INPUT PRENOM ----->
                            <div class="form-row mt-2">
                                <div class="col">
                                    <label for="surname">Votre Pr&eacute;nom* :</label>
                                    <span id="errorSurname" class="text-danger"><?=$err_surname;?></span>
                                    <input type="text" class="form-control form-control-sm" name="surname" id="surname"
                                    <?php if(empty($contact->surname)) echo "placeholder='Votre pr&eacute;nom'"; else echo "value='".$contact->surname."'"; ?> />
                                </div>
                            </div>

                            <!---INPUT SEXE ----->
                            <div class="form-row mt-2">
                                <div class="col">
                                    Sexe* :
                                    <label class="form-check-label" for="sex">
                                        <input type="radio" class="form-control-input" name="sex" id="sexF"
                                            value="female" <?php if(!empty($contact->sex)){ if($contact->sex=="female") echo "checked";} ?> /> F&eacute;minin
                                    </label>
                                    <label class="form-check-label" for="sex">
                                        <input type="radio" class="form-control-input" name="sex" id="sexM"
                                            value="male"  <?php if(!empty($contact->sex)){ if($contact->sex=="male") echo "checked";} ?> />
                                        Masculin</label>
                                    <div id="errorSex" class="text-danger"><?=$err_sex;?></div>
                                </div>
                            </div>

                            <!---INPUT DATE DE NAISSANCE ----->
                            <div class="form-row mt-2">
                                <div class="col">
                                    <label for="dob">Date de naissance* :</label>
                                    <span id="errorDOB" class="text-danger"><?=$err_DOB;?></span>
                                    <input type="date" class="form-control form-control-sm" id="DOB" name="DOB"
                                    <?php if(!empty($contact->DOB)) echo "value=".$contact->DOB; ?> />
                                </div>
                            </div>
                            
                            <!---INPUT ADRESSE ----->
                            <div class="form-row mt-2">
                                <div class="col">
                                    <label for="address">Adresse :</label>
                                    <span id="errorAddress" class="text-danger"><?=$err_address;?></span>
                                    <input type="text" class="form-control form-control-sm" name="address" id="address"
                                    <?php if(empty($contact->address)) echo "placeholder='Votre adresse'"; else echo "value='".$contact->address."'"; ?> />
                                </div>
                            </div>

                            <!---INPUT CODE POSTAL ----->
                            <div class="form-row mt-2">
                                <div class="col">
                                    <label for="postcode">Code Postal* :</label>
                                    <span id="errorPostCode" class="text-danger"><?=$err_postcode;?></span>
                                    <input type="text" class="form-control form-control-sm" name="postcode"
                                        id="postcode" maxlength="5" 
                                        <?php if(empty($contact->postcode)) echo "placeholder='Votre code postal'"; else echo "value='".$contact->postcode."'"; ?> />
                                </div>
                            </div>

                            <!---INPUT VILLE ----->
                            <div class="form-row mt-2">
                                <div class="col">
                                    <label for="city">Ville :</label>
                                    <span id="errorCity" class="text-danger"><?=$err_city;?></span>
                                    <input type="text" class="form-control form-control-sm" id="city" name="city"
                                    <?php if(empty($contact->city)) echo "placeholder='Votre ville'"; else echo "value='".$contact->city."'"; ?> />
                                 </div>
                            </div>

                            <!---INPUT EMAIL ----->
                            <div class="form-row mt-2">
                                <div class="col">
                                    <label for="email">Email* :</label>
                                    <span id="errorEmail" class="text-danger"><?=$err_email;?></span>
                                    <input type="email" class="form-control form-control-sm" name="email" id="email" 
                                    <?php if(empty($contact->email)) echo "placeholder='john.smith@afpa.fr'"; else echo "value='".$contact->email."'"; ?>  />
                                    
                                </div>
                            </div>
                        </fieldset>



                        <fieldset class="pb-4 pb-sm-4">
                            <legend class="h2">Votre demande</legend>

                            <!---SELECTION DE LA DEMANDE ----->
                            <div class="form-row mt-2">
                                <div class="col">
                                    <lable for="subject">Sujet* :</lable>
                                    <span id="errorSubject" class="text-danger"><?=$err_subject;?></span>
                                    <select class="form-control form-control-sm" id="subject" name="subject">
                                        <option value="0" class="bg-dark text-light" <?php if(empty($contact->subject)) echo "selected"; ?> disabled>Veuillez sélectionner une demande
                                        </option>
                                        <option value="1" <?php if(isset($contact->subject)){ if($contact->subject==1) echo "selected";} ?>>Mes commandes</option>
                                        <option value="2" <?php if(isset($contact->subject)){ if($contact->subject==2) echo "selected";} ?>>Question sur un produit</option>
                                        <option value="3" <?php if(isset($contact->subject)){ if($contact->subject==3) echo "selected";} ?>>Réclamation</option>
                                        <option value="4" <?php if(isset($contact->subject)){ if($contact->subject==4) echo "selected";} ?>>Autres</option>
                                    </select>
                                    </div>
                            </div>

                            <!---QUESTION ----->
                            <div class="form-row mt-2">
                                <div class="col">
                                    <lable for="question">Votre question* :</lable>
                                    <span id="errorQuestion" class="text-danger"><?=$err_question;?></span>
                                    <textarea name="question" id="question" class="form-control form-control-sm"
                                        placeholder="Tapez ici votre question"
                                        rows="5" maxlenght="400"> <?php if(isset($contact->question)) echo $contact->question; ?></textarea>
                                </div>
                            </div>
                        </fieldset>


                        <fieldset>

                        <!---CHECKBOX ACCEPTATION TRAITEMENT INFORMATIQUE ----->
                            <div class="form-row ml-3 ml-sm-3">
                                <div class="col">
                                    <input type="checkbox" class="form-check-input" name="traitement" id="traitement" />
                                    <label class="form-check-label" for="traitement">* J'accepte le traitement
                                        informatique de mes données.</label>
                                    <div id="errorTraitement" class="text-danger"><?=$err_traitement;?></div>
                                </div>
                            </div>
                            
                            
                            <!---BOUTONS ENVOYER ET ANNULER ----->
                            <div class="form-row mt-2">
                                <div class="col">
                                    <input type="submit" class="btn btn-dark btn-lg btn-sm" id="Envoyer_form_contact"
                                        name="Envoyer_form_contact" value='Envoyer' />
                                    <button type="reset" class="btn btn-dark btn-lg btn-sm" id="annuler"
                                        name="annuler">Annuler</button>
                                </div>
                            </div>

                        </fieldset>

                    </div>
                    <!--fin de div .form-group-->
                </form>
            </article>
        </section>
    </div> <!-- fin de col-->
</div> <!-- fin de row-->

<?php

if(isset($_GET['envoi'])){
    if($_GET['envoi']=="ok") echo "<script>alert('Votre demande vient d'être envoyée.');</script>";
}


 include 'footer.php'; ?>