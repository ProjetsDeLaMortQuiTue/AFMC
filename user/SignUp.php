<!DOCTYPE html>

<html lang="fr">
<!-- Récupére l'organisme depuis la variable de session -->
<?php
	$_SESSION['currentPage']="user";
	if ((isset($_SESSION['orga'])) && ($_SESSION['orga'] != '')){
		$orga=$_SESSION['orga'];
	}
	else{$orga='INCONNU';}
	if ((isset($_POST['id'])) && ($_SESSION['id'] != '')){
		$orga=$_SESSION['orga'];
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
		<form action='SignUp.php' method="post">
			<TABLE>
				<TR><TD>*Identifiant:</TD><TD><input type="text" name="id"><br></TD></TR>
				<TR><TD>*Mot de passe:</TD><TD><input type="password" name="mdp1"></TD></TR>
				<TR><TD>*Mot de passe:</TD><TD><input type="password" name="mdp2"></TD></TR>
				<TR><TD>*Email:</TD><TD><input type="text" name="email"><br></TD></TR>
				<TR><TD>Nom:</TD><TD><input type="text" name="nom"><br></TD></TR>
				<TR><TD>Prénom:</TD><TD><input type="text" name="prenom"><br></TD></TR>
				<TR><TD>Nom de Labo:</TD><TD><input type="text" name="nomLabo"><br></TD></TR>
			</TABLE>
			<input type="submit" value="Valider"><br>
			*obligatoire
		</form>
        </section>
	</div>
	
	<?php include("../Footer.php"); ?>
	
  </body>

</html>
