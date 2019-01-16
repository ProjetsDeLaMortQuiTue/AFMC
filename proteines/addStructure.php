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
		if($_FILES["fichier_struc"]["name"]!=""){
			//Crée les dossiers de téléchargement s'il n'existe pas
			if (!file_exists("Structure")){mkdir("Structure");}
			if (!file_exists("Structure/".$prot)) {mkdir("Structure/".$prot);}
			$target_dir = "Structure/".$prot."/";

			//TELECHARGEMENT DE LA STRUCTURE
			$target_file = $target_dir . basename($_FILES["fichier_struc"]["name"]);
			$uploadOk = 1;
			$FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			// Autoriser certains formats seulement
			//if($FileType != "txt" || $FileType != "pdb") {
			//    $erreur.="Désolé,votre structure n'est pas au bon format.<br>";
			//    $uploadOk = 0;
			//} 
		    // Vérifie la taille du fichier
			if ($_FILES["fichier_struc"]["size"] > 500000) {
			    $erreur.="Désolé, le fichier de votre structure est trop grand.<br>";
			    $uploadOk = 0;
			} 
		    // Vérifie qu'il n'y a pas d'erreur avant l'upload
		    if ($uploadOk == 0) {
		        $erreur.="Désolé, le fichier de votre structure ne peut pas être télécharger.<br>";
		    // essayer de télécharger
		    } else {
		        if (move_uploaded_file($_FILES["fichier_struc"]["tmp_name"], $target_file)) {
		            echo "Le fichier ". basename( $_FILES["fichier_struc"]["name"]). " a bien été télécharger.";
		            $new_name_struc=$target_dir."Struc_".$prot."_".$idUser.".pdb";
		            rename($target_file,$new_name_struc);
		        } else {
		            $erreur.="Désolé, il y'a eu une erreur durant le téléchargement, veuillez recommencer.<br>";
		            $uploadOk = 0;
		        }
		    }

		    // Si le fichier a était correctement téléchargé
		    if ($uploadOk != 0) {
				$insert = $bdd->prepare('INSERT INTO Structure (idProt,idUser,nomFichier,annotation) VALUES (?,?,?,?)');
				$insert->execute(array($prot,$idUser,$new_name_struc,$_POST['annotation']));
				echo "<meta http-equiv=\"Refresh\" content=\"0;url=ProtSheet.php?prot=".$prot." \">";
			}
		}else{$erreur.="La structure est obligatoire<br>";}
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
				//Vérifie que l'utilisateur n'a pas déja entré une structure pour cette proteine
				$alreadyAddedStruc= $bdd->prepare('SELECT count(*) FROM User u JOIN Structure s WHERE u.idUser=s.idUser AND s.idProt=? AND u.idUser=?');
				$alreadyAddedStruc->execute(array($prot,$idUser));
				while ($data = $alreadyAddedStruc->fetch())
	    		{
	    			if ($data['count(*)'] == 0){
						echo "<h1>Ajout d'une structure pour la proteine ".$prot."</h1>";
				    	echo '<TABLE><red>'.$erreur."</red>";
				    	//AJOUT DU FICHIER
				    	echo '<form action="addStructure.php?prot='.$prot.'" method="post" enctype="multipart/form-data">';
				    	echo '<TR><TD>*Fichier Structure (format PDB):</TD><TD><input type="file" name="fichier_struc" id="fichier_struc"></TD><TD></TD></TR>
				    	<TR><TD>Annotation:</TD><TD><input type="text" name="annotation"></TD></TR>
						<TR><TD></TD><TD><input type="submit" value="Ajouter une structure" name="submit"></TD></TR></TABLE><br>
						*Champ obligatoire';
					}
					else{echo "Vous ne pouvez ajouter qu'une seule structure par proteine.";}
				}

			}else{
				echo "Pour ajouter une structure, vous devez être connecté.<br>";
				echo "Cliqué <a href='../user/LogIn.php'>ici</a> pour vous connecter ou <a href='../user/SignUp.php'>ici</a> pour vous crée un compte";
			}
		?>
      	</section>
	</div>
	
	<?php include("../Footer.php"); ?>
	
  </body>

</html>
