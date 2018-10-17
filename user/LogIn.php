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
						echo "<meta http-equiv=\"Refresh\" content=\"0;url=HomeUser.php\">";
					}
					else{$erreur= "Le mot de passe est incorrecte";}
				}
				else{$erreur="L'identifiant est incorrecte";}
		}
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
		<form action='LogIn.php' method="post">
			Identifiant: <input type="text" name="id"><br>
			Mot de passe: <input type="password" name="mdp"><br>
		<input type="submit" value="Se connecter">
		</form>
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
