<?php 
include(header.php);
?>

    <!-- CORPS DE PAGE -->
    <div class="row p-0 m-0">
      <div class="col-12 col-sm-12 p-0 mb-3 mb-sm-3 shadow bg-white">
        <section class="p-0 m-0 p-sm-0 m-sm-0">
          <!-- on masque le titre de la page. Balise H1 aide au référencement Google-->
          <h1 class="d-none">Tableau</h1>


          <article class="table-responsive w-100 ">
            <table class="table table-bordered table-hover mb-0 mb-sm-0">
              <thead>
                <tr>
                  <th class="text-center">Photo</th>
                  <th class="text-center">ID</th>
                  <th>Cat&eacute;gorie</th>
                  <th>Libell&eacute;</th>
                  <th>Prix</th>
                  <th>Couleur</th>
                </tr>
              </thead>
              <tbody>
                <tr class="table-warning">
                  <td class="d-sm-flex justify-content-center justify-content-sm-center">
                    <img src="./jarditou_css/src/img/7.jpg" class="img-responsive img-thumbnail"
                      alt="Barbecue Aramis" title="Barbecue Aramis" />
                  </td>
                  <td class="text-center">7</td>
                  <td>Barbecues</td>
                  <td>Aramis</td>
                  <td>110.00€</td>
                  <td>Brun</td>
                </tr>
                <tr>
                  <td class="d-sm-flex justify-content-center justify-content-sm-center">
                    <img src="./jarditou_css/src/img/8.jpg" class="img-responsive img-thumbnail" alt="Barbecue Athos"
                      title="Barbecue Athos" />
                  </td>
                  <td class="text-center">8</td>
                  <td>Barbecues</td>
                  <td>Aramis</td>
                  <td>249.99€</td>
                  <td>Noir</td>
                </tr>
                <tr class="table-warning">
                  <td class="d-sm-flex justify-content-center justify-content-sm-center">
                    <img src="./jarditou_css/src/img/11.jpg" class="img-responsive img-thumbnail"
                      alt="Barbecue Clatronic" title="Barbecue Clathonic" />
                  </td>
                  <td class="text-center">11</td>
                  <td>Barbecues</td>
                  <td>Clathronic</td>
                  <td>135.90€</td>
                  <td>Chrome</td>
                </tr>
                <tr>
                  <td class="d-sm-flex justify-content-center justify-content-sm-center">
                    <img src="./jarditou_css/src/img/12.jpg" class="img-responsive img-thumbnail" alt="Barbecue Camping"
                      title="Barbecue Camping" />
                  </td>
                  <td class="text-center">12</td>
                  <td>Barbecues</td>
                  <td>Camping</td>
                  <td>88.00€</td>
                  <td>Noir</td>
                </tr>
                <tr class="table-warning">
                  <td class="d-sm-flex justify-content-center justify-content-sm-center">
                    <img src="./jarditou_css/src/img/13.jpg" class="img-responsive img-thumbnail" alt="Brouette Green"
                      title="Brouette Green" />
                  </td>
                  <td class="text-center">13</td>
                  <td>Brouette</td>
                  <td>Green</td>
                  <td>49.00€</td>
                  <td>Verte</td>
                </tr>
              </tbody>
            </table>
          </article>
        </section>
      </div>
    </div>
    <!-- fin de row-->

<?php 
  include(footer.php);
?>