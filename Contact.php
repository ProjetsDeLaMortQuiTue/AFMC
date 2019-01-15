<!DOCTYPE html>

<!-- Page pour contacter les webmasters de la page-->


<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="AFMC.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<title>AFMC</title>
  </head>
  
  <?php session_start();$_SESSION['currentPage']="contact"; ?>
  <body>
    <?php include("Title.php"); ?>
  	<?php include("Menu.php"); ?>
  	<div id="conteneur">
		<section>
			<p class="text">
				Si vous rencontrez la moindre difficulté avec AFMC n'hésitez pas à nous contacter:<br>
				<p class="contact">
				<i class="fa fa-home"></i>&nbsp;&nbsp; MaCo <br> Université Paris-Sud 11<br>Bâtiment 640, PUIO<br>Rue Joliot-Curie<br>91400 ORSAY<br><br>
				<i class="fa fa-phone"></i>&nbsp;&nbsp; 01 69 15 35 28<br><br>
				<i class="fa fa-envelope"></i>&nbsp;&nbsp; <a href=mailto:marine.aglave@u-psud.fr class="mail">marine.aglave@u-psud.fr</a><br><br>
				<i class="fa fa-envelope"></i>&nbsp;&nbsp; <a href=mailto:coralie.rohmer@u-psud.fr class="mail">coralie.rohmer@u-psud.fr</a><br><br>
				<i class="fa fa-twitter"></i>&nbsp;&nbsp;@MaCo<br><br>

				</p>
			</p>
		</section>
	</div>
  	<?php include("Footer.php"); ?>
  </body>
</html>
