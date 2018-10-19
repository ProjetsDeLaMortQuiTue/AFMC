<!DOCTYPE html>

<html lang="fr">
<!-- Récupére l'organisme depuis la variable de session -->
<?php
	session_start();
	$erreur="";
	$_SESSION['currentPage']="user";
	if ((isset($_SESSION['orga'])) && ($_SESSION['orga'] != '')){
		$orga=$_SESSION['orga'];
	}
else{$orga='INCONNU';}
	if ((isset($_SESSION['user'])) && ($_SESSION['user'] != '')){
	$_SESSION['user']='';
	}

	if ((isset($_POST['id'])) && ($_POST['id'] != '')){
		$id = $_POST['id'];
		try
		{	//Connection à la base de donnée avec l'utilisateur afmc
			$bdd = new PDO('mysql:host=localhost;dbname=AFMC;charset=utf8','afmc','marine&coralie');
			
		}
		catch (Exception $e)
		{
	        	die('Erreur : ' . $e->getMessage());
		}
		//preparation de la requete sql
		$answer = $bdd->prepare('SELECT count(*),mdp,alias FROM User WHERE alias = ? OR email= ?');
		$answer->execute(array($id,$id));
		while ($data = $answer->fetch())
	   	{
	        	if($data['count(*)'] > 0 ){
	        		$mdp=$data['mdp'];
					if ((isset($_POST['mdp'])) && ($_POST['mdp'] == $mdp)){
						$_SESSION['user']=$data['alias'];
						$alias=$data['alias'];
						$date=date("Y-m-d H:i:s");
						$modification = $bdd->prepare('UPDATE User SET dateDerniereCo=? WHERE alias=?');
						$modification->execute(array($date,$alias));
						$modification->closeCursor();
						echo "<meta http-equiv=\"Refresh\" content=\"0;url=HomeUser.php\">";
					}
					else{$erreur= "Le mot de passe est incorrecte";}
				}
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
	<?php include("../Menu.php"); ?>

	<div id="conteneur">
		<!-- Contenu de la page -->
		<section>
			<div id="header_txt_box">
				<h2 class="titre">AFMC</h2>
				L'Analyse Facile de Marine et Coralie<br>
				<br>
			</div>
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
