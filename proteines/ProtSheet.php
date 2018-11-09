<!DOCTYPE html>
<!-- Page d'affichage des informations pour une proteine donnée -->

<html lang="fr">
<?php
	session_start();
	$_SESSION['currentPage']="proteines";
	//Récupére la proteine à afficher

	if ((isset($_GET['prot'])) && ($_GET['prot'] != '')){
	$prot = $_GET['prot'];
	}
	else{$prot='INCONNU';}
?>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../AFMC.css"> 
	<title>AFMC</title>
  </head>
  
  <body>
	<?php include("../Menu.php"); ?>

	<div id="conteneur">
		<!-- Contenu de la page -->
		<section>
		<?php 
			include("../Title.php");

			//CONSULTATION DE LA BASE DE DONNEE
			include("../DatabaseConnection.php");

			//Préparation de la requete sql pour récupéré les informations de la proteine
			$answer = $bdd->prepare('SELECT idProt,nomProt,tailleProt,seqProt,idGene FROM Proteine WHERE idProt = ?');
			//Exécution de la requête avec la proteine en argument
			$answer->execute(array($prot));

		    echo"<TABLE>";

	        //Affiche les résultats de la requête dans un tableau
	        while ($data = $answer->fetch())
	        {
	            echo '<TR><TD>'.'Identifiant de la proteine: '.'</TD><TD>'.$data['idProt'].'</TD></TR>'.
	            '<TR><TD>'.'Nom:  '.'</TD><TD>'.$data['nomProt'].'</TD></TR>'.
	            '<TR><TD>'.'Taille: '.'</TD><TD>'.$data['tailleProt'].'</TD></TR>'.
	            '<TR><TD>'.'Sequence: '.'</TD><TD>'.$data['seqProt'].'</TD></TR>'.
	            '<TR><TD>'.'Gène associé: '.'</TS><TD><a href=../genes/GeneSheet.php?gene='.$data['idGene'].' class=\"nav\">'.$data['idGene'].'</a><br></TD></TR>';
	        }
			$answer->closeCursor();
		?>
	    </TABLE>
	    <?php 
	    	//Affiche le lien vers le transcript
			echo '<a href=TransSheet.php?trans='.$prot.' class=\"nav\">Voir le transcript'.'</a>';
		?>
        </section>
	</div>
	<?php include("../Footer.php"); ?>
	
  </body>

</html>
