<!DOCTYPE html>
<!-- Page d'affichage des protéines pour l'espèce donnée -->

<html lang="fr">
<?php
	session_start();
	$_SESSION['currentPage']="proteines";
?>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../AFMC.css"> 
	<title>AFMC</title>
  </head>

<html lang="fr">
<?php

	//Récupère la proteine associé à cette nouvelle structure
	if ((isset($_GET['prot'])) && ($_GET['prot'] != '')){
	$prot = $_GET['prot'];
	}
	else{$prot='INCONNU';}
	
	//Récupére l'id de l'utilisateur connecté
	include("../DatabaseConnection.php");
	$answer=$bdd->prepare('SELECT idUser FROM User where alias=?');
	$answer->execute(array($_SESSION['user']));
	while ($data = $answer->fetch()){$idUser=$data['idUser'];}

	// Si le formulaire a déja été remplis
	$erreur='';
	if(isset($_POST["submit"])) {
		if($_POST["codeUniProt"]!=""){
				$insert = $bdd->prepare('INSERT INTO UniProt (idProt,idUser,codeUniProt) VALUES (?,?,?)');
				$insert->execute(array($prot,$idUser,$_POST["codeUniProt"]));
				echo "<meta http-equiv=\"Refresh\" content=\"0;url=ProtSheet.php?prot=".$prot." \">";
		}else{$erreur.="L'identifiant Uniprot est obligatoire<br>";}
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
			if ((isset($_SESSION['user'])) && ($_SESSION['user'] != '')){
				//Connexion à la base de donnée
				include("../DatabaseConnection.php");
				//Vérifie que l'utilisateur n'a pas déja entré une phylogénie pour ce gène
				$alreadyAddedUniProt= $bdd->prepare('SELECT count(*) FROM User u JOIN UniProt un WHERE u.idUser=un.idUser AND un.idProt=? AND u.idUser=?');
				$alreadyAddedUniProt->execute(array($prot,$idUser));
				while ($data = $alreadyAddedUniProt->fetch())
	    		{
	    			if ($data['count(*)'] == 0){
						echo "<h1>Ajout d'un identifiant UniProt pour la proteine ".$prot."</h1>";
				    	echo '<TABLE><red>'.$erreur."</red>";
				    	echo '<form action="addUniProt.php?prot='.$prot.'" method="post" enctype="multipart/form-data">';
				    	echo '<TR><TD>*ID UniProt:</TD><TD><input type="text" name="codeUniProt"></TD></TR>
						<TR><TD></TD><TD><input type="submit" value="Ajouter l\'identifiant" name="submit"></TD></TR></TABLE><br>
						*Champ obligatoire';
					}
					else{echo "Vous ne pouvez ajouter qu'un seul identifiant Uniprot par gène.";}
				}

			}else{
				echo "Pour ajouter un identifiant UniProt vous devez être connecté.<br>";
				echo "Cliqué <a href='../user/LogIn.php'>ici</a> pour vous connecter ou <a href='../user/SignUp.php'>ici</a> pour vous crée un compte";
			}
		?>
      	</section>
	</div>
	
	<?php include("../Footer.php"); ?>
	
  </body>

</html>
