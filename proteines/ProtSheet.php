<!DOCTYPE html>
<!-- Page d'affichage des informations pour une protéine donnée -->

<html lang="fr">
<?php
	session_start();
	$_SESSION['currentPage']="proteines";
	
	//Récupère la protéine à afficher
	if ((isset($_GET['prot'])) && ($_GET['prot'] != '')){
	$prot = $_GET['prot'];
	}
	else{$prot='INCONNU';}
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

			//Connexion à la base de donnée
			include("../DatabaseConnection.php");

			//Préparation de la requête sql pour récupérer les informations de la protéine
			$answer = $bdd->prepare('SELECT idProt,nomProt,tailleProt,seqProt,idGene FROM Proteine WHERE idProt = ?');
			//Exécution de la requête avec la protéine en argument
			$answer->execute(array($prot));

			//Préparation de la requête sql pour récupérer les structures associé à cette proteines 
			$answerStruc= $bdd->prepare('SELECT u.idUser,alias,nomFichier,annotation FROM Structure s JOIN User u WHERE idProt = ? AND s.idUser=u.idUser;');
			$answerStruc->execute(array($prot));

			//Préparation de la requête sql pour récupérer les id UniProt associé à cette proteines 
			$answerUniProt= $bdd->prepare('SELECT u.idUser,alias,codeUniProt FROM UniProt un JOIN User u WHERE idProt = ? AND un.idUser=u.idUser;');
			$answerUniProt->execute(array($prot));

			//Récupére l'identifiant de l'utilisateur
			$idUser='';
			if ((isset($_SESSION['user'])) && ($_SESSION['user'] != '')){
				$answerUser = $bdd->prepare('SELECT idUser FROM User WHERE alias = ?');
				$answerUser->execute(array($_SESSION['user']));
				while ($data = $answerUser->fetch()){$idUser=$data['idUser'];}
			}

			echo "<h1>Données présentes pour la protéine ".$prot."</h1>";
		    echo"<TABLE>";

	        //Affiche les résultats de la requête dans un tableau
	        while ($data = $answer->fetch())
	        {
	            echo '<TR><TD>'.'Identifiant de la protéine: '.'</TD><TD>'.$data['idProt'].'</TD></TR>'.
	            '<TR><TD>'.'Nom:  '.'</TD><TD>'.$data['nomProt'].'</TD></TR>'.
	            '<TR><TD>'.'Taille: '.'</TD><TD>'.$data['tailleProt'].'</TD></TR>'.
	            '<TR><TD>'.'Séquence: '.'</TD><TD><TEXTAREA rows=6 cols=60 readonly="readonly">'.$data['seqProt'].'</TEXTAREA></TD></TR>'.
	            '<TR><TD>'.'Gène associé: '.'</TS><TD><a href=../genes/GeneSheet.php?gene='.$data['idGene'].' class=\"nav\">'.$data['idGene'].'</a><br></TD></TR>';
	        }
			$answer->closeCursor();
		?>
			    </TABLE>
	    <?php 
	    	//Affiche le lien vers le transcript correspondant
			echo '<a href=TransSheet.php?trans='.$prot.' class=\"nav\">Voir le transcript'.'</a>';
		?>
			<h1>Données ajoutées par les utilisateurs sur la protéine</h1>
		<?php
			echo 'Structure(s) possible(s) pour cette protéine:<BR>';
			//Affiche les phylogenies du le gène
			$compteurStruc=0;
	        while ($data = $answerStruc->fetch())
	        {
	        	$compteurStruc++;
	        	if ($compteurStruc == '1'){
					echo "<TABLE BORDER = \"1\" cellspacing=\"0\"><TR><TD align=center bgcolor=\"#F6A33D\">Fichiers Structure</TD><TD align=center bgcolor=\"#F6A33D\">Alignements</TD></TD><TD align=center bgcolor=\"#F6A33D\">Ajoutés par</TD><TD align=center bgcolor=\"#F6A33D\"></TD></TR>";
				}
				
				if ($idUser != '' && $idUser == $data['idUser']){
					$proprietaire='Vous-même';
					$modif_ou_contact='Modifier? (à venir)</bleu>';
				}
				else{
					$proprietaire=$data['alias'];
					$modif_ou_contact= "<a href=../user/UserSheet.php?id=".$data['idUser'].'>Contacter</a></bleu>';
				}
				
				echo "<TR><TD align=center><a href=".$data['nomFichier']."download>Télécharger</a></TD>
						<TD>".$data['annotation']."</TD>
						<TD align=center>".$proprietaire."</TD>
						<TD align=center>".$modif_ou_contact."</TD></TR>";
	        }
	        echo "</TABLE>";
	        $answerStruc->closeCursor();
	        if ($compteurStruc==0){echo "Aucune structure n'est disponible pour cette protéine";}
			
		?>
		<form action=addStructure.php method="GET">
			<input type="hidden" name="prot" value=<?php echo $prot ?>>
			<input type="submit" value="Ajouter une structure">
		</form>
		<br>
		<?php
			echo 'Identifiant(s) Uniprot possible(s) pour cette protéine:<BR>';
			//Affiche les phylogenies du le gène
			$compteurUniProt=0;
	        while ($data = $answerUniProt->fetch())
	        {
	        	$compteurUniProt++;
	        	if ($compteurUniProt == '1'){
					echo "<TABLE BORDER = \"1\" cellspacing=\"0\"><TR><TD align=center bgcolor=\"#40919B\">Identifiants Uniprot</TD><TD align=center bgcolor=\"#40919B\">Liens</TD><TD align=center bgcolor=\"#40919B\">Ajouté par</TD><TD align=center bgcolor=\"#40919B\"></TD></TR>";
				}
	        	if ($idUser != '' && $idUser == $data['idUser']){
					$proprietaire='Vous-même';
					$modif_ou_contact='Modifier? (à venir)</bleu>';
				}
				else{
					$proprietaire=$data['alias'];
					$modif_ou_contact= " <a href=../user/UserSheet.php?id=".$data['idUser'].'>Contacter</a></bleu>';
				}
				
				echo "<TR><TD align=center>".$data['codeUniProt']."</TD>
							<TD align=center><a href=https://www.uniprot.org/uniprot/".$data['codeUniProt'].">UniProt</a></TD>
							<TD align=center>".$proprietaire."</TD>
							<TD align=center>".$modif_ou_contact."</TD></TR>";
	        }
	        echo "</TABLE>";
	        $answerUniProt->closeCursor();
	        if ($compteurUniProt==0){echo "Aucun identifant UniProt n'est disponible pour cette protéine";}
			
		?>
		<form action=addUniProt.php method="GET">
			<input type="hidden" name="prot" value=<?php echo $prot ?>>
			<input type="submit" value="Ajouter un identifiant UniProt">
		</form>
        </section>
	</div>
	<?php include("../Footer.php"); ?>
	
  </body>

</html>
