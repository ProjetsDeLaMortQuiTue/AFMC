<!DOCTYPE html>
<!-- Page d'affichage des informations pour un transcript donnée -->

<html lang="fr">

<?php
	session_start();
	$_SESSION['currentPage']="proteines";

	//Récupére le transcript
	if ((isset($_GET['trans'])) && ($_GET['trans'] != '')){
	$trans = $_GET['trans'];
	}
	else {$trans='INCONNU';}
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
		<?php 
			include("../Title.php");

			//CONSULTATION DE LA BASE DE DONNEE
			include("../DatabaseConnection.php");

			//Préparation de la requete sql pour récupéré les informations du transcript
			$answer = $bdd->prepare('SELECT idTrans,nomTrans,tailleTrans,annotation,seqTrans FROM Transcript WHERE idTrans = ?');
			//Exécute la requête
			$answer->execute(array($trans));

		    echo "<TABLE>";

	        //Affiche les résultats de la requête dans un tableau
	        while ($data = $answer->fetch())
	        {
	            echo '<TR><TD>'.'Identifiant du trancript: '.'</TD><TD>'.$data['idTrans'].'</TD></TR>'.
	            '<TR><TD>'.'Nom:  '.'</TD><TD>'.$data['nomTrans'].'</TD></TR>'.
	            '<TR><TD>'.'Taille:  '.'</TD><TD>'.$data['tailleTrans'].'</TD></TR>'.
	            '<TR><TD>'.'Annotation: '.'</TD><TD>'.$data['annotation'].'</TD></TR>'.
	            '<TR><TD>'.'Sequence: '.'</TD><TD>'.$data['seqTrans'].'</TD></TR>';
	        }
			$answer->closeCursor();
		?>
		</TABLE>

	    <?php
	    	//AFfiche le lien vers la proteine associé 
			echo '<a href=ProtSheet.php?prot='.$trans.' class=\"nav\">Voir la proteine'.'</a>';
		?>
        </section>
	</div>
	<?php include("../Footer.php"); ?>
	
  </body>

</html>