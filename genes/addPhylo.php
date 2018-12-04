<!DOCTYPE html>
<!-- Page qui permet d'ajouter une phylogénie-->

<html lang="fr">
<?php
	session_start();
	$_SESSION['currentPage']="genes";

	//Récupère le gène associé à cette nouvelle phylogénie
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
  <body>
	<?php include("../Menu.php"); ?>

	<div id="conteneur">
		<!-- Contenu de la page -->
		<section>
		<?php 
			include("../Title.php");
			if ((isset($_SESSION['user'])) && ($_SESSION['user'] != '')){
				echo "<h1>Ajout d'une phylogénie pour le gène ".$gene."</h1>";
		    	echo '<form action=\'addPhylo.php\' method="post"><TABLE>';
		    	echo '<TR><TD>Fichier:</TD><TD><input type="text" name="fichier"></TD></TR>
		    	<TR><TD>autreDonnee:</TD><TD><input type="text" name="autreDonne"></TD></TR>
		    	<TR><TD>annotation:</TD><TD><input type="text" name="annotation"></TD></TR>
				</TABLE><input type="image" src="../ok.png">';
			}else{
				echo "Pour ajouter une phylogénie vous devez être connecté.<br>";
				echo "Cliqué <a href='../user/LogIn.php'>ici</a> pour vous connecter ou <a href='../user/SignUp.php'>ici</a> pour vous crée un compte";
			}
		?>
      	</section>
	</div>
	
	<?php include("../Footer.php"); ?>
	
  </body>

</html>