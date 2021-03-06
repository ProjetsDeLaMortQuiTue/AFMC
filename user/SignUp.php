<!DOCTYPE html>
<!-- Page d'affichage du formulaire d'inscription pour l'utilisateur -->

<html lang="fr">
<?php
	//Création des variables
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
		
		//Connexion à la base de donnée
		include("../DatabaseConnection.php");

		//Vérifie si l'identifiant n'existe pas déjà
		if ($_POST['id'] != 'exemple:prenom.nom' && $_POST['id'] != ''){
			$id=$_POST['id'];
			$answerId = $bdd->prepare('SELECT count(*) FROM User WHERE alias = ?');
			$answerId->execute(array($id));
			while ($data = $answerId->fetch())
		   	{
		        	if($data['count(*)'] != 0 ){
						$erreur="L'identifiant $id est déjà utilisé<br>";
					}
			}
			$answerId->closeCursor();
		}else{$erreur="L'identifiant est obligatoire<br>";}

		//Vérifie si le mot de passe est correcte
		if ((isset($_POST['mdp1'])) && ($_POST['mdp1'] != '') &&
			(isset($_POST['mdp2'])) && ($_POST['mdp2'] != '')){
			$mdp1=$_POST['mdp1'];
			$mdp2=$_POST['mdp2'];
			if ($mdp1 != $mdp2){
				$erreur.="Les mots de passe sont différents<br>";
				$mdp1="";
				$mdp2="";
			}
		}else{$erreur.="Le mot de passe est obligatoire<br>";}

		//Vérifie si l'email n'existe pas déja et est correcte
		if ((isset($_POST['email'])) && ($_POST['email'] != 'exemple@truc.fr') && ($_POST['email'] != '')){
			$email=$_POST['email'];
			//Si l'email est correcte
			if (preg_match("/^.+@[a-z]+\.[a-z]+$/", $email)){
				//Vérifie que l'email n'existe pas déja
				$answerEmail = $bdd->prepare('SELECT count(*) FROM User WHERE email= ?');
				$answerEmail->execute(array($email));
				while ($data = $answerEmail->fetch())
			   	{
			        if($data['count(*)'] != 0 ){
						$erreur.="L'email est déja utilisé pour un autre compte<br>";
					}
				}
				$answerEmail->closeCursor();
			}else{$erreur.="L'email n'est pas correcte<br>";}
		}else{$erreur.="L'email est obligatoire<br>";}

		//Récupère la civilité
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

		//Récupère le nom
		if ((isset($_POST['nom'])) && ($_POST['nom'] != '')){
			$nom=$_POST['nom'];
		}
		//Récupère le prénom
		if ((isset($_POST['prenom'])) && ($_POST['prenom'] != '')){
			$prenom=$_POST['prenom'];
		}
		//Récupère le nom du laboratoire
		if ((isset($_POST['nomLabo'])) && ($_POST['nomLabo'] != '')){
			$nomLabo=$_POST['nomLabo'];
		}

		//S'il n'y a pas d'erreur, la bdd est mise à jour avec le nouvel utilisateur
		if($erreur==''){
			if($nomLabo='exemple:lri'){$nomLabo='';}
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
	<?php include("../Title2.php"); ?>
	<?php include("../Menu.php"); ?>

	<div id="conteneur">
		<!-- Contenu de la page -->
		<section>
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
