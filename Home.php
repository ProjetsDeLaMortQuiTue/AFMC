<!DOCTYPE html>
<!-- Page d'accueil et choix de l'espèce -->

<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="AFMC.css"> 
	<title>AFMC</title>
  </head>
  
  <?php session_start();$_SESSION['currentPage']="home"; ?>
  <?php
		//CONSULTATION DE LA BASE DE DONNEE
		include("DatabaseConnection.php");

		//Requete sql pour les informations des espèces disponibles
		$answer = $bdd->prepare('SELECT nomEsp FROM Espece');
		$answer->execute();

		//On récupére les espèces disponible dans un tableau
		$organisms = array();
		while ($data = $answer->fetch())
	    {
	        array_push($organisms,$data['nomEsp']);
	    }
		$answer->closeCursor();
  ?>


  <body>
	<?php include("Menu.php"); ?>
	
	<!-- Milieu de page -->
	<div id="conteneur">
		<!-- Contenu de la page -->
		<section>
			<?php include("Title.php"); ?>
			<form action="General_data.php" method="POST">	
					Choix de l'organisme:		
					<?php
						//Crée la liste pour sélectionné l'espèce et l'affiche
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
