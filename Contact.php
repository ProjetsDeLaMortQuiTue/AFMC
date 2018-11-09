<!DOCTYPE html>

<!-- Page pour contacter les webmasters de la page-->


<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="AFMC.css"> 
	<title>AFMC</title>
  </head>
  
  <?php session_start();$_SESSION['currentPage']="contact"; ?>
  <body>
  	<?php include("Menu.php"); ?>
    <?php include("Title.php"); ?>
  	<?php include("Footer.php"); ?>
  </body>
</html>