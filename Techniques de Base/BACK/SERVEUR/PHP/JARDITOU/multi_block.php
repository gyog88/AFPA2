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
$no_of_records_per_page = 10;
$offset = ($pageno-1) * $no_of_records_per_page; 

$request_total_pages = $db->prepare("SELECT COUNT(pro_id) FROM produits");
$request_total_pages->execute();
$total_rows=$request_total_pages->fetch(PDO::FETCH_NUM);
$total_pages = ceil($total_rows[0] / $no_of_records_per_page);


//lancement de la requête qui permettra de recupérer toutes les infos sur le produit $pro_id
$requete = $db->prepare("SELECT pro_id, pro_libelle, pro_bloque, pro_ref, pro_stock, pro_prix, pro_description, pro_d_ajout FROM produits ORDER BY pro_libelle LIMIT :offset, :no_of_records_per_page");
$requete->bindValue(":offset", $offset, PDO::PARAM_INT);
$requete->bindValue(":no_of_records_per_page", $no_of_records_per_page, PDO::PARAM_INT);
$requete->execute();
$produit = $requete->fetch();

        ?>
<!-- CORPS DE PAGE -->
<div class="row p-0 m-0">
  <div class="col-12 col-sm-12 p-0 mb-3 mb-sm-3 shadow bg-white">
    <section class="p-0 m-0 p-sm-0 m-sm-0">
      <h1 class="p-3">Blocage de produits</h1>
      <p class='lead pl-3'>Sélectionnez les produits que vous souhaitez bloquer à la vente.</p>

      <article>
<?php if(!empty($produit->pro_id)){ ?>
<form method="POST" action="multi_block_script.php" id="form_multi_BLOCK" name="form_multi_BLOCK"
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
              <label class="switch">
                <input type='hidden' value="<?=$produit->pro_id;?>" name="pro_id[]" id="<?="ID_".$produit->pro_id;?>" >
              <input type="checkbox" value="<?=$produit->pro_id;?>" name="pro_bloque[]" id="<?="pro_bloque_".$produit->pro_id;?>" <?php if($produit->pro_bloque==1) echo "checked"; ?> />
  <span class="slider round"></span>
</label>
                
              </td>
              <td><label for="<?=$produit->pro_id;?>"><?=$produit->pro_ref; ?></label></td>
              <td><a href='details.php?pro_id=<?=$produit->pro_id; ?>'
                  class='lienDetails'><?=$produit->pro_libelle; ?></a></td>
              <td><?=$produit->pro_prix; ?>€</td>
              <td> 
                <?php if ($produit->pro_stock==0) echo "<img src='./jarditou_css/src/img/stock_epuise.png' style='width:6rem' alt='Rupture de stock!' title='Rupture de stock.' />"; else echo $produit->pro_stock; ?>
              </td>
              <td class="text-justify">
              <?php
              if(strlen($produit->pro_description)>200){
                echo substr($produit->pro_description,0,200)."...";
              }else echo $produit->pro_description; ?>
              </td>
              <td><?=$produit->pro_d_ajout; ?></td>
              <td><div class='etiquette bg-danger' <?php 
                    if($produit->pro_bloque==0) echo "hidden"; ?> >BLOQU&Eacute</div>
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
    <input type='submit' name='Btn_block_multi' id='Btn_block_multi' value='Bloquer' class='btn btn-danger mb-3'>
</div>
</form>



<?php }else echo "<p class='lead'>Aucun produit n'est présent dans la base de donn&eacute;es</p>"; ?>
      </article>

    </section>
  </div>
</div>

<?php 
   if(isset($_GET['block'])){
    if($_GET['block']==0){
       echo "<script>alert('Aucun changement n'a été effectué.');</script>";
    }else{
      echo "<script>alert('Le blocage de produits a été mis à jour.');</script>";
    }
}

  include 'footer.php';
?>