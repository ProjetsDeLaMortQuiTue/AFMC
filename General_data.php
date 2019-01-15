<!DOCTYPE html>
<!-- Page affichant les informations générales pour l'espèces-->

<html lang="fr">

<!-- Récupére l'organisme depuis la page home ou la variable de session -->
<?php
	session_start();
	$_SESSION['currentPage']="general_data";
	if ((isset($_POST['orga'])) && ($_POST['orga'] != '')){
	$orga=$_POST['orga'];
	$_SESSION['orga'] = $orga;
	}
	else{
		if ((isset($_SESSION['orga'])) && ($_SESSION['orga'] != '')){
		$orga=$_SESSION['orga'];
		}
		else{$orga='INCONNU';}}
?>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="AFMC.css"> 
	<title>AFMC</title>
  </head>
 	<?php
		//CONSULTATION DE LA BASE DE DONNEE
		include("DatabaseConnection.php");

		//Requete sql pour les informations sur l'espèce
		$answerEspece = $bdd->prepare('SELECT idEsp,nomEsp,nbContigs,nbGenes,nbPFAM,nbProts,nbTrans,pourcCodant,soucheEsp FROM Espece WHERE nomEsp = ?');
		$answerEspece->execute(array($orga));

		//Requete sql pour les informations sur les SuperContig lié à l'espèce
		$answerContigue = $bdd->prepare('SELECT DISTINCT numSuperContig FROM Espece NATURAL JOIN Contigue WHERE nomEsp = ?');
		$answerContigue->execute(array($orga));
	?>



  <body>
	<?php include("Title.php"); ?>
	<?php include("Menu.php"); ?>
	
	<!-- Milieu de page -->
	<div id="conteneur">
		<!-- Contenu de la page -->
		<section>
		<TABLE>
		<?php
	        //Affiche les résultats de la première requête dans un tableau
	        while ($data = $answerEspece->fetch())
	        {
	        	$_SESSION['idOrga'] = $data['idEsp']; //conserve l'identifiant de l'espèce en cours
	            echo '<TR><TD>'.'Nom de l\'espece: '.'</TD><TD>'.$data['nomEsp'].'</TD></TR>'.
	            /*'<TR><TD>'.'Nombres de contigues:  '.'</TD><TD>'.$data['nbContigs'].'</TD></TR>'.*/
	            '<TR><TD>'.'Nombres de gènes: '.'</TD><TD>'.$data['nbGenes'].'</TD></TR>'.
	            '<TR><TD>'.'Nombres de PFAM: '.'</TD><TD>'.$data['nbPFAM'].'</TD></TR>'.
	            '<TR><TD>'.'Nombres de proteines: '.'</TD><TD>'.$data['nbProts'].'</TD></TR>'.
	            '<TR><TD>'.'Nombres de transcrits: '.'</TD><TD>'.$data['nbTrans'].'</TD></TR>'.
	            '<TR><TD>'.'Pourcentage codant: '.'</TD><TD>'.$data['pourcCodant'].'</TD></TR>'.
	            '<TR><TD>'.'Souche de l\'espèce: '.'</TD><TD>'.$data['soucheEsp'].'</TD></TR>';
	        }
			$answerEspece->closeCursor();
			/*
			//Affiche les résultats de la seconde requête dans un tableau
			echo "</TABLE>SuperContigue associé:<TABLE>";
			while ($data = $answerContigue->fetch())
	        {
	            echo '<TR><TD>'.$data['numSuperContig']."</TD></TR>";
	        }
			$answerContigue->closeCursor();
			*/
		?>
		        </TABLE>
        </section>
	</div>
	
	<?php include("Footer.php"); ?>
	
  </body>

</html>
