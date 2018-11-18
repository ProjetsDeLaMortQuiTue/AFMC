<!DOCTYPE html>
<!-- Page qui affiche tout les gènes existants pour l'espèce donné-->


<html lang="fr">

<?php
	session_start();
	$_SESSION['currentPage']="genes";
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
		<?php include("../Title.php"); ?>
		
		<?php
			//Si un organisme a été selectionné
			if ((isset($_SESSION['idOrga'])) && ($_SESSION['idOrga'] != '')){

				//Connexion à la base de donnée
				include("../DatabaseConnection.php");

				//Prépare la requête sql pour récupérer tous les gènes de l'espèce donnée
				$answer = $bdd->prepare('SELECT idGene FROM Gene WHERE idEsp= ?');
				//Exécute la requête avec la variable passé en argument (la variable remplace "?")
				$answer->execute(array($_SESSION['idOrga']));
				echo "<TABLE>";
				//Affiche les résultats de la requête dans la page, sous forme de lien vers le détail de chaque gène
				while ($data = $answer->fetch())
			        {
			            echo '<TR><TD><a href=GeneSheet.php?gene='.$data['idGene'].' class=\"nav\">'.$data['idGene'].'</a><br></TD></TR>';
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
