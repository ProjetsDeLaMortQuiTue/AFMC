<!DOCTYPE html>

<html lang="fr">
<!-- Récupére l'organisme depuis la variable de session -->
<?php
	session_start();
	$_SESSION['currentPage']="genes";
	if ((isset($_SESSION['orga'])) && ($_SESSION['orga'] != '')){
	$orga=$_SESSION['orga'];
	}
else{$orga='INCONNU';}
?>

<?php
	if ((isset($_GET['gene'])) && ($_GET['gene'] != '')){
	$gene = $_GET['gene'];
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
				$answerGene = $bdd->prepare('SELECT idGene,nomProtGene,tailleGene,debGene,finGene,brin,numChromosome,seqGene FROM Gene WHERE idGene = ?');
				//execute la requête avec la variable passé en argument ($orga remplace ?)
				$answerGene->execute(array($gene));
								//preparation de la requete sql
				$answerProt = $bdd->prepare('SELECT idProt FROM Proteine WHERE idGene = ?');
				//execute la requête avec la variable passé en argument ($orga remplace ?)
				$answerProt->execute(array($gene));
		?>
		        <TABLE>
		<?php
	        $i=0;
	        //Affiche les resultats de la requête dans un tableau
	        while ($data = $answerGene->fetch())
	        {
	            $i++;
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
			$i=0; 
			echo '<TR><TD>Proteine(s) issus du gène:</TD><TD>';
	        //Affiche les resultats de la requête dans un tableau
	        while ($data = $answerProt->fetch())
	        {
	            $i++;
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
