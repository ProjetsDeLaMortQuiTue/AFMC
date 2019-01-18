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
 <!--RECUPERACTION DES INFORMATIONS DE LA BASE DE DONNEE -->
  <?php
		//Si un organisme a été selectionné
		if ((isset($_SESSION['idOrga'])) && ($_SESSION['idOrga'] != '')){

			//Connexion à la base de donnée
			include("../DatabaseConnection.php");

			//GENE ENTIEREMENT ANNOTE
			//Requête sql pour récupérer tous les gènes qui sont annotés
			$answerGenesAnnoté = $bdd->prepare('SELECT DISTINCT g.idGene FROM Gene g JOIN Phylogenie ph JOIN KEGG k WHERE idEsp= ? AND g.idGene=ph.idGene AND g.idGene=k.idGene');
			$answerGenesAnnoté->execute(array($_SESSION['idOrga']));

			//Récupére les gènes entirement annoté dans une liste
			$genesAnnoté=array();
			while ($data = $answerGenesAnnoté->fetch()){array_push($genesAnnoté,$data['idGene']);}
			$answerGenesAnnoté->closeCursor();
			$nbGenesAnnoté=count($genesAnnoté);
			//GENE PARTIELLEMENT ANNOTE
			//Prépare la liste de gène à exclure (les entiérement annoté).
			$SQLGeneAnnote='';
			if ($nbGenesAnnoté > 0){
				$SQLGeneAnnote=' AND g.idGene NOT IN (?';
				for ($i = 2; $i <= $nbGenesAnnoté; $i++) {$SQLGeneAnnote.=",?";}
				$SQLGeneAnnote.=")";
			}

			//Requête sql pour récupérer les gènes qui sont annotés en partie
			$answerGenesEnPartieAnnoté = $bdd->prepare('SELECT DISTINCT g.idGene FROM Gene g JOIN Phylogenie ph JOIN KEGG k WHERE idEsp=? AND (g.idGene=ph.idGene OR g.idGene=k.idGene)'.$SQLGeneAnnote.';');
			$answerGenesEnPartieAnnoté->execute(array_merge(array($_SESSION['idOrga']),$genesAnnoté));

			//Récupére les gènes en partie annoté dans une liste
			$genesEnPartieAnnoté=array();
			while ($data = $answerGenesEnPartieAnnoté->fetch()){array_push($genesEnPartieAnnoté,$data['idGene']);}
			$answerGenesEnPartieAnnoté->closeCursor();
			$nbGenesEnPartieAnnoté=count($genesEnPartieAnnoté);

			//GENE NON ANNOTE
			//Prépare la liste de gène à exclure (les entiérement annoté + les en partie annoté).
			$SQLGeneExclus='';
			if ( ($nbGenesAnnoté + $nbGenesEnPartieAnnoté) > 0){
				$SQLGeneExclus=' AND idGene NOT IN (?';
				for ($i = 2; $i <= ($nbGenesAnnoté + $nbGenesEnPartieAnnoté) ; $i++) {$SQLGeneExclus.=",?";}
				$SQLGeneExclus.=")";
			}

			//Requête sql pour récupérer les gènes qui ne sont pas annotés
			$answerGenesNonAnnoté = $bdd->prepare('SELECT DISTINCT idGene FROM Gene WHERE idEsp=?'.$SQLGeneExclus.';');

			$answerGenesNonAnnoté->execute(array_merge(array($_SESSION['idOrga']),array_merge($genesAnnoté,$genesEnPartieAnnoté)));

			//Récupére les gènes non annoté dans une liste
			$genesNonAnnoté = array();
			while ($data = $answerGenesNonAnnoté->fetch()){array_push($genesNonAnnoté,$data['idGene']);}
			$answerGenesNonAnnoté->closeCursor();
			$nbGenesNonAnnoté=count($genesNonAnnoté);
		}
?>
  <body>
	<?php include("../Title2.php"); ?>
	<?php include("../Menu.php"); ?>

	<div id="conteneur">
		<!-- Contenu de la page -->
		<section>
		
		<!--Affiche le bouton de redirection vers la page de recherche-->
		<form action="../search/Search.php" method="post">
			<input type="hidden" name="categorie" value="Gene">
			<input type="submit" value="Faire une recherche plus détaillé">
		</form>
		<br>
		 Nombre de gènes non-annotés: <? echo $nbGenesNonAnnoté ?> <br>
		 Nombre de gènes partiellement annotés: <? echo $nbGenesEnPartieAnnoté ?> <br>
		 Nombre de gènes annotés: <? echo $nbGenesAnnoté ?> <br>
		 <br>
		<!-- AFFICHAGE DES GENES DANS LE TABLEAU -->
		<TABLE BORDER="1" style="text-align:center" cellspacing="0">
		<TR><TD bgcolor="#81CCB8">Gènes non-annotés</TD><TD bgcolor="#81CCB8">Gènes partiellement annotés</TD><TD bgcolor="#81CCB8">Gènes entièrement annotés</TD></TR>
		<?php
			for($i=0; $i<max($nbGenesAnnoté,$nbGenesEnPartieAnnoté,$nbGenesNonAnnoté) ; $i++){
				echo "<TR>";
				if($i < $nbGenesNonAnnoté){
					echo "<TD><a href=GeneSheet.php?gene=".$genesNonAnnoté[$i].">".$genesNonAnnoté[$i]."</a></TD>";
				}
				else {echo "<TD></TD>";}
				if($i < $nbGenesEnPartieAnnoté){
					echo "<TD><a href=GeneSheet.php?gene=".$genesEnPartieAnnoté[$i].">".$genesEnPartieAnnoté[$i]."</a></TD>";
				}
				else {echo "<TD></TD>";}
				if($i < $nbGenesAnnoté){
					echo "<TD><a href=GeneSheet.php?gene=".$genesAnnoté[$i].">".$genesAnnoté[$i]."</a></TD>";
				}
				else {echo "<TD></TD>";}
				echo "</TR>";
			}

		?>

		<TABLE>
        </section>
	</div>
	
	<?php include("../Footer.php"); ?>
	
  </body>

</html>
