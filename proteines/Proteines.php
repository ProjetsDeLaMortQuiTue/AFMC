<!DOCTYPE html>
<!-- Page d'affichage des proteines pour l'espèce donnée -->

<html lang="fr">
<?php
	session_start();
	$_SESSION['currentPage']="proteines";
?>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../AFMC.css"> 
	<title>AFMC</title>
  </head>
  
  <body>
	<?php include("../Menu.php"); ?>
	
	<!-- Milieu de page -->
	<div id="conteneur">
		<!-- Contenu de la page -->
		<section>
		<?php 
			include("../Title.php");

			//Si un organisme a été selectionné
			if ((isset($_SESSION['idOrga'])) && ($_SESSION['idOrga'] != '')){

				//CONSULTATION DE LA BASE DE DONNEE
				include("../DatabaseConnection.php");

				//Requete sql pour récupérer toute les proteines de l'espèces donné
				$answer = $bdd->prepare('SELECT idProt FROM Proteine NATURAL JOIN Gene WHERE idEsp= ?');
				//Execute la requête avec la variable passé en argument (la variable remplace ?)
				$answer->execute(array($_SESSION['idOrga']));
				echo "<TABLE>";
		        //Affiche les resultats de la requête dans un tableau
		        while ($data = $answer->fetch())
		        {
		            echo '<TR><TD><a href=ProtSheet.php?prot='.$data['idProt'].' class=\"nav\">'.$data['idProt'].'</a><br></TD></TR>';
		        }
				$answer->closeCursor();
			}
		?>
		</TABLE>
		</section>
	</div>
	
	<?php include("../Footer.php"); ?>
	
  </body>

</html>
