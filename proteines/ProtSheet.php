<!DOCTYPE html>

<html lang="fr">
<!-- Récupére l'organisme depuis la variable de session -->
<?php
	session_start();
	$_SESSION['currentPage']="proteines";
	if ((isset($_SESSION['orga'])) && ($_SESSION['orga'] != '')){
	$orga=$_SESSION['orga'];
	}
else{$orga='INCONNU';}
?>

<?php
	if ((isset($_GET['prot'])) && ($_GET['prot'] != '')){
	$prot = $_GET['prot'];
	}
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
				$answer = $bdd->prepare('SELECT idProt,nomProt,tailleProt,seqProt,idGene FROM Proteine WHERE idProt = ?');
				$answer->execute(array($prot));
		?>
		        <TABLE>
		<?php
	        $i=0;
	        //Affiche les resultats de la requête dans un tableau
	        while ($data = $answer->fetch())
	        {
	            $i++;
	            echo '<TR><TD>'.'Identifiant de la proteine: '.'</TD><TD>'.$data['idProt'].'</TD></TR>'.
	            '<TR><TD>'.'Nom:  '.'</TD><TD>'.$data['nomProt'].'</TD></TR>'.
	            '<TR><TD>'.'Taille: '.'</TD><TD>'.$data['tailleProt'].'</TD></TR>'.
	            '<TR><TD>'.'Sequence: '.'</TD><TD>'.$data['seqProt'].'</TD></TR>'.
	            '<TR><TD>'.'Gène associé: '.'</TS><TD><a href=../genes/GeneSheet.php?gene='.$data['idGene'].' class=\"nav\">'.$data['idGene'].'</a><br></TD></TR>';
	        }
			$answer->closeCursor();
		?>
		        </TABLE>
        </section>
	</div>
	
	<?php include("../Footer.php"); ?>
	
  </body>

</html>
