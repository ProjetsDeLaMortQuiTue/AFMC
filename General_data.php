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
			<div id="header_txt_box">
				<h2 class="titre">AFMC</h2>
				L'Analyse Facile de Marine et Coralie<br>
				<br>
			</div>
		L'organisme est <?php echo $orga;?>
		</section>
	</div>
	
	<?php include("Footer.php"); ?>
	
  </body>

</html>
