<!DOCTYPE html>
<!-- Page pour lancer une recherche sur un gene, une proteine ou un utilisateur  -->

<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../AFMC.css"> 
	<title>AFMC</title>
  </head>
  
  <?php session_start();$_SESSION['currentPage']="search"; ?>
  <body>
	<?php include("../Menu.php"); ?>
	
	<!-- Milieu de page -->
	<div id="conteneur">
		<!-- Contenu de la page -->
		<section>
			<?php include("../Title.php"); ?>
			<TABLE>
					<TR><TD>Catégorie :</TD><TD>
					<!-- Affiche les catégories gène et proteine si un organisme a été sélectionné  -->
					<?php if ((isset($_SESSION['orga'])) && ($_SESSION['orga'] != '')){
							echo "
					<form action='Search.php' method=\"post\">
						<input type=\"submit\" name=\"categorie\" value=\"Gene\">
					</form></TD><TD>
					<form action='Search.php' method=\"post\">
						<input type=\"submit\" name=\"categorie\" value=\"Proteine\">
					</form></TD><TD>";
					}
					?>
					<!-- Affiche la catégorie utilisateur -->
					<form action='Search.php' method="post">
						<input type="submit" name="categorie" value="Utilisateur">
					</form>
					</TD></TR>
			</TABLE>

			<!--Si une catégorie a été sélectionné-->
			<?php     if ((isset($_POST['categorie'])) && ($_POST['categorie'] != '')){
		    	$categorie=$_POST['categorie'];

		    	//Formulaire de recherche pour le GENE
		    	if ($categorie=="Gene"){
		    		echo '<h1>Formulaire pour rechercher un gène</h1>';
		    		echo '<form action=\'GeneResult.php\' method="get"><table style="text-align:JUSTIFY">';
		    		echo '<TR><TD align=\'left\'>Identifiant</TD><TD><input type="text" name="id"></TD></TR>
		    	<TR><TD>Fonction</TD><TD><input type="text" name="nomProt"></TD></TR>
		    	<TR><TD>Taille entre </TD><TD  align="justify"><input size=4 type="text" name="taille1"> et <input size=4 type="text" name="taille2"></TD></TR>
		    	<TR><TD>Brin </TD><TD>
					<input type="radio" name="brin" value="-" />-
					<input type="radio" name="brin" value="+" />+</TD></TR>
		    	<TR><TD>N° du chromosome</TD><TD><input type="text" name="chromosome"></TD></TR>
		    	<TR><TD>Proteine associé</TD><TD><input type="text" name="idProt"></TD></TR>
		    	<TR><TD>Par motif sur la sequence</TD><TD><input type="text" name="motif"></TD><TD><a href=\'Regex.php\'>En savoir plus sur la syntax des motifs?</a></TD></TR>';


		    	//Formulaire de recherche pour la PROTEINE
		    	}else if ($categorie=="Proteine") {
		    		echo '<h1>Formulaire pour rechercher une proteine</h1>';
		    		echo '<form action=\'ProtResult.php\' method="get"><TABLE>';
		    		echo '<TR><TD>Identifiant</TD><TD><input type="text" name="id"></TD></TR>
		    	<TR><TD>Nom</TD><TD><input type="text" name="nomProt"></TD></TR>
		    	<TR><TD>Taille entre </TD><TD  align="justify"><input size=4 type="text" name="taille1"> et <input size=4 type="text" name="taille2"></TD></TR>
		    	<TR><TD>Gene associé</TD><TD><input type="text" name="idGene"></TD></TR>
		    	<TR><TD>Par motif sur la sequence</TD><TD><input type="text" name="motif"></TD><TD><a href=\'Regex.php\'>En savoir plus sur la syntax des motifs?</a></TD></TR>';

		    	//Formulaire de recherche pour l'UTILISATEUR
		    	}else{
		    		echo '<h1>Formulaire pour rechercher un utilisateur</h1>';
		    		echo '<form action=\'UserResult.php\' method="get"><TABLE>';
		    		echo '<TR><TD>Identifiant</TD><TD><input type="text" name="id"></TD></TR>
		    	<TR><TD>Nom</TD><TD><input type="text" name="nom"></TD></TR>
		    	<TR><TD>Prénom</TD><TD><input type="text" name="prenom"></TD></TR>
		    	<TR><TD>Email</TD><TD><input type="text" name="email"></TD></TR>
		    	<TR><TD>Nom Laboratoire</TD><TD><input type="text" name="nomLabo"></TD></TR>';

		    }
		    	echo '</TABLE><input type="image" src="../ok.png"><br>
		    		</form>';
		    }?>
	
        </section>
	</div>
	
	<?php include("../Footer.php"); ?>
	
  </body>
</html>
