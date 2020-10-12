<?php
//on nettoie le cache
header("Cache-Control: no-cache, must-revalidate" ); 
include 'header.php';

//paramétrage de la base de données
require "connexion_db.php";

//connexion à la base de données
$db = connexionBase();

//on récupère le numéro de page en cours. 1 par défaut
if (isset($_GET['pageno'])) {
  $pageno = $_GET['pageno'];
} else {
  $pageno = 1;
}

//on définit le nombre de pages à afficher
$no_of_records_per_page = 5;
$offset = ($pageno-1) * $no_of_records_per_page; 

$request_total_pages = $db->prepare("SELECT COUNT(pro_id) FROM produits");
$request_total_pages->execute();
$total_rows=$request_total_pages->fetch(PDO::FETCH_NUM);
$total_pages = ceil($total_rows[0] / $no_of_records_per_page);


//lancement de la requête qui permettra de recupérer toutes les infos sur le produit $pro_id
$requete = $db->prepare("SELECT * FROM produits INNER JOIN categories on produits.pro_cat_id=categories.cat_id ORDER BY pro_cat_id, pro_libelle LIMIT :offset, :no_of_records_per_page");
$requete->execute();
$produit = $requete->fetch();

//https://www.myprogrammingtutorials.com/create-pagination-with-php-and-mysql.html 
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
                  <td class="d-sm-flex justify-content-center justify-content-sm-center" >
                  <?php if(!empty($produit->pro_photo)){ ?>
                    <img src="./jarditou_css/src/img/<?=($produit->pro_id.'.'.$produit->pro_photo); ?>"
                    class="img-responsive img-thumbnail" alt="<?=($produit->cat_nom." ".$produit->pro_libelle); ?>" title="<?=($produit->cat_nom." ".$produit->pro_libelle); ?>" class="img-responsive img-thumbnail"/>
                  <?php }else{ ?>
                    <i>Aucune photo disponible pour ce produit.</i>
                  <?php } ?>
                    </td>
                  <td class="text-center"><?=$produit->pro_id; ?></td>
                  <td><?=$produit->pro_ref; ?></td>
                  <td><a href='details.php?pro_id=<?=$produit->pro_id; ?>' class='lienDetails'><?=$produit->pro_libelle; ?></a></td>
                  <td><?=$produit->pro_prix; ?>€</td>
                  <td><?php 
                    if ($produit->pro_stock==0) echo "<div class='etiquette bg-warning'>rupture de stock</div>";
                    else echo $produit->pro_stock;
                  ?>
                </td>
                  <td><?=$produit->pro_couleur;?></td>
                  <td><?php
                   if(isset($_GET['ajout'])){
                       if($_GET['pro_id']==$produit->pro_id) {
                   ?> <div class='etiquette bg-success'>Produit ajout&eacute;</div>
                   <?php
                   }else echo $produit->pro_d_ajout; } ?>
                   </td>
                  <td><?php
                   if(isset($_GET['modif'])){
                       if($_GET['pro_id']==$produit->pro_id){ ?>
                    <div class='etiquette bg-success'>Modification enregistr&eacute;e</div>
                   <?php
                   }else echo $produit->pro_d_modif; } ?>
                  </td>
                  <td><?php 
                    if($produit->pro_bloque>0){
                      echo "<div class='etiquette bg-danger'>BLOQU&Eacute;</div>";
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
            <ul class="pagination">
    <li><a href="?pageno=1">First</a></li>
    <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
        <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
    </li>
    <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
        <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
    </li>
    <li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
</ul>

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
  if(isset($_GET['supp'])){
    echo "<script>alert('Le produit a été supprimé.');</script>";
  }

  include 'footer.php';
?>