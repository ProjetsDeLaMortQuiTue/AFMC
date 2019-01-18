<!DOCTYPE html>
<!-- Page d'affichage des informations de l'utilisateur -->

<html lang="fr">
<!-- Récupère l'utilisateur depuis la variable de session -->
<?php
	session_start();
	$_SESSION['currentPage']="user";
	if ((isset($_SESSION['user'])) && ($_SESSION['user'] != '')){
	$user=$_SESSION['user'];
	}
	//Connexion à la base de donnée
	include("../DatabaseConnection.php");
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
		<form action="LogIn.php" method="post">
			<input type="submit" value="Se déconnecter">
		</form>
		<?php
			
			//Préparation de la requête sql pour récupérer toutes les informations de l'utilisateur
			$answer = $bdd->prepare('SELECT idUser,alias,email,nom,prenom,nomLabo,dateDeCreation,dateDerniereCo FROM User WHERE alias = ?');
			
			//Exécute la requête avec la variable passée en argument (la variable remplace "?")
			$answer->execute(array($user));
			
			//Affiche les résultats de la requête dans un tableau
			echo "<h1>Informations de l'utilisateur:</h1>";
			echo "<TABLE>";
			while ($data = $answer->fetch())
			{
	            echo '<TR><TD>'.'Identifiant: '.'</TD><TD>'.$data['alias'].'</TD></TR>'.'<TR><TD>'.'Email:  '.'</TD><TD>'.$data['email'].'</TD></TR>'.
	            '<TR><TD>'.'Nom: '.'</TD><TD>'.$data['nom'].'</TD></TR>'.
	            '<TR><TD>'.'Prenom: '.'</TD><TD>'.$data['prenom'].'</TD></TR>'.
	            '<TR><TD>'.'Laboratoire: '.'</TD><TD>'.$data['nomLabo'].'</TD></TR>'.
	            '<TR><TD>'.'Date de creation: '.'</TD><TD>'.$data['dateDeCreation'].'</TD></TR>'.
	            '<TR><TD>'.'Date de dernière connexion: '.'</TD><TD>'.$data['dateDerniereCo'].'</TD></TR>';
	            $idUser=$data['idUser'];
			}
			$answer->closeCursor();
			echo "</TABLE>";
			
			
			echo '<h1>Phylogénie(s) publiée(s):</h1>';
			//Si l'utilisateur supprime une phylogénie
			if (isset($_POST['phylo'])){
				$gene=$_POST['gene'];
				echo "<red>Suppression de votre phylogénie pour le gène:".$gene."</red><br>";
				$suppressionPhylo = $bdd->prepare('DELETE FROM Phylogenie WHERE idUser=? AND idGene=?;');
				$suppressionPhylo->execute(array($idUser,$gene));
				//Supprime les fichiers associés;
				unlink('../genes/Phylogenie/'.$gene.'/Ali_'.$gene.'_'.$idUser.'.fasta');
				unlink('../genes/Phylogenie/'.$gene.'/Tree_'.$gene.'_'.$idUser.'.tree');
			}
			//Préparation de la requête sql pour récupérer les phyolgenies publiés par l'utilisateur
			$answerPhylo = $bdd->prepare('SELECT idGene,nomFichierArbre,nomFichierAlignement,outil,annotation FROM Phylogenie ph JOIN User u WHERE ph.idUser=u.idUser AND u.alias=?');
			$answerPhylo->execute(array($user));
			$compteurPhylo=0;
	        while ($data = $answerPhylo->fetch())
	        {
	        	$compteurPhylo++;
	        	echo '<form action="HomeUser.php" method="post">';
				echo '<input type="hidden" name="gene" value='.$data['idGene'].">";
	        	if ($compteurPhylo == '1'){
					echo "<TABLE BORDER = \"1\" style=\"text-align:center\" cellspacing=\"0\"><TR><TD bgcolor=\"#F6A33D\">Gènes</TD><TD bgcolor=\"#F6A33D\">Arbres</TD><TD bgcolor=\"#F6A33D\">Alignements</TD><TD bgcolor=\"#F6A33D\">Outils</TD><TD bgcolor=\"#F6A33D\">Annotations</TD><TD bgcolor=\"#F6A33D\"></TD></TR>";
				}
				echo "<TR><TD><a href=../genes/GeneSheet.php?gene=".$data['idGene'].">".$data['idGene']."</a></TD>
						<TD><a href=../genes/".$data['nomFichierArbre']." download>Télécharger</a></TD>
						<TD><a href=../genes/".$data['nomFichierAlignement']." download>Télécharger</a></TD>
						<TD>".$data['outil']."</TD>
						<TD>".$data['annotation']."</TD>
						<TD>".'<input type="submit" name="phylo" value="Supprimer"></form>'."</TD></TR>";
	        }
	        echo "</TABLE>";
	        $answerPhylo->closeCursor();
	        if ($compteurPhylo==0){echo "Vous n'avez publié aucune phylogénie";}
	        
	        
	        echo '<h1>Identifiants(s) KEGG publié(s):</h1>';
   			//Si l'utilisateur supprime un identifiant KEGG
			if (isset($_POST['kegg'])){
				$gene=$_POST['gene'];
				echo "<red>Suppression de l'identifant KEGG pour le gène:".$gene."</red><br>";
				$suppressionKEGG = $bdd->prepare('DELETE FROM KEGG WHERE idUser=? AND idGene=?;');
				$suppressionKEGG->execute(array($idUser,$gene));
			}
			//Préparation de la requête sql pour récupérer les identifiant KEGG publié par l'utilisateur
			$answerKEGG = $bdd->prepare('SELECT u.idUser,idGene,codeGene,organisme FROM KEGG k JOIN User u WHERE u.alias = ? AND k.idUser=u.idUser;');
			$answerKEGG->execute(array($user));
			$compteurKEGG=0;
	        while ($data = $answerKEGG->fetch())
	        {
	        	$compteurKEGG++;
	        	echo '<form action="HomeUser.php" method="post">';
				echo '<input type="hidden" name="gene" value='.$data['idGene'].">";
	        	if ($compteurKEGG == '1'){
					echo "<TABLE BORDER = \"1\" style=\"text-align:center\" cellspacing=\"0\"><TR><TD bgcolor=\"#40919B\">Gènes</TD><TD bgcolor=\"#40919B\">Identifiants KEGG</TD><TD bgcolor=\"#40919B\">Liens</TD><TD bgcolor=\"#40919B\"></TD></TR>";
				}
				echo "<TR><TD><a href=../genes/GeneSheet.php?gene=".$data['idGene'].">".$data['idGene']."</a></TD>
						<TD>".$data['codeGene']."</TD>
						<TD><a href=https://www.genome.jp/dbget-bin/www_bget?".$data['organisme'].":".$data['codeGene']." target=\"_blank\">KEGG</a></TD>
						<TD>".'<input type="submit" name="kegg" value="Supprimer"></form>'."</TD></TR>";

	        }
	        echo "</TABLE>";
	        $answerKEGG->closeCursor();
	        if ($compteurKEGG==0){echo "Vous n'avez publié aucun identifiant KEGG";}
			
			
			echo '<h1>Structure(s) publiée(s):</h1>';
			//Si l'utilisateur supprime une structure
			if (isset($_POST['structure'])){
				$prot=$_POST['prot'];
				echo "<red>Suppression de la structure pour la proteine:".$prot."</red><br>";
				$suppressionStruc = $bdd->prepare('DELETE FROM Structure WHERE idUser=? AND idProt=?;');
				$suppressionStruc->execute(array($idUser,$prot));
				//Supprime les fichiers associés;
				unlink('../proteines/Structure/'.$prot.'/Struc_'.$prot.'_'.$idUser.'.pdb');
			}
	        //Préparation de la requête sql pour récupérer les structures publiés par l'utilisateur
			$answerStruc = $bdd->prepare('SELECT idProt,nomFichier,annotation FROM Structure s JOIN User u WHERE s.idUser=u.idUser AND u.alias=?');
			$answerStruc->execute(array($user));
	        $compteurStruc=0;
	        while ($data = $answerStruc->fetch())
	        {
	        	$compteurStruc++;
	        	echo '<form action="HomeUser.php" method="post">';
				echo '<input type="hidden" name="prot" value='.$data['idProt'].">";
	        	if ($compteurStruc == '1'){
					echo "<TABLE BORDER = \"1\" style=\"text-align:center\" cellspacing=\"0\"><TR><TD bgcolor=\"#F6A33D\">Protéines</TD><TD bgcolor=\"#F6A33D\">Fichiers Structure</TD><TD bgcolor=\"#F6A33D\">Annotations</TD><TD bgcolor=\"#F6A33D\"></TD></TR>";
				}
				
				echo "<TR><TD><a href=../proteines/ProtSheet.php?prot=".$data['idProt'].">".$data['idProt']."</a></TD>
						<TD><a href=".$data['nomFichier']."download>Télécharger</a></TD>
						<TD>".$data['annotation']."</TD>
						<TD>".'<input type="submit" name="structure" value="Supprimer"></form>'."</TD></TR>";
	        }
	        echo "</TABLE>";
	        
	        $answerStruc->closeCursor();
	        if ($compteurStruc==0){echo "Vous n'avez publié aucune structure";}

	        
	        echo '<h1>Identifiant(s) UniProt publié(s):</h1>';
	        //Si l'utilisateur supprime un identifiant UniProt
			if (isset($_POST['uniprot'])){
				$prot=$_POST['prot'];
				echo "<red>Suppression de l'identifant UniProt pour la proteine:".$prot."</red><br>";
				$suppressionStruc = $bdd->prepare('DELETE FROM UniProt WHERE idUser=? AND idProt=?;');
				$suppressionStruc->execute(array($idUser,$prot));
			}
			//Préparation de la requête sql pour récupérer les id UniProt associé à cette proteines 
			$answerUniProt= $bdd->prepare('SELECT u.idUser,idProt,codeUniProt FROM UniProt un JOIN User u WHERE u.alias=? AND un.idUser=u.idUser;');
			$answerUniProt->execute(array($user));
			//Affiche les phylogenies du le gène
			$compteurUniProt=0;
	        while ($data = $answerUniProt->fetch())
	        {
	        	$compteurUniProt++;
	        	echo '<form action="HomeUser.php" method="post">';
				echo '<input type="hidden" name="prot" value='.$data['idProt'].">";
				
	        	if ($compteurUniProt == '1'){
					echo "<TABLE BORDER = \"1\" style=\"text-align:center\" cellspacing=\"0\"><TR><TD bgcolor=\"#40919B\">Protéines</TD><TD bgcolor=\"#40919B\">Identifiants Uniprot</TD><TD bgcolor=\"#40919B\">Liens</TD><TD bgcolor=\"#40919B\"></TD></TR>";
				}
	        	
	        	echo "<TR><TD><a href=../proteines/ProtSheet.php?prot=".$data['idProt'].">".$data['idProt']."</a></TD>
							<TD>".$data['codeUniProt']."</TD>
							<TD><a href=https://www.uniprot.org/uniprot/".$data['codeUniProt']." target=\"_blank\">UniProt</a></TD>
							<TD>".'<input type="submit" name="uniprot" value="Supprimer"></form>'."</TD></TR>";
	        }
	        echo "</TABLE>";
	        $answerUniProt->closeCursor();
	        if ($compteurUniProt==0){echo "Aucun identifant UniProt n'est disponible pour cette proteine";}
		?>
        </section>
	</div>
	
	<?php include("../Footer.php"); ?>
	
  </body>

</html>
