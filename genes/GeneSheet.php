<!DOCTYPE html>
<!-- Page qui affiche un gene pour un organisme donnée -->

<html lang="fr">
<?php
	session_start();
	$_SESSION['currentPage']="genes";

	//Récupére le gène à afficher
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
		//CONSULTATION DE LA BASE DE DONNEE
		include("../DatabaseConnection.php");

		//Préparation de la requête sql pour récupérer les informations sur le gène
		$answerGene = $bdd->prepare('SELECT idGene,nomProtGene,tailleGene,debGene,finGene,brin,numChromosome,seqGene FROM Gene WHERE idGene = ?');
		//Execute la requête avec la variable passé en argument ($gene remplace ?)
		$answerGene->execute(array($gene));
		
		//Préparation de la requête sql pour récupérer les proteines associés au gène
		$answerProt = $bdd->prepare('SELECT idProt FROM Proteine WHERE idGene = ?');
		//Execute la requête avec la variable passé en argument ($gene remplace ?)
		$answerProt->execute(array($gene));
	?>
  <body>
	<?php include("../Menu.php"); ?>

	<div id="conteneur">
		<!-- Contenu de la page -->
		<section>
		<?php 
			include("../Title.php");
		    echo '<TABLE>';
	        //Affiche les résultats de la première requête dans un tableau
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
	        //Affiche les resultats de la seconde requête dans le tableau
	        while ($data = $answerProt->fetch())
	        {
	            echo '<TR><TD><a href=../proteines/ProtSheet.php?prot='.$data['idProt'].' class=\"nav\">'.$data['idProt'].';'.'</a><br></TD></TR>';
	        }
			$answerProt->closeCursor();
			echo '</TD></TR>';
		?>
		</TABLE>
        </section>
	</div>
	
	<?php include("../Footer.php"); ?>
	
  </body>

</html>
