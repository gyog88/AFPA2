<?php
//on nettoie le cache
header("Cache-Control: no-cache, must-revalidate" ); 
include 'header.php';

if((isset($_POST['recherche']))&&(!empty($_POST['recherche']))){
//paramétrage de la base de données
require "connexion_db.php";

//connexion à la base de données
$db = connexionBase();

//on récupère la variable à rechercher. On lui ajoute des % pour une recherche plus libre
$search=str_replace(" ", "%", $_POST['recherche']);
$search="%".$search."%";

//lancement de la requête qui permettra de recupérer toutes les infos sur le produit $pro_id
$requete = $db->prepare("SELECT pro_id, pro_libelle, pro_ref, pro_prix, pro_photo, pro_cat_id, pro_description, pro_stock, cat_nom FROM produits INNER JOIN categories on produits.pro_cat_id=categories.cat_id WHERE pro_description LIKE :search OR cat_nom LIKE :search OR pro_libelle LIKE :search ORDER BY pro_cat_id, pro_libelle");
$requete->bindValue(":search", $search, PDO::PARAM_STR);
$requete->execute();
$produit = $requete->fetch();

?>
<!-- CORPS DE PAGE -->
<div class="row p-0 m-0">
  <div class="col-12 col-sm-12 p-0 mb-3 mb-sm-3 shadow bg-white">
    <section class="p-0 m-0 p-sm-0 m-sm-0">
      <h1 class="p-3">Résultat de votre recherche pour: <i><?=$_POST['recherche']; ?></i></h1>

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
              <th scope='col'>Description</th>
            </tr>
          </thead>
          <tbody>

            <?php
while (isset($produit->pro_id)){
  ?>
            <tr class='table-stripped table-warning' scope='row'>
              <td class="d-sm-flex justify-content-center justify-content-sm-center">
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
              <td class='text-justify'><?php
              if(strlen($produit->pro_description)>200){
                echo substr($produit->pro_description,0,200)."...";
              }else echo $produit->pro_description; ?></td>
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
  if(isset($_GET['supp'])){
    echo "<script>alert('Le produit a été supprimé.');</script>";
  }
}else echo "<p class='lead'>La recherche n'a rien donné.</p>";

  include 'footer.php';
?>