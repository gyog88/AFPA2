<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Encodage UTF-8 conçu pour coder l'ensemble des caractères -->
    <meta charset="utf8mb4_unicode_ci" />

    <!-- Permet d’indiquer comment le navigateur doit afficher la page sur différents appareils -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- La balise meta-description est très importante en référencement naturel, elle doit être utile, attrayante et persuasive -->
    <meta name="description" content="CV de Geoffrey Guilbert, concepteur/développeur d'applications" />

    <!-- L'Élément title utile et obligatoire -->
    <title>Portfolio - Site CV Geoffrey Guilbert</title>

    <!-- Icone de l'onglet Attention l'extension de l'image doit être en .ico-->
    <link rel="icon" href="#" />

    <!-- On relie ensuite nos feuilles de styles CSS. Attention: toujours charger nos feuilles CSS APRES avoir chargé BOOTSTRAP-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
    <link rel="stylesheet" href="./src/CSS/styles.css">
    <script src="https://kit.fontawesome.com/be73289548.js" crossorigin="anonymous"></script>


</head>

<body>
    <!--DEBUT CONTAINER -->
    <div class="container d-flex flex-column">


        <div class="row">
            <div class="col-12 col-sm-12">
                <header class="d-flex justify-content-between pt-3 px-3">
                    <a href='index.php' title="Retour vers l'accueil" class="d-flex justify-content-start">
                        <img src='./src/img/escape_key.png' alt="logo escape key" />
                        <div class="d-flex flex-column">
                            <div class="entete">Geoffrey Guilbert</div>
                            <div class="subtitle">Concepteur / développeur d'applications</div>
                        </div>
                    </a>
                    <img src="./src/img/G-Gaelic.png" alt="iceberg_success" class="iceberg" style='width:100px'
                        title="Success is an iceberg.">
                    <div class="d-flex flex-column align-items-between">
                        <a href='#'><img src="./src/img/french.png" title="version Française" alt="drapeau Français" /></a>
                        <a href='#'><img src="./src/img/english.png" title="English version" alt="English flag" /></a>
                    </div>
                </header>
            </div>
        </div>



        <!--MENU DU HAUT--------------------------------------------------------------------------------------------------->
        <div class="row menu px-2">
            <div class="col-12 col-sm-12">
                <nav class="navbar navbar-expand-lg">

                    <!--affichage du bouton Toggler (qui fera défiler le menu haut sur les écran <992px)-->
                    <button class="navbar-toggler px-1 py-1 mx-1 my-2 float-right" type="button" data-toggle="collapse"
                        data-target="#menuhaut" aria-controls="#menuhaut" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"><i class="fas fa-angle-double-right">Menu</i></span>
                    </button>
                    <!---------------->

                    <!--Définition du menu du haut-->
                    <div class="collapse navbar-collapse" id="menuhaut">
                        <div class="d-flex d-sm-flex justify-content-between justify-content-sm-between w-100">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="formation.php"><i class="fas fa-graduation-cap"></i> Formation</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="experiencespro.php"><i class="fas fa-briefcase"></i> Expériences
                                        Professionnelles</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="projets.php"><i class="fas fa-wrench"></i> Projets</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="contact.php"><i class="far fa-id-card"></i> Contact</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!---------------->
                </nav>
            </div>
        </div>
        <!--FIN DE MENU DU HAUT----------------------------------------------------------------------------------------->
