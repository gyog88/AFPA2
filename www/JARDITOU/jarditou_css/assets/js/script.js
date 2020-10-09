document.getElementById("formulaire_contact1").onsubmit = function () {
    var envoyerForm = true; //boolean pour envoyer ou non le formulaire. True par defaut

    //on vérifie que le champ nom a été rempli avec des caractères, pas d'entiers.
    var tmpNom = document.getElementById("name").value;
    var errorName = "";
    var regNom =/^[a-zA-ZéèîïÉÈÎÏ][a-zéèêàçîï]+([-'\s][a-zA-ZéèîïÉÈÎÏ][a-zéèêàçîï]+)?$/;
    if(regNom.test(tmpNom)==false){
        errorName = "Veuillez entrer votre nom.";
        envoyerForm = false;
    }

    //on vérifie que le champ prénom a été rempli avec des caractères, pas d'entiers.
    var tmpPrenom = document.getElementById("surname").value;
    var errorSurname = "";
    var regPrenom =/^[a-zA-ZéèîïÉÈÎÏ][a-zéèêàçîï]+([-'\s][a-zA-ZéèîïÉÈÎÏ][a-zéèêàçîï]+)?$/;
    if(regPrenom.test(tmpPrenom)==false){
        errorSurname = "Veuillez entrer votre prénom.";
        envoyerForm = false;
    }

    //on vérifie qu'un sexe a été selectionné
    var errorSex = "";
    if ((!(document.getElementById("sexF").checked)) && (!(document.getElementById("sexM").checked))) {
        errorSex = "Veuillez définir votre sexe.";
        envoyerForm = false;
    }

    //on vérifie qu'une date de naissance correcte a été entrée
    var errorDob = "";
    if (document.getElementById("dob").value < "1920-01-01") {
        errorDob = "Veuillez entrer votre date de naissance.";
        envoyerForm = false;
    }

    //on vérifie le code postal
    var tmpCode = document.getElementById("postcode").value;
    var longueurCode = tmpCode.length;
    var code = parseInt(tmpCode);
    var errorPostcode = "";
    if (isNaN(code) || (longueurCode != 5)) {
        errorPostcode = "Veuillez entrer un code postal à 5 chiffres.";
        envoyerForm = false;
    }

    //on vérifie l'adresse email
    var reg = /^[a-zA-Z0-9._-]+(.[a-zA-Z0-9._-]+)+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,3}$/;
    Myemail=document.getElementById("mail").value;
    if((reg.test(Myemail))==false){
        errorEmail = "Veuillez selectionner une adresse email correcte.";
        envoyerForm = false;
    }

    //on vérifie qu'un sujet de demande a été selectionné
    var errorSubject = "";
    if (document.getElementById("subject").value == "0") {
        errorSubject = "Veuillez selectionner un sujet à votre demande.";
        envoyerForm = false;
    }

    //on vérifie que le textarea question a été rempli
    var errorQuestion = "";
    if (document.getElementById("question").value == "") {
        errorQuestion = "Veuillez entrer les détails concernant votre demande.";
        envoyerForm = false;
    }

    //on vérifie que l'utilisateur a coché la case traitement de données informatiques
    var errorTraitement = "";
    if (document.getElementById("traitement").checked == false) {
        errorTraitement = "Veuillez accepter le traitement de vos données informatique pour valider votre demande.";
        envoyerForm = false;
    }

    //on affiche toutes les erreurs
    if(!envoyerForm){
        document.getElementById("errorName").innerHTML = errorName;
        document.getElementById("errorSurname").innerHTML = errorSurname;
        document.getElementById("errorSex").innerHTML = errorSex;
        document.getElementById("errorDob").innerHTML = errorDob;
        document.getElementById("errorPostcode").innerHTML = errorPostcode;
        document.getElementById("errorEmail").innerHTML = errorEmail;
        document.getElementById("errorSubject").innerHTML = errorSubject;
        document.getElementById("errorQuestion").innerHTML = errorQuestion;
        document.getElementById("errorTraitement").innerHTML = errorTraitement;
    }
    return envoyerForm;

}