<!DOCTYPE html>
<html lang="fr">

<head>
  <!-- Encodage UTF-8 conçu pour coder l'ensemble des caractères -->
  <meta charset="utf8mb4_unicode_ci" />

  <!-- Permet d’indiquer comment le navigateur doit afficher la page sur différents appareils -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <!-- La balise meta-description est très importante en référencement naturel, elle doit être utile, attrayante et persuasive -->
  <meta name="description" content="Jarditou, paysagiste en Picardie depuis 70 ans!" />

  <!-- L'Élément title utile et obligatoire -->
  <title>JARDITOU</title>

  <!-- Icone de l'onglet Attention l'extension de l'image doit être en .ico-->
  <link rel="icon" href="./jarditou_css/src/img/icone.ico" />

  <!-- On relie ensuite nos feuilles de styles CSS. Attention: toujours charger nos feuilles CSS APRES avoir chargé BOOTSTRAP-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
  <link rel="stylesheet" href="jarditou_css/assets/css/styles.css">
  <script src="https://kit.fontawesome.com/be73289548.js" crossorigin="anonymous"></script>
  <script src='./jarditou_css/assets/js/script.js'></script>

</head>

<body>
  <!--DEBUT CONTAINER -->
  <div class="container">
    <!-- header contenant le logo + le slogan-->
    <header>
      <div class="row d-none d-sm-none d-lg-block">
        <div class="col-lg-12 d-lg-block d-lg-flex justify-content-lg-between align-items-center w-100">
          <img src="jarditou_css/src/img/jarditou_logo.jpg" class="img-fluid w-50" alt="Logo Jarditou" />
          <span class="justify-content-center">
            <h1>Tout le jardin</h1>
          </span>
        </div>
        <!--fin de col-->
      </div>
      <!--fin de row-->
    </header>

    <!--menu du haut-->
    <div class="row p-0 m-0 float-left w-100 bg-dark text-light">
      <div class="col-12 col-sm-12 p-0 m-0">
        <nav class="navbar navbar-expand-lg navbar-light float-left w-100 align-items-center align-items-sm-center">
          <div class="h4">Jarditou.com</div>

          <!--affichage du bouton Toggler (qui fera défiler le menu haut sur les écran <992px)-->
          <button class="navbar-toggler px-1 py-1 mx-1 my-2 float-right" type="button" data-toggle="collapse"
            data-target="#menuhaut" aria-controls="#menuhaut" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <!---------------->

          <!--définition du menu du haut-->
          <div class="collapse navbar-collapse" id="menuhaut">
            <div class="d-flex d-sm-flex justify-content-between justify-content-sm-between w-100">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link text-light <?php if(basename($_SERVER['PHP_SELF'])=="index.php") echo "active"; ?> "
                    href="index.php">Accueil</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-light <?php if(basename($_SERVER['PHP_SELF'])=="tableau.php") echo "active"; ?>"
                    href="tableau.php">Tableau</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-light <?php if(basename($_SERVER['PHP_SELF'])=="contact.php") echo "active"; ?>"
                    href="contact.php">Contact</a>
                </li>
              </ul>
              <!-- formulaire de recherche-->
              <ul class="navbar-nav d-flex d-sm-flex
                flex-column flex-sm-column flex-lg-row
                align-items-start align-items-sm-start align-items-lg-center
                justify-content-end justify-content-sm-end">
                <li class="nav-item">
                  <a class="nav-link text-light <?php if(basename($_SERVER['PHP_SELF'])=="add.php") echo "active"; ?>"
                    href="add.php">Ajouter Produit</a>
                </li>
                <li class="nav-item">
                  <form action="#" class="form-inline" method="POST" id="form_search_promo">
                    <div class="form-group">
                      <input type="search" class="input-sm m-1 m-sm-1 m-lg-0 mr-lg-1" name="rechercher" id="rechercher"
                        placeholder="Search" />
                      <button type="submit" class="btn btn-success btn-sm m-1 m-sm-1 ml-auto ml-sm-auto m-lg-0 mr-lg-1">
                        Rechercher
                      </button>
                    </div>
                    <!-- fin de form-group-->
                  </form>
                </li>
              </ul>
            </div><!-- fin de div d-flex-->
          </div><!-- fin de collapse-->
        </nav>
      </div><!-- fin de col-->
    </div>
    <!--- fin de row-->

    <!-- banderole publicitaire -->
    <div class="row">
      <div class="col-12 col-sm-12">
        <img class="img-fluid w-100" src="./jarditou_css/src/img/promotion.jpg"
          alt="promotion sur lames de terrasses" />
      </div>
      <!--fin de col-->
    </div>

    <!--fin de row-->