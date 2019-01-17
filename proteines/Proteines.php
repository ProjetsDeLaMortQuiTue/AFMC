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
<!--RECUPERACTION DES INFORMATIONS DE LA BASE DE DONNEE -->
  <?php
		//Si un organisme a été selectionné
		if ((isset($_SESSION['idOrga'])) && ($_SESSION['idOrga'] != '')){

			//Connexion à la base de donnée
			include("../DatabaseConnection.php");

			//PROTEINE ENTIEREMENT ANNOTE
			//Requête sql pour récupérer tous les proteines qui sont annotés
			$answerProtsAnnoté = $bdd->prepare('SELECT DISTINCT p.idProt FROM Proteine p JOIN Gene g JOIN UniProt un JOIN Structure s WHERE g.idGene=p.idGene AND idEsp= ? AND p.idProt=un.idProt AND p.idProt=s.idProt');
			$answerProtsAnnoté->execute(array($_SESSION['idOrga']));
			
			//Récupére les proetines entirement annoté dans une liste
			$protsAnnoté=array();
			while ($data = $answerProtsAnnoté->fetch()){array_push($protsAnnoté,$data['idProt']);}
			$answerProtsAnnoté->closeCursor();
			$nbProtsAnnoté=count($protsAnnoté);
			//PROTEINES PARTIELLEMENT ANNOTE
			//Prépare la liste des proteines à exclure (les entiérement annoté).
			$SQLProtsAnnote='';
			if ($nbProtsAnnoté > 0){
				$SQLProtsAnnote=' AND p.idProt NOT IN (?';
				for ($i = 2; $i <= $nbProtsAnnoté; $i++) {$SQLProtsAnnote.=",?";}
				$SQLProtsAnnote.=")";
			}

			//Requête sql pour récupérer les proteines qui sont annotés en partie
			$answerProtsEnPartieAnnoté = $bdd->prepare('SELECT DISTINCT p.idProt FROM Proteine p JOIN Gene g JOIN UniProt un JOIN Structure s WHERE g.idGene=p.idGene AND idEsp= ? AND (p.idProt=un.idProt OR p.idProt=s.idProt)'.$SQLProtsAnnote.';');
			$answerProtsEnPartieAnnoté->execute(array_merge(array($_SESSION['idOrga']),$protsAnnoté));

			//Récupére les proteines en partie annoté dans une liste
			$protsEnPartieAnnoté=array();
			while ($data = $answerProtsEnPartieAnnoté->fetch()){array_push($protsEnPartieAnnoté,$data['idProt']);}
			$answerProtsEnPartieAnnoté->closeCursor();
			$nbProtsEnPartieAnnoté=count($protsEnPartieAnnoté);

			//PROTEINE NON ANNOTE
			//Prépare la liste des proteines à exclure (les entiérement annoté + les en partie annoté).
			$SQLProtsExclus='';
			if ( ($nbProtsAnnoté + $nbProtsEnPartieAnnoté) > 0){
				$SQLProtsExclus=' AND p.idProt NOT IN (?';
				for ($i = 2; $i <= ($nbProtsAnnoté + $nbProtsEnPartieAnnoté) ; $i++) {$SQLProtsExclus.=",?";}
				$SQLProtsExclus.=")";
			}

			//Requête sql pour récupérer les gènes qui ne sont pas annotés
			$answerProtsNonAnnoté = $bdd->prepare('SELECT DISTINCT idProt FROM Proteine p JOIN Gene g WHERE g.idGene=p.idGene AND idEsp=?'.$SQLProtsExclus.';');
			
			$answerProtsNonAnnoté->execute(array_merge(array($_SESSION['idOrga']),array_merge($protsAnnoté,$protsEnPartieAnnoté)));

			//Récupére les proteines non annoté dans une liste
			$protsNonAnnoté = array();
			while ($data = $answerProtsNonAnnoté->fetch()){array_push($protsNonAnnoté,$data['idProt']);}
			$answerProtsNonAnnoté->closeCursor();
			$nbProtsNonAnnoté=count($protsNonAnnoté);
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
			<input type="hidden" name="categorie" value="Proteine">
			<input type="submit" value="Faire une recherche plus détaillé">
		</form>
		<br>
		 Nombre de proteines non annotés: <? echo $nbProtsNonAnnoté ?> <br>
		 Nombre de proteines partiellement annotés: <? echo $nbProtsEnPartieAnnoté ?> <br>
		 Nombre de proteines non annotés: <? echo $nbProtsAnnoté ?> <br>
		 <br>
		<!-- AFFICHAGE DES PROTEINES DANS LE TABLEAU -->
		<TABLE BORDER="1" style="text-align:center">
		<TR><TD>Proteine non annotés</TD><TD>Proteine partiellement annotés</TD><TD>Proteine entièrement annotés</TD></TR>
		<?php
			for($i=0; $i<max($nbProtsAnnoté,$nbProtsEnPartieAnnoté,$nbProtsNonAnnoté) ; $i++){
				echo "<TR>";
				if($i < $nbProtsNonAnnoté){
					echo "<TD><a href=ProtSheet.php?prot=".$protsNonAnnoté[$i].">".$protsNonAnnoté[$i]."</a></TD>";
				}
				else {echo "<TD></TD>";}
				if($i < $nbProtsEnPartieAnnoté){
					echo "<TD><a href=ProtSheet.php?prot=".$protsEnPartieAnnoté[$i].">".$protsEnPartieAnnoté[$i]."</a></TD>";
				}
				else {echo "<TD></TD>";}
				if($i < $nbProtsAnnoté){
					echo "<TD><a href=ProtSheet.php?prot=".$protsAnnoté[$i].">".$protsAnnoté[$i]."</a></TD>";
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
