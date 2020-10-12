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
$no_of_records_per_page = 30;
$offset = ($pageno-1) * $no_of_records_per_page; 

$request_total_pages = $db->prepare("SELECT COUNT(pro_id) FROM produits");
$request_total_pages->execute();
$total_rows=$request_total_pages->fetch(PDO::FETCH_NUM);
$total_pages = ceil($total_rows[0] / $no_of_records_per_page);


//lancement de la requête qui permettra de recupérer toutes les infos sur le produit $pro_id
$requete = $db->prepare("SELECT pro_id, pro_libelle, pro_photo, pro_bloque, pro_ref, pro_stock, pro_prix, pro_description, pro_d_ajout FROM produits ORDER BY pro_libelle LIMIT :offset, :no_of_records_per_page");
$requete->bindValue(":offset", $offset, PDO::PARAM_INT);
$requete->bindValue(":no_of_records_per_page", $no_of_records_per_page, PDO::PARAM_INT);
$requete->execute();
$produit = $requete->fetch();

        ?>
<!-- CORPS DE PAGE -->
<div class="row p-0 m-0">
  <div class="col-12 col-sm-12 p-0 mb-3 mb-sm-3 shadow bg-white">
    <section class="p-0 m-0 p-sm-0 m-sm-0">
      <h1 class="p-3">Suppression de produits</h1>
      <p class='lead pl-3'>Sélectionnez les produits que vous souhaitez supprimer.</p>

      <article>
<?php if(!empty($produit->pro_id)){ ?>
<form method="POST" action="multi_delete_script.php" id="form_multi_DEL_produit" name="form_multi_DEL_produit"
                    class="form-block">
      <div class="table-responsive w-100">
        <table class="table tabProduits">
          <thead>
            <tr>
              <th scope='col'></th>
              <th scope='col'>R&eacute;f&eacute;rence</th>
              <th scope='col'>Libell&eacute;</th>
              <th scope='col'>Prix</th>
              <th scope='col'>Stock</th>
              <th scope='col'>Description</th>
              <th scope='col'>Ajout</th>
              <th scope='col'>Bloqué</th>
            </tr>
          </thead>
          <tbody>

            <?php
while (isset($produit->pro_id)){
  ?>
            <tr class='table-stripped table-warning' scope='row'>
              <td class="text-justify">
                <input type="checkbox" value="<?=$produit->pro_id."_".$produit->pro_photo; ?>" name="pro_id" id="pro_id" />
              </td>
              <td><?=$produit->pro_ref; ?></td>
              <td><a href='details.php?pro_id=<?=$produit->pro_id; ?>'
                  class='lienDetails'><?=$produit->pro_libelle; ?></a></td>
              <td><?=$produit->pro_prix; ?>€</td>
              <td><?php 
                    if ($produit->pro_stock==0) echo "<div class='etiquette bg-warning'>rupture de stock</div>";
                    else echo $produit->pro_stock;
                  ?>
              </td>
              <td class="text-justify"><?=$produit->pro_description; ?></td>
              <td><?=$produit->pro_d_ajout; ?></td>
              <td><?php 
                    if($produit->pro_bloque>0) echo "<div class='etiquette bg-danger'>BLOQU&Eacute;</div>"; ?>
                </td>
            </tr>

            <?php 
    //on fait le fetch en fin de boucle 'while'. Il nous retourne une ligne du résultat de la requête.
  //A chaque fin de boucle, on passera à la ligne suivante du résultat de la requête.
$produit = $requete->fetch();
} 
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
<div class='d-flex d-sm-flex justify-content-center'>
    <input type='submit' name='Btn_supp_multi' id='Btn_supp_multi' value='Supprimer' class='btn btn-danger mb-3'>
</div>
</form>



<?php }else echo "<p class='lead'>Aucun produit n'est présent dans la base de donn&eacute;es</p>"; ?>
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