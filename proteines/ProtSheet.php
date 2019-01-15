<!DOCTYPE html>
<!-- Page d'affichage des informations pour une protéine donnée -->

<html lang="fr">
<?php
	session_start();
	$_SESSION['currentPage']="proteines";
	
	//Récupère la protéine à afficher
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
	<?php include("../Title2.php"); ?>
	<?php include("../Menu.php"); ?>

	<div id="conteneur">
		<!-- Contenu de la page -->
		<section>
		<?php

			//Connexion à la base de donnée
			include("../DatabaseConnection.php");

			//Préparation de la requête sql pour récupérer les informations de la protéine
			$answer = $bdd->prepare('SELECT idProt,nomProt,tailleProt,seqProt,idGene FROM Proteine WHERE idProt = ?');
			//Exécution de la requête avec la protéine en argument
			$answer->execute(array($prot));

		    echo"<TABLE>";

	        //Affiche les résultats de la requête dans un tableau
	        while ($data = $answer->fetch())
	        {
	            echo '<TR><TD>'.'Identifiant de la proteine: '.'</TD><TD>'.$data['idProt'].'</TD></TR>'.
	            '<TR><TD>'.'Nom:  '.'</TD><TD>'.$data['nomProt'].'</TD></TR>'.
	            '<TR><TD>'.'Taille: '.'</TD><TD>'.$data['tailleProt'].'</TD></TR>'.
	            '<TR><TD>'.'Sequence: '.'</TD><TD><TEXTAREA rows=6 cols=60 readonly="readonly">'.$data['seqProt'].'</TEXTAREA></TD></TR>'.
	            '<TR><TD>'.'Gène associé: '.'</TS><TD><a href=../genes/GeneSheet.php?gene='.$data['idGene'].' class=\"nav\">'.$data['idGene'].'</a><br></TD></TR>';
	        }
			$answer->closeCursor();
		?>
	    </TABLE>
	    <?php 
	    	//Affiche le lien vers le transcript correspondant
			echo '<a href=TransSheet.php?trans='.$prot.' class=\"nav\">Voir le transcript'.'</a>';
		?>
        </section>
	</div>
	<?php include("../Footer.php"); ?>
	
  </body>

</html>
