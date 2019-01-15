<!DOCTYPE html>
<!-- Page d'affichage du formulaire de mot de passe oublié -->

<html lang="fr">

<?php
	session_start();
	$_SESSION['currentPage']="user";

	//Fonction qui génére un code aléatoirement
	function codeAleatoire()
	{
		$TAILLE_CODE=20;
		$code="";
		$caractere = "abcdefghijklmnpqrstuvwxy013456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		srand((double)microtime()*1000000);
		for($i=0; $i<$TAILLE_CODE; $i++) {
			$code.= $caractere[rand()%strlen($caractere)];
		}
	    return $code;
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
		<?php 
			//Si une adresse email a été transféré sur cette page
			if(isset($_POST['email']) && $_POST['email']!='' ){
				$erreurEmail='';
				$erreurCode='';
				$email=$_POST['email'];

				//Connexion à la base de donnée
				include("../DatabaseConnection.php");

				//Vérifie que l'email existe dans la base de donnée
				$answer = $bdd->prepare('SELECT count(*),alias FROM User WHERE email= ?');
				$answer->execute(array($email));

				while ($data = $answer->fetch())
			   	{
			   		//Si l'email existe dans la base de donnée
			        if($data['count(*)'] > 0 ){
			        	$code=codeAleatoire();
			        	//Envoie d'un mail avec le code
						$expediteur = 'coralie.rohmer@hotmail.fr';
						$objet = 'Mot de passe oublié AFMC';
						$headers = 'From: "AFMC" <'.$expediteur.'>'."\n";
						$headers .= 'Reply-To: '.$expediteur."\n";
						$headers .= 'Delivered-to: '.$email."\n";    
						$message = 'Votre Code est '.$code;
						//Si l'email a bien été envoyé, affiche le formulaire pour entrer le code
						if (mail($email, $objet, $message, $headers))
						{
							//echo $email."<br>".$objet."<br>".$message."<br>".$headers."<br>";
							echo "<br>".$code."<br>";
						    //Formulaire pour rentrer le code
							echo 'Un code vous a été envoyé par mail.<br><br>Veuillez entrez le code reçut:';
							echo '<TABLE><form action="ForgottenPassword.php" method="post">';
							echo '<TR><TD>Code: </TD><TD><input type="text" name="codeUser"></TD>';
							echo '<input type="hidden" name="alias" value='.$data['alias'].'>';
							echo '<input type="hidden" name="code" value='.$code.'>';
							echo '<TD><input type="submit" value="Soumettre"></TD></TR>';
							echo '</form></TABLE>';
						}
						//Si l'email n'a pas pu être envoyé
						else{
						    echo "Nous n'avons pas pu vous envoyer un mail.<br>";
						    echo "<br>Cela est dû à un problème de serveurs<br>";
						    echo "Vous pouvez <a href='ForgottenPassword.php'>réessayer</a> ou <a href='../Contact.php'>nous contacter</a>.<br></TD></TR> ";
						}
					}//Sinon l'email n'existe pas dans la base de donnée
					else{
						echo "Aucun compte n'est associé à cette email<br>Veuillez vous <a href='SignUp.php'>inscrire</a>.<br></TD></TR>";
					}
				}$answer->closeCursor();

			//Si c'est le code qui a été transféré
			}else{if(isset($_POST['codeUser']) && $_POST['codeUser']!='' ){
					if ($_POST['codeUser']==$_POST['code']){
						echo "Le code est correcte.<br>Veuillez entrez un nouveau mdp:";
						echo '<form action="ForgottenPassword.php" method="post"><TABLE><TR><TD>Nouveau mot de passe:</TD><TD><input type="password" name="newmdp1" value=""></TD></TR>';
						echo '<TR><TD>Nouveau mot de passe:</TD><TD><input type="password" name="newmdp2"></TD></TR>';
						echo '<input type="hidden" name="alias" value='.$_POST['alias'].'>';
						echo '</TABLE><input type="image" src="../ok.png"><br>';
					}else{
					echo "Le code est incorrecte. <br> Cliqué <a href='ForgottenPassword.php'>ici</a> pour être redirigé pour renvoyer un nouveau code";}

			//Si c'est le nouveau mot de passe qui a été transféré
			}else{if(isset($_POST['newmdp1']) && $_POST['newmdp1']!='' ){
				if ($_POST['newmdp1']==$_POST['newmdp2']){
					//Connexion à la base de donnée
					include("../DatabaseConnection.php");
					$answer = $bdd->prepare('UPDATE User SET mdp=? WHERE alias=?');
					$answer->execute(array($_POST['newmdp1'],$_POST['alias']));
					$_SESSION['user']=$_POST['alias'];
					echo "Le mot de passe a été changé avec succès.<br>Cliqué <a href='HomeUser.php'>ici</a> pour être redirigé vers la page utilisateur.";
				}else{echo "Les deux mots de passes ne sont pas identiques.<br>Veuillez recommancé en cliquant <a href='ForgottenPassword.php'>ici</a>.";
				}

			//Si rien n'a été transféré sur la page
			}else{ 
				//Formulaire pour rentrer l'email
					mail('bibsbde@gmail.com','test','test');
					echo '<TABLE><form action="ForgottenPassword.php" method="post">';
					echo '<TR><TD>Email: </TD><TD><input type="text" name="email"></TD></TR>';
					echo '<TR><TD></TD><TD><input type="submit" value="Vous envoyer un code par email"></TD></TR>';
					echo '</form></TABLE>';	
				}
			}
			}
			?>
		</TABLE>
        </section>
	</div>
	
	<?php include("../Footer.php"); ?>
</body>

</html>
