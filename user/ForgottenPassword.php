<!DOCTYPE html>
<!-- Page d'affichage du formulaire de mot de passe oublié -->

<html lang="fr">

<?php
	session_start();
	$_SESSION['currentPage']="user";
	//Définition des variables
	$TAILLE_CODE=20;
	$email='';
	$erreurEmail='';
	$erreurCode='';
	$code="sfer";
	//Récupère l'email
	if(isset($_POST['email']) && $_POST['email']!='' ){
		$email=$_POST['email'];
		//Connexion à la base de donnée
		include("../DatabaseConnection.php");
		//Vérifie que l'email existe dans la base de donnée
		$answer = $bdd->prepare('SELECT count(*),mdp,alias FROM User WHERE email= ?');
		$answer->execute(array($email));
		while ($data = $answer->fetch())
	   	{
	   		//Si l'email existe dans la base de donnée
	        if($data['count(*)'] > 0 ){
	        	//Génération d'un code aléatoirement
				$chaine = "abcdefghijklmnpqrstuvwxy013456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
				srand((double)microtime()*1000000);
				for($i=0; $i<$TAILLE_CODE; $i++) {
					$code.= $chaine[rand()%strlen($chaine)];
				}
				$_POST['vraicode']=$code;
	        	//Envoie d'un mail avec le code
				$expediteur = 'coralie.rohmer@hotmail.fr';
				$objet = 'Mot de passe oublié AFMC';
				$headers = 'Reply-To: '.$expediteur."\n";
				$headers .= 'From: "Nom_de_expediteur"<'.$expediteur.'>'."\n";
				$headers .= 'Delivered-to: '.$email."\n";    
				$message = 'Votre Code est $code';
				//Si l'email a bien été envoyé
				if (mail($email, $objet, $message, $headers))
				{
				     $erreurEmail='Le code vous a bien été envoyé '.$code;
				}
				//Sinon l'email n'a pas pu être envoyé
				else{
				    $erreurEmail="Le code n'a pas pu vous être envoyé ".$code;
				}
			}//Sinon l'email n'existe pas dans la base de donnée
			else{
				$erreurEmail="Aucun compte n'est associé à cette email<br>Veuillez vous <a href='SignUp.php'>inscrire.</a><br></TD></TR>";
			}
		}$answer->closeCursor();
	}
	if(isset($_POST['code']) && $_POST['code']==$_POST['vraicode'] ){
		$erreur="code valable";
	}else{$erreur="code nonvalable";}
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
		<TABLE>
		<TR><TD></TD><TD><?php echo $erreurEmail?></TD></TR>
		<form action='ForgottenPassword.php' method="post">
			<TR><TD>Email: </TD><TD><input type="text" name="email" value=<?php echo $email ?> ></TD></TR>
			<TR><TD></TD><TD><input type="submit" value="Vous envoyer un code par email"></TD></TR>
		</form>
		<TR><TD></TD><TD><?php echo $erreurCode?></TD></TR>
		<form action='ForgottenPassword.php' method="post">
			<TR><TD>Code reçu:</TD><TD> <input type="text" name="code"></TD></TR>
			<TR><TD></TD><TD><input type="submit" value="Soumettre"></TD></TR>
		</form>
	</TABLE>
        </section>
	</div>
	
	<?php include("../Footer.php"); ?>
	
  </body>

</html>
