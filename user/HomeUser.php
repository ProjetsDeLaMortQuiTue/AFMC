<!DOCTYPE html>
<!-- Page d'affichage des informations de l'utilisateur -->

<html lang="fr">
<!-- Récupère l'utilisateur depuis la variable de session -->
<?php
	session_start();
	$_SESSION['currentPage']="user";
	if ((isset($_SESSION['user'])) && ($_SESSION['user'] != '')){
	$user=$_SESSION['user'];
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
		<?php include("../Title.php");
			
			//Connexion à la base de donnée
			include("../DatabaseConnection.php");
			
			//Préparation de la requête sql pour récupérer toutes les informations de l'utilisateur
			$answer = $bdd->prepare('SELECT alias,email,nom,prenom,nomLabo,dateDeCreation,dateDerniereCo FROM User WHERE alias = ?');
			
			//Exécute la requête avec la variable passée en argument (la variable remplace "?")
			$answer->execute(array($user));
			
			//Affiche les résultats de la requête dans un tableau
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
		?>
		<form action="LogIn.php" method="post">
			<input type="submit" value="Se déconnecter">
		</form>
        </section>
	</div>
	
	<?php include("../Footer.php"); ?>
	
  </body>

</html>
