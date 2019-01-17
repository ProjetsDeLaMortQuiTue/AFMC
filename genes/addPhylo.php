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

	//Récupère le gène associé à cette nouvelle phylogénie
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
		if($_FILES["fichier_arbre"]["name"]!="" && $_FILES["fichier_ali"]["name"]!=""){
			//Crée les dossiers de téléchargement s'il n'existe pas
			if (!file_exists("Phylogenie")){mkdir("Phylogenie");}
			if (!file_exists("Phylogenie/".$gene)) {mkdir("Phylogenie/".$gene);}
			$target_dir = "Phylogenie/".$gene."/";

			//TELECHARGEMENT DE L'ARBRE
			$target_file = $target_dir . basename($_FILES["fichier_arbre"]["name"]);
			$uploadOk = 1;
			$FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			// Autoriser certains formats seulement
			//if($FileType != "txt" || $FileType != "tree") {
			//    $erreur.="Désolé,votre arbre n'est pas au bon format.<br>";
			//    $uploadOk = 0;
			//} 
		    // Vérifie la taille du fichier
			if ($_FILES["fichier_arbre"]["size"] > 500000) {
			    $erreur.="Désolé, le fichier de votre arbre est trop grand.<br>";
			    $uploadOk = 0;
			} 
		    // Vérifie qu'il n'y a pas d'erreur avant l'upload
		    if ($uploadOk == 0) {
		        $erreur.="Désolé, le fichier de votre arbre ne peut pas être télécharger.<br>";
		    // essayer de télécharger
		    } else {
		        if (move_uploaded_file($_FILES["fichier_arbre"]["tmp_name"], $target_file)) {
		            echo "Le fichier ". basename( $_FILES["fichier_arbre"]["name"]). " a bien été télécharger.";
		            $new_name_tree=$target_dir."Tree_".$gene."_".$idUser.".tree";
		            rename($target_file,$new_name_tree);
		        } else {
		            $erreur.="Désolé, il y'a eu une erreur durant le téléchargement, veuillez recommencer.<br>";
		            $uploadOk = 0;
		        }
		    }
		    //TELECHARGMENT DE L'ALIGNEMENT
		    if ($uploadOk != 0) {
		    	$target_file = $target_dir . basename($_FILES["fichier_ali"]["name"]);
				$FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
				// Autoriser certains formats seulement
				//if($FileType != "txt" || $FileType != "fasta") {
				//    $erreur.="Désolé,votre alignement n'est pas au bon format.<br>";
				//    $uploadOk = 0;
				//} 
			    // Vérifie la taille du fichier
				if ($_FILES["fichier_ali"]["size"] > 500000) {
				    $erreur.="Désolé, le fichier de votre alignement est trop grand.<br>";
				    $uploadOk = 0;
				} 
			    // Vérifie qu'il n'y a pas d'erreur avant l'upload
			    if ($uploadOk == 0) {
			        $erreur.="Désolé, le fichier de votre alignement ne peut pas être télécharger.<br>";
			    // essayer de télécharger
			    } else {
			        if (move_uploaded_file($_FILES["fichier_ali"]["tmp_name"], $target_file)) {
			            echo "Le fichier ". basename( $_FILES["fichier_ali"]["name"]). " a bien été télécharger.";
			            $new_name_ali=$target_dir."Ali_".$gene."_".$idUser.".fasta";
			            rename($target_file,$new_name_ali);
			        } else {
			            $erreur.="Désolé, il y'a eu une erreur durant le téléchargement, veuillez recommencer.<br>";
			            $uploadOk = 0;
			        }
			    }

		    }
		    // Si les fichiers ont était correctement téléchargé
		    if ($uploadOk != 0) {
		    	if($_POST["outil"]!=""){
					$insert = $bdd->prepare('INSERT INTO Phylogenie (idGene,idUser,nomFichierArbre,nomFichierAlignement,outil,annotation) VALUES (?,?,?,?,?,?)');
					$insert->execute(array($gene,$idUser,$new_name_tree,$new_name_ali,$_POST['outil'],$_POST['annotation']));
					echo "<meta http-equiv=\"Refresh\" content=\"0;url=GeneSheet.php?gene=".$gene." \">";
				}else{$erreur.="Le nom de l'outil utilisé est obligatoire<br>";}
			}
		}else{$erreur.="L'arbre et l'alignement sont obligatoire<br>";}
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
				$alreadyAddedPhylogeny= $bdd->prepare('SELECT count(*) FROM User u JOIN Phylogenie ph WHERE u.idUser=ph.idUser AND ph.idGene=? AND u.idUser=?');
				$alreadyAddedPhylogeny->execute(array($gene,$idUser));
				while ($data = $alreadyAddedPhylogeny->fetch())
	    		{
	    			if ($data['count(*)'] == 0){
						echo "<h1>Ajout d'une phylogénie pour le gène ".$gene."</h1>";
				    	echo '<TABLE><red>'.$erreur."</red>";
				    	//AJOUT DU FICHIER
				    	echo '<form action="addPhylo.php?gene='.$gene.'" method="post" enctype="multipart/form-data">';
				    	echo '<TR><TD>*Arbre(format Newick):</TD><TD><input type="file" name="fichier_arbre" id="fichier_arbre"></TD><TD></TD></TR>
				    	<TR><TD>*Alignement (format fasta):</TD><TD><input type="file" name="fichier_ali" id="fichier_ali"></TD><TD></TD></TR>
				    	<TR><TD>*Outil:</TD><TD><input type="text" name="outil"></TD></TR>
				    	<TR><TD>Annotation:</TD><TD><input type="text" name="annotation"></TD></TR>
						<TR><TD></TD><TD><input type="submit" value="Ajouter une phylogénie" name="submit"></TD></TR></TABLE><br>
						*Champ obligatoire';
						echo"<br>Nous vous conseillons le site <a href=http://www.phylogeny.fr>phylogeny.fr</a> pour effectuer votre phylogenie";
					}
					else{echo "Vous ne pouvez ajouter qu'une seule phylogénie par gène.";}
				}

			}else{
				echo "Pour ajouter une phylogénie vous devez être connecté.<br>";
				echo "Cliqué <a href='../user/LogIn.php'>ici</a> pour vous connecter ou <a href='../user/SignUp.php'>ici</a> pour vous crée un compte";
			}
		?>
      	</section>
	</div>
	
	<?php include("../Footer.php"); ?>
	
  </body>

</html>
