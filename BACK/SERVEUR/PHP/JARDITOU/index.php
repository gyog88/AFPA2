<?php
include 'header.php';
?>

    <!-- CORPS DE PAGE (colonne de droite incluse)-->
    <div class="row mx-0 p-0 mb-3 mt-0 float-left">
      <div class="col-12 col-sm-12 col-lg-8 p-3 p-lg-3 mb-3 mb-lg-0 d-lg-inline shadow bg-white">
        <section>
          <!-- on masque le titre de la page. Balise H1 aide au référencement Google-->
          <h1 class="d-none">Accueil</h1>
          <article>

            <h2>L'entreprise</h2>
            <p class="text-justify">
              Notre entreprise familiale met tout son savoir-faire &agrave;
              votre disposition dans le domaine du jardin et du paysagilge.<br />Cr&eacute;&eacute;e
              il y a 70 ans, notre entreprise vend fleurs, arbustes,
              mat&eacute;riel à main et motoris&eacute;s.<br />
              Implant&eacute;s &agrave; Amiens, nous intervenons dans tout le
              d&eacute;partement de la Somme: Albert, Doullens,
              P&eacute;ronne, Abbeville, Corbie.
            </p>
            <h2>Qualit&eacute;</h2>
            <p class="text-justify">
              Nous mettons à votre disposition un service personnalis&eacute;,
              avec 1 seul interlocuteur durant votre projet.<br />Vous serez
              s&eacute;duit par notre expertise, nos comp&eacute;tences et
              notre s&eacute;rieux.
            </p>
            <h2>Devis gratuit</h2>
            <p class="text-justify">
              Vous pouvez bien s&ucirc;r contacter pour de plus amples
              informations ou pour une demande d'intervention. Vous souhaitez
              un devis ? Nous vous le r&eacute;alisons gratuitement.
            </p>
          </article>
        </section>
      </div>
      <!-- fin de col-->

      <!-- class BOOTSTRAP qui déplacera la colonne de droite vers le bas sur les écrans <992px. ex: mobiles -->
      <div class="col-12 col-sm-12 col-lg-4 d-lg-inline p-2 p-lg-2 shadow bg-warning">
        <aside class="text-center">
          <h2>[COLONNE DROITE]</h2>
        </aside>
      </div>
      <!--fin de col-->
    </div>
    <!--fin de row / FIN DE PARTIE CORPS DE PAGE-->

    <?php include 'footer.php'; ?>