<?php 

//paramétrage de la base de données
require "connexion_db.php";

//connexion à la base de données
$db = connexionBase();

//lancement de la requête qui permettra de recupérer toutes les infos sur le produit $pro_id
$requete = $db->prepare("SELECT * FROM produits INNER JOIN categories on produits.pro_cat_id=categories.cat_id ORDER BY pro_cat_id, pro_libelle");
$requete->execute();
$produit = $requete->fetch();

include 'header.php';
        ?>
    <!-- CORPS DE PAGE -->
    <div class="row p-0 m-0">
      <div class="col-12 col-sm-12 p-0 mb-3 mb-sm-3 shadow bg-white">
        <section class="p-0 m-0 p-sm-0 m-sm-0">
          <h1 class="p-3">Liste de nos produits</h1>

          <article class="table-responsive w-100">
            <table class="table tabProduits">
              <thead>
                <tr>
                  <th class="text-center" scope='col'>Photo</th>
                  <th class="text-center" scope='col'>ID</th>
                  <th scope='col'>R&eacute;f&eacute;rence</th>
                  <th scope='col'>Libell&eacute;</th>
                  <th scope='col'>Prix</th>
                  <th scope='col'>Stock</th>
                  <th scope='col'>Couleur</th>
                  <th scope='col'>Ajout</th>
                  <th scope='col'>Modif</th>
                  <th scope='col'>Bloqué</th>
                </tr>
              </thead>
              <tbody>

<?php
while (isset($produit->pro_id)){
  ?>
                <tr class='table-stripped table-warning' scope='row'>
                  <th class="d-sm-flex justify-content-center justify-content-sm-center" >
                    <img src="./jarditou_css/src/img/<?php echo $produit->pro_id.'.'.$produit->pro_photo; ?>"
                    class="img-responsive img-thumbnail" alt="<?php echo $produit->cat_nom." ".$produit->pro_libelle; ?>" title="<?php echo $produit->cat_nom." ".$produit->pro_libelle; ?>" class="img-responsive img-thumbnail"/>
                    </th>
                  <td class="text-center"><?php echo $produit->pro_id; ?></td>
                  <td><?php echo $produit->pro_ref; ?></td>
                  <td><a href='details.php?pro_id=<?php echo $produit->pro_id; ?>' class='lienDetails'><?php echo $produit->pro_libelle; ?></a></td>
                  <td><?php echo $produit->pro_prix; ?>€</td>
                  <td><?php 
                    if ($produit->pro_stock==0) echo "<div class='articleRupture'>rupture de stock</div>";
                    else echo $produit->pro_stock;
                  ?>
                </td>
                  <td><?php echo $produit->pro_couleur; ?></td>
                  <td><?php echo $produit->pro_d_ajout; ?></td>
                  <td><?php
                  echo $produit->pro_d_modif;
                   if(isset($_GET['ajout'])){
                       if($_GET['pro_id']==$produit->pro_id)
                        echo "<small class='d-block p-1 bg-success text-light' style='border-radius: 15px;'>Modification enregistr&eacute;e</small>";
                   }
                   
                   ?>
                  </td>
                  <td><?php 
                    if($produit->pro_bloque>0){
                      echo "<div class='articleBloque'>BLOQU&Eacute;</div>";
                    } ?></td>
                </tr>

<?php 
//on fait le fetch en fin de boucle 'while'. Il nous retourne une ligne du résultat de la requête.
  //A chaque fin de boucle, on passera à la ligne suivante du résultat de la requête.
$produit = $requete->fetch();
} 
 ?>
              </tbody>
            </table>
          </article>
        </section>
      </div>
    </div> 
  
<?php 

if(isset($_GET['ajout'])){

echo "<script>alert('Votre nouveau produit a bien été ajouté à la base de données');</script>";

}
if(isset($_GET['modif'])){
  echo "<script>alert('Les modifications apportées à votre produit ont bien été enregistrées.');</script>";

}



include 'footer.php'; ?>