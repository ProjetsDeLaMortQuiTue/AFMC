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
		//Connexion à la base de donnée
		include("DatabaseConnection.php");

		//Requête sql pour les informations des espèces disponibles
		$answer = $bdd->prepare('SELECT nomEsp FROM Espece');
		$answer->execute();

		//On récupère les espèces disponibles dans un tableau
		$organisms = array();
		while ($data = $answer->fetch())
	    {
	        array_push($organisms,$data['nomEsp']);
	    }
		$answer->closeCursor();
  ?>


  <body>
	<?php include("Title.php"); ?>
	<?php include("Menu.php"); ?>
	<!-- Milieu de page -->
	<div id="conteneur">
		<!-- Contenu de la page -->
		<section>
			<p class="text">
				Bonjour et bienvenue sur la base de donnée AFMC!<br><br>
				
				Ici vous trouverez toutes les données de votre équipe où que vous soyez.<br>
				Gènes, protéines, transcrits, phylogénie... Plein de ressources variées 
				sont disponibles pour mener à bien votre projet de recherche.<br>
				Par l'ouverture d'un compte en quelques cliques, il vous sera également 
				permis d'enrichir ces données, et ainsi contribuer à la diffusion de vos 
				découvertes avec vos collaborateurs.<br>
			</p>
			<form action="General_data.php" method="POST">	
					Choisissez un organisme:		
					<?php
						//Créer la liste pour sélectionner l'espèce et l'affiche
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
