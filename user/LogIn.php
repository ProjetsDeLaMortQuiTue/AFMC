<!DOCTYPE html>
<!-- Page d'affichage du formulaire de connexion pour l'utilisateur -->

<html lang="fr">

<?php
	session_start();
	$erreur="";
	$_SESSION['currentPage']="user";
	//On rend vide la variable de session user (cas de la déconnexion)
	if ((isset($_SESSION['user'])) && ($_SESSION['user'] != '')){
	$_SESSION['user']='';
	}
	//Vérification des informations de connexion
	if ((isset($_POST['id'])) && ($_POST['id'] != '')){
		$id = $_POST['id'];
		
		//Connexion à la base de donnée
		include("../DatabaseConnection.php");
		//Préparation de la requête sql pour vérifier l'existance de l'identifiant/email dans la bdd
		$answer = $bdd->prepare('SELECT count(*),mdp,alias FROM User WHERE alias = ? OR email= ?');
		//Exécute la requête avec les variables passées en argument (les variables remplacent "?")
		$answer->execute(array($id,$id));
		while ($data = $answer->fetch())
	   	{
				//Si il existe bien un identifiant/email correspondant à l'entrée utilisateur
	        	if($data['count(*)'] > 0 ){
	        		$mdp=$data['mdp'];
	        		//Si le mot de passe correspond à l'identifiant/email
					if ((isset($_POST['mdp'])) && ($_POST['mdp'] == $mdp)){
						$alias=$data['alias'];
						$_SESSION['user']=$alias;
						$date=date("Y-m-d H:i:s");
						//Mise à jour de la bdd
						$modification = $bdd->prepare('UPDATE User SET dateDerniereCo=? WHERE alias=?');
						$modification->execute(array($date,$alias));
						$modification->closeCursor();
						echo "<meta http-equiv=\"Refresh\" content=\"0;url=HomeUser.php\">";
					}
					//Sinon le mot de passe ne correspond pas à l'identifiant/email
					else{$erreur= "Le mot de passe est incorrecte";}
				}
				//Sinon il n'existe pas d'identifiant/email correspondant à l'entrée utilisateur
				else{$erreur="L'identifiant est incorrecte";}
		}
		$answer->closeCursor();
	}
?>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../AFMC.css"> 
	<title>AFMC</title>
  </head>
  
  <body>
	<?php include("../Title2.php"); ?>
	<?php include("../Menu.php"); ?>

	<div id="conteneur">
		<!-- Contenu de la page -->
		<section>
		<?php echo $erreur?>
		<TABLE>
		<form action='LogIn.php' method="post">
			<TR><TD>Identifiant: </TD><TD><input type="text" name="id"></TD></TR>
			<TR><TD>Mot de passe:  </TD><TD><input type="password" name="mdp"></TD></TR>
			<TR><TD></TD><TD><input type="submit" value="Se connecter">
		<a href='ForgottenPassword.php'>Mot de pass oublié?</a><br></TD></TR>
		</form>
		</TABLE>
		<br><br>
		Vous n'avez pas de compte?<br>
		<form action='SignUp.php' method="post">
			<input type="submit" value="Se crée un compte">
		</form>
        </section>
	</div>
	
	<?php include("../Footer.php"); ?>
	
  </body>

</html>
