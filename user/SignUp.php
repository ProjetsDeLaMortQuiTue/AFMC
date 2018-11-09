<!DOCTYPE html>

<html lang="fr">
<!-- Récupére l'organisme depuis la variable de session -->
<?php
	$erreur="";
	$id='exemple:prenom.nom';
	$email="exemple@truc.fr";
	$mdp1="";
	$mdp2="";
	$Monsieur="checked=\"checked\"";
	$Madame="";
	$Mademoiselle="";
	$nom="";
	$prenom="";
	$nomLabo="exemple:lri";
	session_start();
	$_SESSION['currentPage']="user";
	if (isset($_POST['id'])){
		try
		{	//Connection à la base de donnée avec l'utilisateur afmc
			$bdd = new PDO('mysql:host=localhost;dbname=AFMC;charset=utf8','afmc','marine&coralie');
			
		}
		catch (Exception $e)
		{
	        	die('Erreur : ' . $e->getMessage());
		}

		//Vérifie si l'identifiant n'existe pas déja
		if ($_POST['id'] != 'exemple:prenom.nom' && $_POST['id'] != ''){
			$id=$_POST['id'];
			$answerId = $bdd->prepare('SELECT count(*) FROM User WHERE alias = ?');
			$answerId->execute(array($id));
			while ($data = $answerId->fetch())
		   	{
		        	if($data['count(*)'] == 0 ){
					}
					else{$erreur="L'identifiant $id est déja utilisé<br>";}
			}
			$answerId->closeCursor();
		}else{$erreur.="L'identifiant est obligatoire<br>";}

		//Vérifie si le mot de passe est correcte
		if ((isset($_POST['mdp1'])) && ($_POST['mdp1'] != '') &&
			(isset($_POST['mdp2'])) && ($_POST['mdp2'] != '')){
			$mdp1=$_POST['mdp1'];
			$mdp2=$_POST['mdp2'];
			if ($mdp1 != $mdp2){$erreur.="Les mots de passes sont différents<br>";
				$mdp1="";
				$mdp2="";
			}
		}else{$erreur.="Le mot de passe est obligatoire<br>";}

		//Vérifie si l'email n'existe pas déja et est correcte
		if ((isset($_POST['email'])) && ($_POST['email'] != 'exemple@truc.fr') && ($_POST['email'] != '')){
			$email=$_POST['email'];
			$answerEmail = $bdd->prepare('SELECT count(*) FROM User WHERE email= ?');
			$answerEmail->execute(array($email));
			while ($data = $answerEmail->fetch())
		   	{
		        if($data['count(*)'] == 0 ){

				}else{$erreur.="L'email est déja utilisé pour un autre compte<br>";}
			}
			$answerEmail->closeCursor();
		}else{$erreur.="L'email est obligatoire<br>";}

		//Récupére la civilité et la conserver
		if ((isset($_POST['civilite'])) && ($_POST['civilite'] != '')){
			$civilite=$_POST['civilite'];
			if($civilite=='M.'){
					$Monsieur="checked=\"checked\"";
					$Madame="";
					$Mademoiselle="";
			}else if ($civilite=='Mlle'){
					$Monsieur="";
					$Madame="";
					$Mademoiselle="checked=\"checked\"";
			}else {
					$Monsieur="";
					$Madame="checked=\"checked\"";
					$Mademoiselle="";
			}
		}

		//Récupére le nom est le conserver
		if ((isset($_POST['nom'])) && ($_POST['nom'] != '')){
			$nom=$_POST['nom'];
		}
		//Récupére le prénom est le conserver
		if ((isset($_POST['prenom'])) && ($_POST['prenom'] != '')){
			$prenom=$_POST['prenom'];
		}
		//Récupére le nom du laboratoire est le conserver
		if ((isset($_POST['nomLabo'])) && ($_POST['nomLabo'] != '')){
			$nomLabo=$_POST['nomLabo'];
		}

		if($erreur==''){
			$ajoutUtilisateur = $bdd->prepare('INSERT INTO User (alias,mdp,email,civilite,nom,prenom,nomLabo,dateDeCreation,dateDerniereCo)VALUES (?,?,?,?,?,?,?,?,?);');
			$ajoutUtilisateur->execute(array($id,$mdp1,$email,$civilite,$nom,$prenom,$nomLabo,date("Y-m-d"),date("Y-m-d H:i:s")));
			$ajoutUtilisateur->closeCursor();
			$_SESSION['user']=$id;
			echo "<meta http-equiv=\"Refresh\" content=\"0;url=HomeUser.php\">";
			// $mail=mail( $email ,"Inscription au site AFMC" , string $message [, mixed $additional_headers [, string $additional_parameters ]] )
			// if ($mail){$erreur='Un mail vous a été envoyé'}
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
			<?php include("../Title.php"); ?>
		<h1>Formulaire d'inscription</h1><br>
		<?php echo $erreur; ?>
		<form action='SignUp.php' method="post">
			<TABLE>
				<TR><TD>*Identifiant:</TD><TD><input type="text" name="id" value=<?php echo $id ?>><br></TD></TR>
				<TR><TD>*Mot de passe:</TD><TD><input type="password" name="mdp1" value=<?php echo $mdp1 ?> ></TD></TR>
				<TR><TD>*Mot de passe:</TD><TD><input type="password" name="mdp2"value=<?php echo $mdp2 ?>></TD></TR>
				<TR><TD>*Email:</TD><TD><input type="text" name="email" value=<?php echo $email ?>><br></TD></TR>
				<TR><TD>Civilité :</TD><TD>
					<input type="radio" name="civilite" value="M." <?php echo $Monsieur ?> />M.
					<input type="radio" name="civilite" value="Mlle" <?php echo $Mademoiselle ?>/>Mlle
					<input type="radio" name="civilite" value="Mme" <?php echo $Madame ?>/>Mme
					<br></TD></TR>
				<TR><TD>Nom:</TD><TD><input type="text" name="nom" value=<?php echo $nom ?>><br></TD></TR>
				<TR><TD>Prénom:</TD><TD><input type="text" name="prenom" value=<?php echo $prenom ?>><br></TD></TR>
				<TR><TD>Nom de Labo:</TD><TD><input type="text" name="nomLabo" value=<?php echo $nomLabo ?>><br></TD></TR>
			</TABLE>
			<input type="image" src="../ok.png"><br>
			*obligatoire
		</form>
        </section>
	</div>
	
	<?php include("../Footer.php"); ?>
	
  </body>

</html>
