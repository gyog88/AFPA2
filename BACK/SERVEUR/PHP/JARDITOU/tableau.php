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
$requete->bindValue(":offset", $offset, PDO::PARAM_INT);
$requete->bindValue(":no_of_records_per_page", $no_of_records_per_page, PDO::PARAM_INT);
$requete->execute();
$produit = $requete->fetch();

//https://www.myprogrammingtutorials.com/create-pagination-with-php-and-mysql.html 
        ?>
<!-- CORPS DE PAGE -->
<div class="row p-0 m-0">
  <div class="col-12 col-sm-12 p-0 mb-3 mb-sm-3 shadow bg-white">
    <section class="p-0 m-0 p-sm-0 m-sm-0">
      <h1 class="p-3">Liste de nos produits</h1>

      <article>
<?php if(!empty($produit->pro_id)){ ?>
      <div class="table-responsive w-100">
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
              <td class="justify-content-center justify-content-sm-center">
                <?php if(!empty($produit->pro_photo)){ ?>
                <img src="./jarditou_css/src/img/<?=($produit->pro_id.'.'.$produit->pro_photo); ?>"
                  class="img-responsive img-thumbnail" alt="<?=($produit->cat_nom." ".$produit->pro_libelle); ?>"
                  title="<?=($produit->cat_nom." ".$produit->pro_libelle); ?>" class="img-responsive img-thumbnail" />
                <?php }else{ ?>
                <i>Aucune photo disponible pour ce produit.</i>
                <?php } ?>
              </td>
              <td class="text-center"><?=$produit->pro_id; ?></td>
              <td><?=$produit->pro_ref; ?></td>
              <td><a href='details.php?pro_id=<?=$produit->pro_id; ?>'
                  class='lienDetails'><?=$produit->pro_libelle; ?></a></td>
              <td><?=$produit->pro_prix; ?>€</td>
              <td><?php if ($produit->pro_stock==0) echo "<img src='./jarditou_css/src/img/stock_epuise.png' style='width:6rem' alt='Rupture de stock!' title='Rupture de stock.' />"; else echo $produit->pro_stock; ?>
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
 $requete->closeCursor();
 ?>
          </tbody>
        </table>
</div>
        <nav>
        <ul class="pagination justify-content-center mt-2">
          <li><a href="?pageno=1" class="btn btn-sm btn-outline-success" >1</a></li>
          <li class="page-item" >
            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>" <?php if(!($pageno>= 1)) echo 'disabled'; ?> class="btn btn-sm btn-outline-success ml-1" >Pr&eacute;c&eacute;dent</a>
          </li>
          <li class="page-item" >
            <a href="<?php if($pageno>= $total_pages) echo '#'; else echo "?pageno=".($pageno + 1); ?>" <?php if($pageno==$total_pages) echo 'disabled';?> class="btn btn-sm btn-outline-success ml-1" >Suivant</a>
          </li>
          <li><a href="?pageno=<?=$total_pages;?>" class="btn btn-sm btn-outline-success ml-1"><?=$total_pages; ?></a></li>
        </ul>
        </nav>
<?php } else echo "<p class='lead'>Aucun produit n'est présent dans la base de donn&eacute;es</p>"; ?>
      </article>

    </section>
  </div>
</div>

<?php 

  include 'footer.php';
?>