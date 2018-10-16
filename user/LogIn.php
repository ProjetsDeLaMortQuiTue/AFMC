<!DOCTYPE html>

<html lang="fr">
<!-- Récupére l'organisme depuis la variable de session -->
<?php
	session_start();
	$_SESSION['currentPage']="user";
	if ((isset($_SESSION['orga'])) && ($_SESSION['orga'] != '')){
	$orga=$_SESSION['orga'];
	}
else{$orga='INCONNU';}
	if ((isset($_SESSION['user'])) && ($_SESSION['user'] != '')){
	$_SESSION['user']='';
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
		Ceci est la page pour se connecter
		<form action="HomeUser.php" method="post">
		Identifiant:<input type="text" name="user"><br>
		Mot de passe:<input type="password" name="mdp"><br>
		<input type="submit" value="Se connecter">
		</form>
        </section>
	</div>
	
	<?php include("../Footer.php"); ?>
	
  </body>

</html>
