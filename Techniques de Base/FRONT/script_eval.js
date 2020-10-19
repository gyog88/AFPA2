var tabPrenoms = ["Audrey", "Aurélien", "Flavien", "Jérémy", "Laurent", "Melik", "Nouara", "Salem", "Samuel", "Stéphane"];


//CALCUL DU NOMBRE DE JEUNES,MOYENS, VIEUX
document.querySelector("#age").onclick = function () {
  var ageCandidat = []; //tableau regroupant les ages rentrés au clavier
  var tabJunior = []; //tableau regroupant les candidats < 20 ans
  var tabMedium = []; //tableau regroupant les candidats >= 20 ans et <= 40 ans
  var tabSenior = []; //tableau regroupant les candidats > 40 ans
  var tmp; //tampon
  var i = -1; //Commence à -1 car l'incrémentation de i se trouve en début de boucle

  do {
    i++;
    do {
      ageCandidat[i] = parseInt(window.prompt("Entrez l'âge du candidat n°" + (i + 1) + " :\nATTENTION: Seuls les nombres positifs et inférieurs ou égal à 100 seront acceptés."));
    } while (isNaN(ageCandidat[i]));
    
  } while ((ageCandidat[i] < 100) && (ageCandidat[i] > 0));

  //on retire le dernier élément du tableau ageCandidat (s'il s'agit d'un 100+ ou <=0)
  var dernier = ageCandidat[ageCandidat.length-1];
  if((dernier>100)||(dernier<=0)){
   ageCandidat.pop();
  }

  var plurielJunior="s"; //var qui définira la phrase d'affichage au pluriel selon le nombre de candidats (pour les juniors)
  var plurielSenior="s"; //var qui définira la phrase d'affichage au pluriel selon le nombre de candidats (pour les seniors)
  var plurielMedium="s"; //var qui définira la phrase d'affichage au pluriel selon le nombre de candidats (pour les mediums)


  //on insére les valeurs rentrées dans le tableau ageCandidat[] dans différents tableaux, selon la tranche d'âge
  if (ageCandidat.length > 0) {
    for (j = 0; j < ageCandidat.length; j++) {
      tmp = ageCandidat[j];
      if (tmp < 20) {
        tabJunior.push(tmp);
      } else if (tmp > 40) {
        tabSenior.push(tmp);
      } else tabMedium.push(tmp);
    }
    document.getElementById("reponseAge").innerHTML = "Vous avez entré les âges suivants:" + ageCandidat + ".<br/>";

    //On mettra la phrase au singulier s'il y a un ou 0 candidats
    if( tabJunior.length<=1) plurielJunior="";
    if( tabMedium.length<=1) plurielMedium="";
    if( tabSenior.length<=1) plurielSenior="";

//on affichage le resultat dans la baslise reponseAge
    document.getElementById("reponseAge").innerHTML= document.getElementById("reponseAge").innerHTML+tabJunior.length+" candidat"+plurielJunior+" âgé"+plurielJunior+" de moins de 20 ans : (" + tabJunior.join() + ").<br/>";
    document.getElementById("reponseAge").innerHTML= document.getElementById("reponseAge").innerHTML+tabMedium.length+" candidat"+plurielMedium+" âgé"+plurielMedium+" entre 20 et 40 ans : (" + tabMedium.join() + ").<br/>";
    document.getElementById("reponseAge").innerHTML= document.getElementById("reponseAge").innerHTML+tabSenior.length+" candidat"+plurielSenior+" âgé"+plurielSenior+" de plus de 40 ans : (" + tabSenior.join() + ").";
  } else document.getElementById("reponseAge").innerHTML = "Vous n'avez entré aucun âge correct. N'oubliez pas, le personnes âgées de plus de 100 ans ne sont pas autorisées dans notre club! ;-)";
}


//TABLE DE MULTIPLICATION
document.querySelector("#TableMulti").onclick = function () {
  var i = 0;
  var a;
  var rep = "";
  //Pour cette fonction, j'ai préféré n'utiliser aucun paramètre afin de vérifier que l'utilisateur entre bien un nombre
  // De plus, ça fait travailler le javascript non-intrusif

  //on vérifie qu'un nombre a bien été rentré
  do {
    a = parseInt(window.prompt("Entrez un nombre:"));
  } while (isNaN(a));

  //on incrémente la String rep avec la réponse à chaque multiplication de 0 à 10
  for (i = 0; i <= 10; i++) {
    rep = rep + (i + "x" + a + "=" + (i * a) + "<br/>");
  }
  //on affiche le résultat dans sur la page html
  document.getElementById("reponseTableMulti").innerHTML = rep;
}

//RECHERCHE DE PRENOM


//fonction qui va mettre la première lettre en capitale et le reste en minuscule (comme dans le tableau)
String.prototype.capitalize = function() {
  return this.charAt(0).toUpperCase() + (this.slice(1)).toLowerCase();
}


//Supprimer un prenom dans la liste
document.querySelector("#supprimer").onclick = function () {
  var aSupprimer = document.getElementById("prenom").value;
  aSupprimer = aSupprimer.capitalize();
  var position = tabPrenoms.indexOf(aSupprimer);

  //on va chercher à quelle position se trouve le nom entré "aSupprimer" grâce à indexOf. Si le nom n'est pas dans le tableau, la fonction retournera -1.
  // on va reduire le nom entré "aSupprimer" en une chaîne de caractère en minuscules dont la première lettre est une capitale. Comme ça, on comparera 2 noms en de même forme

   if (position < 0) {
    document.getElementById("reponsePrenom2").innerHTML = document.getElementById("reponsePrenom2").innerHTML + aSupprimer + " ne se trouve pas dans la liste de prénoms.<br/>";
  } else {
    tabPrenoms.splice(position, 1);
    tabPrenoms.push(" ");
    document.getElementById("reponsePrenom2").innerHTML = document.getElementById("reponsePrenom2").innerHTML + "Voici la nouvelle liste de prénoms: " + (tabPrenoms.join()) + "<br/>";
  }
}


//Exercice 4 - Total d'une Commande
function CalculTotal(PrixU, Qte) {

  var PUnitaire = parseFloat(PrixU);
  var Quantite = parseFloat(Qte);
  var TOT = 0.00; //Total non remisé, sans les frais de port
  var REM = 0.00; //Remise
  var tauxREM = "0.00%"; //taux de remise (en texte)
  var PORT = 0.00; //frais de port (offerts par défault, c'est à dire pour tout achat remisé de 500euros ou plus)
  var PAP = 0.00; //prix à payer

  if ((isNaN(PUnitaire)) || (isNaN(Quantite))) {
    alert("Vous devez entrer des chiffres.");
  } else {
    TOT = PUnitaire * Quantite;

    //calcul du prix remisé selon la dépense
    if ((TOT >= 100) && (TOT <= 200)) {
      tauxREM = "5.00%";
      REM = TOT * 0.05;
    } else if (TOT > 200) {
      tauxREM = "10.00%";
      REM = TOT * 0.1;
    }
    //prix à payer sans les frais de port
    PAP = TOT - REM;

    //calcul des frais de port
    if (PAP <= 500) {
      PORT = PAP * 0.02;
      if (PORT < 6) {
        PORT = 6;
      }
    }

   
    
    if(PAP>0){
      //on ajoute les frais de port si un achat a vraiment été fait
      PAP = PAP + PORT;
    document.getElementById("reponseTotalCommande").innerHTML = "Total Commande: " + TOT.toFixed(2) + " €.<br>Remise: " + REM.toFixed(2) + " € (" + tauxREM + ").<br>Frais de Port: " + PORT.toFixed(2) + " €.<br><b>TOTAL DE LA COMMANDE: " + PAP.toFixed(2) + "€.</b>";
    }else document.getElementById("reponseTotalCommande").innerHTML="Vous n'avez rien commandé. Bonne nouvelle, vous n'avez donc rien à payer!";
  }
}