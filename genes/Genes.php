<!DOCTYPE html>

<html lang="fr">
<!-- Récupére l'organisme depuis la variable de session -->
<?php
	session_start();
	if ((isset($_SESSION['orga'])) && ($_SESSION['orga'] != '')){
	$orga=$_SESSION['orga'];
	}
else{$orga='INCONNU';}
?>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../AFMC.css"> 
	<title>AFMC</title>
  </head>
  
  <body>
	 <!-- Bandeau supérieur -->
	 <div id="menu_home">
			<p class="navigation_out">
				<a href="../Home.php" class="nav">Accueil</a><br>
			</p>
			<p class="navigation_out">
				<a href="../General_data.php" class="nav">Informations généraux</a><br>
			</p>
			<p class="navigation_in">
				<a href="Genes.php" class="nav">Gènes</a><br>
			</p>
			<p class="navigation_out">
				<a href="../proteines/Proteines.php" class="nav">Proteines</a><br>
			</p>
			<p class="navigation_out">
				<a href="Contact.html" class="nav">Contact</a><br>
			</p>
	</div>
	
	<!-- Milieu de page -->
	<div id="conteneur">
		<!-- Contenu de la page -->
		<section>
			<div id="header_txt_box">
				<h2 class="titre">AFMC</h2>
				L'Analyse Facile de Marine et Coralie<br>
				<br>
			</div>
		Ici les genes pour l'organisme: <?php echo $orga;?>
		</section>
	</div>
	
	<!-- Bandeau inférieur haut -->
	<div id="footer_up">
		<div id="footer_up_inside">
		Créé par Marine & Coralie
		</div>
	</div>
	
	<!-- Bandeau inférieur bas -->
	<div id="footer_bottom">
		<img src="bioinformatic_heorin2.jpg" alt="Heorin"/>
	</div>
	
  </body>

</html>
