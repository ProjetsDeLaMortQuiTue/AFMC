<!DOCTYPE html>
<!-- Page d'affichage des protéines pour l'espèce donnée -->

<html lang="fr">
<?php
	session_start();
	$_SESSION['currentPage']="genes";
?>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../AFMC.css"> 
	<title>AFMC</title>
</head>

<?php

	//Récupère le gène associé à ce nouvelle identifiant
	if ((isset($_GET['gene'])) && ($_GET['gene'] != '')){
	$gene = $_GET['gene'];
	}
	else{$gene='INCONNU';}
	
	//Récupére l'id de l'utilisateur connecté
	if ((isset($_SESSION['user'])) && ($_SESSION['user'] != '')){
		include("../DatabaseConnection.php");
		$answer=$bdd->prepare('SELECT idUser FROM User where alias=?');
		$answer->execute(array($_SESSION['user']));
		while ($data = $answer->fetch()){$idUser=$data['idUser'];}
	}

	// Si le formulaire a déja été remplis
	$erreur='';
	if(isset($_POST["submit"])) {
		if($_POST["codeGene"]!="" && $_POST["organisme"]!=""){
				$insert = $bdd->prepare('INSERT INTO KEGG (idGene,idUser,codeGene,organisme) VALUES (?,?,?,?)');
				$insert->execute(array($gene,$idUser,$_POST["codeGene"],$_POST["organisme"]));
				echo "<meta http-equiv=\"Refresh\" content=\"0;url=GeneSheet.php?gene=".$gene." \">";
		}else{$erreur.="L'identifiant du gène et celui de l'organisme sont obligatoire<br>";}
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
				$alreadyAddedKEGG= $bdd->prepare('SELECT count(*) FROM User u JOIN KEGG k WHERE u.idUser=k.idUser AND k.idGene=? AND u.idUser=?');
				$alreadyAddedKEGG->execute(array($gene,$idUser));
				while ($data = $alreadyAddedKEGG->fetch())
	    		{
	    			if ($data['count(*)'] == 0){
						echo "<h1>Ajout d'un identifiant KEGG pour le gène ".$gene."</h1>";
				    	echo '<TABLE><red>'.$erreur."</red>";
				    	echo '<form action="addKEGG.php?gene='.$gene.'" method="post" enctype="multipart/form-data">';
				    	echo '<TR><TD>*ID gènes:</TD><TD><input type="text" name="codeGene"></TD></TR>
				    	<TR><TD>*ID organisme (3 lettre):</TD><TD><input type="text" name="organisme"></TD></TR>
						<TR><TD></TD><TD><input type="submit" value="Ajouter l\'identifiant" name="submit"></TD></TR></TABLE><br>
						*Champ obligatoire';
					}
					else{echo "Vous ne pouvez ajouter qu'un seul identifiant KEGG par gène.";}
				}

			}else{
				echo "Pour ajouter un identifiant KEGG vous devez être connecté.<br>";
				echo "Cliqué <a href='../user/LogIn.php'>ici</a> pour vous connecter ou <a href='../user/SignUp.php'>ici</a> pour vous crée un compte";
			}
		?>
      	</section>
	</div>
	
	<?php include("../Footer.php"); ?>
	
  </body>

</html>
