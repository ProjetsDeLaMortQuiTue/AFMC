<!DOCTYPE html>

<html lang="fr">
<!-- Récupére l'organisme depuis la variable de session -->
<?php
	session_start();
	$_SESSION['currentPage']="user";
	if ((isset($_SESSION['user'])) && ($_SESSION['user'] != '')){
	$user=$_SESSION['user'];
	}
	else{$user= $_POST["user"];
		$_SESSION['user']=$user;
		$mdp= $_POST["mdp"];
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
		Ceci est la page pour l'utilisateur <?php echo $user;?>
		<form action="LogIn.php" method="post">
		<input type="submit" value="Se déconnecter">
		</form>
        </section>
	</div>
	
	<?php include("../Footer.php"); ?>
	
  </body>

</html>