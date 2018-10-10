<!DOCTYPE html>

<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="AFMC.css"> 
	<title>AFMC</title>
  </head>
  
  <?php session_start();$_SESSION['currentPage']="home"; ?>
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
			<form action="General_data.php" method="POST">	
					Choix de l'organisme:		
					<?php
						$organisms = ['Botrytis Cinerea'];
						$liste = '<select size=1 name="orga">';
						foreach($organisms as $organism){
						    $liste .= '<option value="'.$organism.'">'.$organism.'</option>';
						}
						$liste .= '</select>';
						echo $liste;
					?>
				    <input type="submit" value="Choisir">
			</form>
		</section>
	</div>
	
	<?php include("Footer.php"); ?>
	
  </body>
</html>
