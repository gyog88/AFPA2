<!DOCTYPE html>
<html lang="fr">
<?php 

/*function calculator(nombre1, nombre2, symbole, emplacementRes) {

  
   variables
    a est le premier nombre
    b le deuxieme nombre
    symbole correspond au type de calcul
    emplacementRes est l'id de la div où va apparaitre le resultat 
  

    switch {
      case ("+"):
      break;
      case ("-"):
      break;
      case ("*"):
      break;
      case ("/"):
      break;
    }
  if ((isNaN(nombre1) == true) || (isNaN(nombre2) == true)) {
  
    emplacementRes.innerHTML = "Seuls les nombres sont acceptés.";
  } else {
    var a = parseInt(nombre1);
    var b = parseInt(nombre2);
    if (symbole == "+") {
      emplacementRes.innerHTML = a + b;
    }
    if (symbole == "-") {
      emplacementRes.innerHTML = a - b;
    }
    if (symbole == "*") {
      emplacementRes.innerHTML = a * b;
  
    }
    if (symbole == "/") {
      if (b == 0) {
        emplacementRes.innerHTML = "La division par 0 est impossible. Réessayez.";
      } else emplacementRes.innerHTML = (a / b);
    }
  }
  }
*/
?>

<head>



  <!-- Encodage UTF-8 conçu pour coder l'ensemble des caractères -->
  <meta charset="UTF-8" />

  <!-- Permet d’indiquer comment le navigateur doit afficher la page sur différents appareils -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <!-- La balise meta-description est très importante en référencement naturel, elle doit être utile, attrayante et persuasive -->
  <meta name="description" content="Exercices PHP - AFPA" />

  <!-- L'Élément title utile et obligatoire -->
  <title>Exercices PHP</title>

  <!-- On relie ensuite nos feuilles de styles CSS. Attention: toujours charger nos feuilles CSS APRES avoir chargé BOOTSTRAP-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
    <link rel="stylesheet"  type="text/css" href="./styleExercicesPHP.css" />
</head>



<body>
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12">
        <header class="w-100 bg-info text-white p-2 ">
          <h1 class="d-flex justify-content-center">Exercices PHP</h1>
          <div class="d-flex justify-content-center"><img src="./phplogo.png" style="width:10em" /></div>
          <i class="d-flex justify-content-end">Geoffrey Guilbert</i>
        </header><br>

        <h2>Les boucles et les conditions</h2>

        <p class="lead">Exercice 1: les nombres impairs</p>
        <?php
          echo "Voici tous les nombres impairs entre 0 et 150, par ordre croissant:<br/>";
          for($i=1; $i<150 ;$i++){
           echo $i." ; ";
           $i++;
          }
        ?>
        <hr /><br />
        <p class="lead">Exercice 2: répétition</p>
        <p>Voici une phrase répétée 500 fois en PHP:</p>
        <p style='text-align:justify'>
          <?php
          for($i=1; $i<=500 ;$i++){
           echo $i." - Je dois faire des sauvegardes régulières de mes fichiers. ";
          }
        ?>
        </p>
        <hr /><br />
        <p class="lead">Exercice 3: Table de multiplication par 12 en PHP:</p>
        <table class="table">
          <?php
            for($i=-1; $i<=12;$i++){
              if ($i==-1){
                echo "<tr><th></th>";
              }else echo "<tr><th>".$i."</th>";
              
            for($j=0; $j<=12;$j++){
              if($i==-1){
                echo "<th>".$j."</th>";
              }
              else echo "<td>".$i*$j."</td>";
            }
            echo "</tr>";
            }
          ?>

        </table>

<hr/><br/>

        <h2>Les fonctions</h2>
        <p class="lead">Calculatrice</p>
        <form action="calculator()" method="GET" class="form-group">
          <?php
          $j=0;
          $symbole=array("/","x","-","+");
          $ligne=0; /*ligne de la calculatrice pour l'affichage des boutons. Ligne 0 = la ligne du haut */
          $tmp="";



          echo "<table class='p-5 p-sm-5' style='border:8px solid orange'>
          <tr><td colspan='4'><input type='text' name='result' id='result' placeholder='0.00' class='form-control-lg'/></td></tr>
          <tr><td><input type='reset' name='reset' id='reset' value='C' class='btn-lg btn-danger boutonCalc'></td>
          <td><button name='negatif' id='negatif' class='btn-lg btn-secondary boutonCalc'>+/-</button></td>
          <td><button name='pourcentage' id='pourcentage' class='btn-lg btn-secondary boutonCalc'>%</button></td>
         <td><button name='".$symbole[$ligne]."' id='".$symbole[$ligne]."' class='btn-lg btn-warning boutonCalc'>".$symbole[$ligne]."</button></td></tr>";
         $ligne++;
          for($i=9;$i>0;$i--){
          $tmp="<td><button name='".$i."' id='".$i."' class='btn-lg btn-dark boutonCalc'>".$i."</button></td>".$tmp;
          $j++;
          if($j==3){
            echo "<tr>".$tmp."<td><button name='".$symbole[$ligne]."' id='".$symbole[$ligne]."' class='btn-lg btn-warning boutonCalc'>".$symbole[$ligne]."</button></td></tr>";
            $ligne++;
            $tmp="";
          $j=0;
          }
          }

          echo "<tr><td  colspan='2'><button name='".$i."' id='".$i."' class='btn-lg btn-dark boutonCalc' style='width:120px;text-align:left'>".$i."</button></td>
          <td><button name='point' id='point' class='btn-lg btn-dark boutonCalc'>.</button></td>
          <td><input type='submit' name='calculer' id='calculer' value='=' class='btn-lg btn-success boutonCalc'></td></tr></table>";


          ?>
          

          </form>


  












      

      </div>
    </div>
  </div>





  <!-- fichiers nécessaires à BOOTSTRAP. Attention: respecter l'ordre de chargement. Toujours à mettre avant la balise "</body>" -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
  </script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
  </script>
</body>

</html>