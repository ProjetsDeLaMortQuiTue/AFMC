<!DOCTYPE html>

<html lang="fr">
<!-- Récupére l'organisme depuis la variable de session -->
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
		<?php include("../Title.php"); ?>
		<?php
			try
			{	//Connection à la base de donnée avec l'utilisateur afmc
				$bdd = new PDO('mysql:host=localhost;dbname=AFMC;charset=utf8','afmc','marine&coralie');
				
			}
			catch (Exception $e)
			{
		        	die('Erreur : ' . $e->getMessage());
			}

			$answer = $bdd->prepare('SELECT alias,email,nom,prenom,nomLabo,dateDeCreation,dateDerniereCo FROM User WHERE alias = ?');
			$answer->execute(array($user));
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