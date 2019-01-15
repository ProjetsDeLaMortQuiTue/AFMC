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
	<?php include("../Title2.php"); ?>
	<?php include("../Menu.php"); ?>

	<div id="conteneur">
		<!-- Contenu de la page -->
		<section>
		
		<?php
			//Si un organisme a été selectionné
			if ((isset($_SESSION['idOrga'])) && ($_SESSION['idOrga'] != '')){

				//Connexion à la base de donnée
				include("../DatabaseConnection.php");
				echo '<form action="../search/Search.php" method="post">
						<input type="hidden" name="categorie" value="Gene">
						<input type="submit" value="Faire une recherche plus détaillé">
					</form></TD><TD>';
				//Prépare la requête sql pour récupérer tous les gènes de l'espèce donnée
				$answerGenesAnnoté = $bdd->prepare('SELECT DISTINCT idGene FROM Gene NATURAL JOIN Phylogenie WHERE idEsp= ?');
				//Exécute la requête avec la variable passé en argument (la variable remplace "?")
				$answerGenesAnnoté->execute(array($_SESSION['idOrga']));

				$genesAnnoté = array();
				while ($data = $answerGenesAnnoté->fetch())
			        {
			        	array_push($genesAnnoté,$data['idGene']);
			            echo '<TR><TD><a href=GeneSheet.php?gene='.$data['idGene'].' class=\"nav\">'.$data['idGene'].'</a><br></TD></TR>';
			        }
				$answerGenesAnnoté->closeCursor();
				$nbGenesAnnoté=count($genesAnnoté);
				echo "nombre de gene annoté :".$nbGenesAnnoté;
				$SQLGeneAnnote='';
				if ($nbGenesAnnoté > 0){
					$SQLGeneAnnote=' idGene NOT IN (?';
					for ($i = 2; $i < $nbGenesAnnoté; $i++) {$SQLGeneAnnote.=",?";}
					$SQLGeneAnnote.=",?) AND ";
				}


				//Prépare la requête sql pour récupérer tous les gènes de l'espèce donnée
				$answerGenesNonAnnoté = $bdd->prepare('SELECT idGene FROM Gene WHERE'.$SQLGeneAnnote.' idEsp = ?');
				//Exécute la requête avec la variable passé en argument (la variable remplace "?")
				array_push($genesAnnoté,$_SESSION['idOrga']);
				$answerGenesNonAnnoté->execute($genesAnnoté);
				echo "<TABLE><TR><TD>Gene non annoté</TD><TD>Gene en cours annotation</TD><TD>Gene annoté</TD></TR>";
				//Affiche les résultats de la requête dans la page, sous forme de lien vers le détail de chaque gène
				$genesNonAnnoté = array();
				while ($data = $answerGenesNonAnnoté->fetch())
			        {
			        	array_push($genesNonAnnoté,$data['idGene']);
			            //echo '<TR><TD><a href=GeneSheet.php?gene='.$data['idGene'].' class=\"nav\">'.$data['idGene'].'</a><br></TD></TR>';
			        }
				$answerGenesNonAnnoté->closeCursor();
				echo "nombre de gene :".count($genesNonAnnoté);
			}
		?>
		        </TABLE>
        </section>
	</div>
	
	<?php include("../Footer.php"); ?>
	
  </body>

</html>
