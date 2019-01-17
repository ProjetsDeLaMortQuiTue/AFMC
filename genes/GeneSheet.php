<!DOCTYPE html>
<!-- Page qui affiche un gène pour un organisme donné -->

<html lang="fr">
<?php
	session_start();
	$_SESSION['currentPage']="genes";

	//Récupère le gène à afficher
	if ((isset($_GET['gene'])) && ($_GET['gene'] != '')){
	$gene = $_GET['gene'];
	}
	else{$gene='INCONNU';}
?>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../AFMC.css"> 
	<title>AFMC</title>
  </head>
  	<?php
		//Connexion à la base de donnée
		include("../DatabaseConnection.php");

		//Préparation de la requête sql pour récupérer les informations sur le gène
		$answerGene = $bdd->prepare('SELECT idGene,nomProtGene,tailleGene,debGene,finGene,brin,numChromosome,seqGene FROM Gene WHERE idGene = ?');
		//Exécute la requête avec la variable passée en argument ($gene remplace "?")
		$answerGene->execute(array($gene));
		
		//Préparation de la requête sql pour récupérer les proteines associés au gène
		$answerProt = $bdd->prepare('SELECT idProt FROM Proteine WHERE idGene = ?');
		//Exécute la requête avec la variable passée en argument ($gene remplace "?")
		$answerProt->execute(array($gene));

		//Préparation de la requête sql pour récupérer les phyolgenie associés au gène
		$answerPhylo = $bdd->prepare('SELECT u.idUser,alias,nomFichierArbre,nomFichierAlignement,outil,annotation FROM Phylogenie ph JOIN User u WHERE idGene = ? AND ph.idUser=u.idUser;');
		$answerPhylo->execute(array($gene));

		//Préparation de la requête sql pour récupérer les identifiant KEGG associés au gènes
		$answerKEGG = $bdd->prepare('SELECT u.idUser,alias,codeGene,organisme FROM KEGG k JOIN User u WHERE idGene = ? AND k.idUser=u.idUser;');
		$answerKEGG->execute(array($gene));


		//Récupére l'identifiant de l'utilisateur
		$idUser='';
		if ((isset($_SESSION['user'])) && ($_SESSION['user'] != '')){
			$answerUser = $bdd->prepare('SELECT idUser FROM User WHERE alias = ?');
			$answerUser->execute(array($_SESSION['user']));
			while ($data = $answerUser->fetch()){$idUser=$data['idUser'];}
		}
	?>
  <body>
	<?php include("../Title2.php"); ?>
	<?php include("../Menu.php"); ?>

	<div id="conteneur">
		<!-- Contenu de la page -->
		<section>
		<?php
			echo "<h1>Données présentent pour le gène ".$gene."</h1>";
		    echo '<TABLE>';
	        //Affiche les informations sur le gène
	        while ($data = $answerGene->fetch())
	        {
	            echo '<TR><TD>'.'Identifiant du gène: '.'</TD><TD>'.$data['idGene'].'</TD></TR>'.
	            '<TR><TD>'.'Fonction:  '.'</TD><TD>'.$data['nomProtGene'].'</TD></TR>'.
	            '<TR><TD>'.'Taille: '.'</TD><TD>'.$data['tailleGene'].'</TD></TR>'.
	            '<TR><TD>'.'Début: '.'</TD><TD>'.$data['debGene'].'</TD></TR>'.
	            '<TR><TD>'.'Fin: '.'</TD><TD>'.$data['finGene'].'</TD></TR>'.
	            '<TR><TD>'.'Brin: '.'</TD><TD>'.$data['brin'].'</TD></TR>'.
	            '<TR><TD>'.'Numéro du chromosome: '.'</TD><TD>'.$data['numChromosome'].'</TD></TR>'.
	            '<TR><TD>'.'Sequence: '.'</TD><TD><TEXTAREA rows=6 cols=60 readonly="readonly">'.$data['seqGene'].'</TEXTAREA><br><a href=Fasta/'.$gene.'.fasta download>Télécharger le fichier fasta</a></TD></TR>';
	        }
			$answerGene->closeCursor();

			echo '<TR><TD>Proteine(s) issus du gène:</TD><TD>';

	        //Affiche les proteines issus du gene
	        while ($data = $answerProt->fetch())
	        {
	            echo '<TR><TD><a href=../proteines/ProtSheet.php?prot='.$data['idProt'].'>'.$data['idProt'].';'.'</a><br></TD></TR>';
	        }
			$answerProt->closeCursor();
			echo '</TD></TR>';
		?>
		</TABLE>
		<h1>Données ajoutées par les utilisateurs sur le gène</h1>
		<?php
			echo '<u>Phylogenie(s) possible pour ce gène:</u><BR><BR>';
			//Affiche les phylogenies du gène
			$compteurPhylo=0;
	        while ($data = $answerPhylo->fetch())
	        {
	        	$compteurPhylo++;
	        	if ($compteurPhylo == '1'){
					echo "<TABLE BORDER = \"1\" cellspacing=\"0\"><TR><TD align=center bgcolor=\"#F6A33D\">Arbres</TD><TD align=center bgcolor=\"#F6A33D\">Alignements</TD><TD align=center bgcolor=\"#F6A33D\">Outils</TD><TD width=30% bgcolor=\"#F6A33D\">Annotations</TD><TD align=center bgcolor=\"#F6A33D\">Ajouté par</TD><TD align=center bgcolor=\"#F6A33D\"></TD></TR>";
				}
				
				if ($idUser != '' && $idUser == $data['idUser']){
					$proprietaire='Vous-même';
					$modif_ou_contact='Modifier? (à venir)</bleu>';
				}
				else{
					$proprietaire=$data['alias'];
					$modif_ou_contact= " <a href=../user/UserSheet.php?id=".$data['idUser'].'>Contacter</a></bleu>';
				}
				
	        	echo "<TR><TD align=center><a href=".$data['nomFichierArbre']." download>Télécharger l'arbre</a></TD>
						<TD align=center><a href=".$data['nomFichierAlignement']."download>Télécharger l'alignement</a></TD>
						<TD align=center>".$data['outil']."</TD>
						<TD>".$data['annotation']."</TD>
						<TD align=center>".$proprietaire."</TD>
						<TD align=center>".$modif_ou_contact."</TD></TR>";
	        }
	        echo "</TABLE>";
	        
	        $answerPhylo->closeCursor();
	        if ($compteurPhylo==0){echo "Aucune phylogénie n'est disponible pour ce gène";}
	        ?>
	        <br>
			<form action=addPhylo.php method="GET">
				<input type="hidden" name="gene" value=<?php echo $gene ?>>
				<input type="submit" value="Ajouter une phylogénie">
			</form>
	      	<br>
	        <?php

			echo '<u>Identifiant(s) KEGG possibles pour ce gène:</u><BR><BR>';
			//Affiche les phylogenies du le gène
			$compteurKEGG=0;
	        while ($data = $answerKEGG->fetch())
	        {
	        	$compteurKEGG++;
	        	if ($compteurKEGG == '1'){
					echo "<TABLE BORDER = \"1\" cellspacing=\"0\"><TR><TD align=center bgcolor=\"#40919B\">Identifiants KEGG</TD><TD align=center bgcolor=\"#40919B\">Liens</TD><TD align=center bgcolor=\"#40919B\">Ajouté par</TD><TD align=center bgcolor=\"#40919B\"></TD></TR>";
				}
	        	if ($idUser != '' && $idUser == $data['idUser']){
					$proprietaire='Vous-même';
					$modif_ou_contact='Modifier? (à venir)</bleu>';
				}
				else{
					$proprietaire=$data['alias'];
					$modif_ou_contact= " <a href=../user/UserSheet.php?id=".$data['idUser'].'>Contacter</a></bleu>';
				}
				
				echo "<TR><TD align=center>".$data['codeGene']."</TD>
							<TD align=center><a href=https://www.genome.jp/dbget-bin/www_bget?".$data['organisme'].":".$data['codeGene'].">Visiter le site KEGG</a></TD>
							<TD align=center>".$proprietaire."</TD>
							<TD align=center>".$modif_ou_contact."</TD></TR>";
	        }
	        echo "</TABLE>";
	        $answerKEGG->closeCursor();
	        if ($compteurKEGG==0){echo "Aucun identifiant KEGG n'est proposé pour ce gène";}
		?>
		<form action=addKEGG.php method="GET">
				<input type="hidden" name="gene" value=<?php echo $gene ?>>
				<input type="submit" value="Ajouter un identifiant KEGG">
			</form>
		</section>
	</div>
	
	<?php include("../Footer.php"); ?>
	
  </body>

</html>
