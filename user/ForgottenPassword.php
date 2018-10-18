<!DOCTYPE html>

<html lang="fr">
<!-- Récupére l'organisme depuis la variable de session -->
<?php
	session_start();
	$email='';
	$erreurEmail='';
	$erreurCode='';
	$code="sfer";
	if(isset($_POST['email']) && $_POST['email']!='' ){
		$email=$_POST['email'];
		try
		{	//Connection à la base de donnée avec l'utilisateur afmc
			$bdd = new PDO('mysql:host=localhost;dbname=AFMC;charset=utf8','afmc','marine&coralie');
			
		}
		catch (Exception $e)
		{
	        	die('Erreur : ' . $e->getMessage());
		}
		$answer = $bdd->prepare('SELECT count(*),mdp,alias FROM User WHERE email= ?');
		$answer->execute(array($email));
		while ($data = $answer->fetch())
	   	{
	        	if($data['count(*)'] > 0 ){
	        				$answer->closeCursor();
				$destinataire = $email;
				$expediteur = 'coralie.rohmer@hotmail.fr';
				$objet = 'Mot de passe oublié AFMC'; // Objet du message
				$headers = 'Reply-To: '.$expediteur."\n"; // Mail de reponse
				$headers .= 'From: "Nom_de_expediteur"<'.$expediteur.'>'."\n"; // Expediteur
				$headers .= 'Delivered-to: '.$destinataire."\n"; // Destinataire      
				$message = 'Votre Code est $code';
				if (mail($destinataire, $objet, $message, $headers))
				{
				     $erreurEmail='Votre message a bien été envoyé ';
				}
				else // Non envoyé
				{
				    $erreurEmail="Votre message n'a pas pu être envoyé".error_get_last()['message'];
				}
			}else{$erreurEmail="Aucun compte n'est associé à cette email<br>Veuillez vous <a href='SignUp.php'>inscrire.</a><br></TD></TR>";}
		}
	}
	if(isset($_POST['code']) && $_POST['code']==$code ){
		echo "code valable";
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