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
			
			//Préparation de la requête sql pour récupérer toutes les informations de l'utilisateur
			$answer = $bdd->prepare('SELECT alias,email,nom,prenom,nomLabo,dateDeCreation,dateDerniereCo FROM User WHERE alias = ?');
			
			//Exécute la requête avec la variable passée en argument (la variable remplace "?")
			$answer->execute(array($user));
			
			//Affiche les résultats de la requête dans un tableau
			echo "<h1>Informations de l'utilisateur:</h1>";
			echo "<TABLE>";
			while ($data = $answer->fetch())
			{
	            echo '<TR><TD>'.'Identifiant: '.'</TD><TD>'.$data['alias'].'</TD></TR>'.
	            '<TR><TD>'.'Email:  '.'</TD><TD>'.$data['email'].'</TD></TR>'.
	            '<TR><TD>'.'Nom: '.'</TD><TD>'.$data['nom'].'</TD></TR>'.
	            '<TR><TD>'.'Prenom: '.'</TD><TD>'.$data['prenom'].'</TD></TR>'.
	            '<TR><TD>'.'Laboratoire: '.'</TD><TD>'.$data['nomLabo'].'</TD></TR>'.
	            '<TR><TD>'.'Date de creation: '.'</TD><TD>'.$data['dateDeCreation'].'</TD></TR>'.
	            '<TR><TD>'.'Date de dernière connexion: '.'</TD><TD>'.$data['dateDerniereCo'].'</TD></TR>';
			}
			$answer->closeCursor();
			echo "</TABLE>";

			//Préparation de la requête sql pour récupérer les phyolgenies publiés par l'utilisateur
			$answerPhylo = $bdd->prepare('SELECT idGene,nomFichierArbre,nomFichierAlignement,outil,annotation FROM Phylogenie ph JOIN User u WHERE ph.idUser=u.idUser AND u.alias=?');
			$answerPhylo->execute(array($user));
			
			echo '<h1>Phylogenie(s) publiés:</h1>';
			$compteurPhylo=0;
	        while ($data = $answerPhylo->fetch())
	        {
	        	$compteurPhylo++;
	        	echo "<bleu>Pour le gène ".$data['idGene'].":</bleu>";
				echo "<TABLE><TR><TD>Arbre:</TD><TD><a href=../genes/".$data['nomFichierArbre'].">Voir le fichier</a></TD></TR>
				<TR><TD>Alignement:</TD><TD><a href=../genes/".$data['nomFichierAlignement'].">Voir le fichier</a></TD></TR>
				<TR><TD>Outils:</TD><TD>".$data['outil']."</TD></TR>
				<TR><TD>Annotation:</TD><TD>".$data['annotation']."</TD></TR>";
				echo "</TABLE>";
	        }
	        $answerPhylo->closeCursor();
	        if ($compteurPhylo==0){echo "Vous n'avez publié aucune phylogénie";}


	        //Préparation de la requête sql pour récupérer les structures publiés par l'utilisateur
			$answerStruc = $bdd->prepare('SELECT idProt,nomFichier,annotation FROM Structure s JOIN User u WHERE s.idUser=u.idUser AND u.alias=?');
			$answerStruc->execute(array($user));

			echo '<h1>Structure(s) publiés:</h1>';
	        $compteurStruc=0;
	        while ($data = $answerStruc->fetch())
	        {
	        	$compteurStruc++;
	        	echo "<bleu>Pour la proteine ".$data['idProt'].":</bleu>";
				echo '<TABLE><TR><TD>Fichier Structure:</TD><TD><a href='.$data['nomFichier'].'>Voir le fichier</a></TD></TR><TR><TD>Annotation:</TD><TD>'.$data['annotation'].'</TD></TR>';
				echo '</TABLE>';
	        }
	        $answerStruc->closeCursor();
	        if ($compteurStruc==0){echo "Vous n'avez publié aucune structure";}
		?>
		<form action="LogIn.php" method="post">
			<input type="submit" value="Se déconnecter">
		</form>
        </section>
	</div>
	
	<?php include("../Footer.php"); ?>
	
  </body>

</html>
