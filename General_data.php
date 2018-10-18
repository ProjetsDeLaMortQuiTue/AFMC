<!DOCTYPE html>

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
  
  <body>
	<?php include("Menu.php"); ?>
	
	<!-- Milieu de page -->
	<div id="conteneur">
		<!-- Contenu de la page -->
		<section>
			<!-- Titre -->
			<div id="header_txt_box">
				<h2 class="titre">AFMC</h2>
				L'Analyse Facile de Marine et Coralie<br>
				<br>
			</div>
		<?php
			try
			{	//Connection à la base de donnée avec l'utilisateur afmc
				$bdd = new PDO('mysql:host=localhost;dbname=AFMC;charset=utf8','afmc','marine&coralie');
				
			}
			catch (Exception $e)
			{
		        	die('Erreur : ' . $e->getMessage());
			}
				//preparation de la requete sql
				$answerEspece = $bdd->prepare('SELECT nomEsp,nbContigs,nbGenes,nbPFAM,nbProts,nbTrans,pourcCodant,soucheEsp FROM Espece WHERE nomEsp = ?');
				$answerEspece->execute(array($orga));
				$answerContigue = $bdd->prepare('SELECT DISTINCT numSuperContig FROM Espece NATURAL JOIN Contigue WHERE nomEsp = ?');
				$answerContigue->execute(array($orga));
		?>
		        <TABLE>
		<?php
		        //Affiche les resultats de la requête dans un tableau
		        while ($data = $answerEspece->fetch())
		        {
		            echo '<TR><TD>'.'Nom de l\'espece: '.'</TD><TD>'.$data['nomEsp'].'</TD></TR>'.
		            '<TR><TD>'.'Nombres de contigues:  '.'</TD><TD>'.$data['nbContigs'].'</TD></TR>'.
		            '<TR><TD>'.'Nombres de gènes: '.'</TD><TD>'.$data['nbGenes'].'</TD></TR>'.
		            '<TR><TD>'.'Nombres de PFAM: '.'</TD><TD>'.$data['nbPFAM'].'</TD></TR>'.
		            '<TR><TD>'.'Nombres de proteines: '.'</TD><TD>'.$data['nbProts'].'</TD></TR>'.
		            '<TR><TD>'.'Nombres de transcrits: '.'</TD><TD>'.$data['nbTrans'].'</TD></TR>'.
		            '<TR><TD>'.'Pourcentage codant: '.'</TD><TD>'.$data['pourcCodant'].'</TD></TR>'.
		            '<TR><TD>'.'Souche de l\'espèce: '.'</TD><TD>'.$data['soucheEsp'].'</TD></TR>';
		        }
			$answerEspece->closeCursor();
			echo "</TABLE>SuperContigue associé:<TABLE>";
			while ($data = $answerContigue->fetch())
		        {
		            echo '<TR><TD>'.$data['numSuperContig']."</TD></TR>";
		        }
			$answerContigue->closeCursor();
		?>
		        </TABLE>
        </section>
	</div>
	
	<?php include("Footer.php"); ?>
	
  </body>

</html>
