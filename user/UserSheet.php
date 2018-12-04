<!DOCTYPE html>
<!-- Page d'affichage des informations pour un utilisteur donnée -->

<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../AFMC.css"> 
	<title>AFMC</title>
  </head>
  
  <?php session_start();$_SESSION['currentPage']="user";?>
  <body>

	<?php include("../Menu.php"); ?>
	
	<!-- Milieu de page -->
	<div id="conteneur">
		<!-- Contenu de la page -->
		<section>
		<?php include("../Title.php"); ?>
		<?php

			if (isset($_GET['id']) && $_GET['id']){
				$id=$_GET['id'];

				//CONSULTATION DE LA BASE DE DONNEE
				include("../DatabaseConnection.php");

				//Préparation et exécution requête
				$answer = $bdd->prepare('SELECT alias,email,nom,prenom,nomLabo,dateDeCreation,dateDerniereCo FROM User WHERE idUser = ?');
				$answer->execute(array($id));

				//Affichage des informations dans une table
				echo "<TABLE>";
				while ($data = $answer->fetch())
				{
		            echo '<TR><TD>'.'Identifiant: '.'</TD><TD>'.$data['alias'].'</TD></TR>'.
		            '<TR><TD>'.'Email:  '.'</TD><TD>'.$data['email'].'</TD></TR>'.
		            '<TR><TD>'.'Nom: '.'</TD><TD>'.$data['nom'].'</TD></TR>'.
		            '<TR><TD>'.'Prenom: '.'</TD><TD>'.$data['prenom'].'</TD></TR>'.
		            '<TR><TD>'.'Laboratoire: '.'</TD><TD>'.$data['nomLabo'].'</TD></TR>'.
		            '<TR><TD>'.'Date de creation: '.'</TD><TD>'.$data['dateDeCreation'].'</TD></TR>'.
		            '<TR><TD>'.'Date de dernière connexion: '.'</TD><TD>'.$data['dateDerniereCo'].'</TD></TR>';
				}
				$answer->closeCursor();
				echo "</TABLE>";
			}
			 ?>
        </section>
	</div>
	
	<?php include("../Footer.php"); ?>
	
  </body>
</html>
