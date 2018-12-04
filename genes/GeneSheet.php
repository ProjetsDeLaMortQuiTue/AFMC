<!DOCTYPE html>
<!-- Page qui affiche un gène pour un organisme donné -->

<html lang="fr">
<?php
	session_start();
	$_SESSION['currentPage']="genes";

	//Récupère le gène à afficher
	if ((isset($_GET['gene'])) && ($_GET['gene'] != '')){
	$gene = $_GET['gene'];
	}
	else{$gene='INCONNU';}
?>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../AFMC.css"> 
	<title>AFMC</title>
  </head>
  	<?php
		//Connexion à la base de donnée
		include("../DatabaseConnection.php");

		//Préparation de la requête sql pour récupérer les informations sur le gène
		$answerGene = $bdd->prepare('SELECT idGene,nomProtGene,tailleGene,debGene,finGene,brin,numChromosome,seqGene FROM Gene WHERE idGene = ?');
		//Exécute la requête avec la variable passée en argument ($gene remplace "?")
		$answerGene->execute(array($gene));
		
		//Préparation de la requête sql pour récupérer les proteines associés au gène
		$answerProt = $bdd->prepare('SELECT idProt FROM Proteine WHERE idGene = ?');
		//Exécute la requête avec la variable passée en argument ($gene remplace "?")
		$answerProt->execute(array($gene));

		//Préparation de la requête sql pour récupérer les phyolgenie associés au gène
		$answerPhylo = $bdd->prepare('SELECT idUser,fichier,autresDonne,annotation FROM Phylogenie WHERE idGene = ?');
		//Exécute la requête avec la variable passée en argument ($gene remplace "?")
		$answerPhylo->execute(array($gene));
	?>
  <body>
	<?php include("../Menu.php"); ?>

	<div id="conteneur">
		<!-- Contenu de la page -->
		<section>
		<?php 
			include("../Title.php");
			echo "<h1>Données présentent sur le gène</h1>";
		    echo '<TABLE>';
	        //Affiche les informations sur le gène
	        while ($data = $answerGene->fetch())
	        {
	            echo '<TR><TD>'.'Identifiant du gène: '.'</TD><TD>'.$data['idGene'].'</TD></TR>'.
	            '<TR><TD>'.'Fonction:  '.'</TD><TD>'.$data['nomProtGene'].'</TD></TR>'.
	            '<TR><TD>'.'Taille: '.'</TD><TD>'.$data['tailleGene'].'</TD></TR>'.
	            '<TR><TD>'.'Début: '.'</TD><TD>'.$data['debGene'].'</TD></TR>'.
	            '<TR><TD>'.'Fin: '.'</TD><TD>'.$data['finGene'].'</TD></TR>'.
	            '<TR><TD>'.'Brin: '.'</TD><TD>'.$data['brin'].'</TD></TR>'.
	            '<TR><TD>'.'Numéro du chromosome: '.'</TD><TD>'.$data['numChromosome'].'</TD></TR>'.
	            '<TR><TD>'.'Sequence: '.'</TD><TD>'.$data['seqGene'].'</TD></TR>';
	        }
			$answerGene->closeCursor();

			echo '<TR><TD>Proteine(s) issus du gène:</TD><TD>';

	        //Affiche les proteines issus du gene
	        while ($data = $answerProt->fetch())
	        {
	            echo '<TR><TD><a href=../proteines/ProtSheet.php?prot='.$data['idProt'].'>'.$data['idProt'].';'.'</a><br></TD></TR>';
	        }
			$answerProt->closeCursor();
			echo '</TD></TR>';
		?>
		</TABLE>
		<h1>Données ajoutées par les utilisateurs sur le gène</h1>
		<?php
			echo 'Phylogenie possible pour le gène:<BR><TABLE>';
			//Affiche les phylogenies du le gène
			$compteurPhylo=0;
	        while ($data = $answerGene->fetch())
	        {
	        	$compteurPhylo++;
				echo "Fichier :".$data['seqGene']."; autresDonne :".$data['autresDonne']."a nnotation :".$data['annotation']."<a href=../users/UserSheet.php?id=".$data['idUser'].'>Contacter l\'utilisateur</a>';
	        }
	        $answerGene->closeCursor();
	        if ($compteurPhylo==0){echo "Aucune phylogénie n'est disponible pour ce gène";}
			
		?>
		</TABLE><br>
		<form action=addPhylo.php method="get">
			<input type="hidden" name="gene" value=<?php echo $gene ?>>
			<input type="submit" value="Ajouter une phylogénie">
		</form>
      	</section>
	</div>
	
	<?php include("../Footer.php"); ?>
	
  </body>

</html>
