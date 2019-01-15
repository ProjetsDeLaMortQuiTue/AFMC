<!DOCTYPE html>
<!-- Page d'affichage des protéines pour l'espèce donnée -->

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
	<?php include("../Title2.php"); ?>
	<?php include("../Menu.php"); ?>

	<!-- Milieu de page -->
	<div id="conteneur">
		<!-- Contenu de la page -->
		<section>
		<?php

			//Si un organisme a été selectionné
			if ((isset($_SESSION['idOrga'])) && ($_SESSION['idOrga'] != '')){

				//Connexion à la base de donnée
				include("../DatabaseConnection.php");

				//Préparation de la requête sql pour récupérer toutes les protéines de l'espèce donnée
				$answer = $bdd->prepare('SELECT idProt FROM Proteine NATURAL JOIN Gene WHERE idEsp= ?');
				//Exécute la requête avec la variable passée en argument (la variable remplace "?")
				$answer->execute(array($_SESSION['idOrga']));
				echo "<TABLE>";
		        //Affiche les résultats de la requête dans un tableau
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
