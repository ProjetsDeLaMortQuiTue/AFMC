<!DOCTYPE html>

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
			<div id="header_txt_box">
				<h2 class="titre">AFMC</h2>
				L'Analyse Facile de Marine et Coralie<br>
				<br>
			</div>
			<TABLE>
					<TR><TD>Catégorie :</TD><TD>
						<?php if ((isset($_SESSION['orga'])) && ($_SESSION['orga'] != '')){
							echo "
					<form action='Search.php' method=\"post\">
						<input type=\"submit\" name=\"categorie\" value=\"Gene\">
					</form></TD><TD>
					<form action='Search.php' method=\"post\">
						<input type=\"submit\" name=\"categorie\" value=\"Proteine\">
					</form></TD><TD>";}
					?>
					<form action='Search.php' method="post">
						<input type="submit" name="categorie" value="Utilisateur">
					</form>
					</TD></TR>
			</TABLE>
			<!--Si une catégorie a été sélectionné-->
			<?php     if ((isset($_POST['categorie'])) && ($_POST['categorie'] != '')){
		    	$categorie=$_POST['categorie'];
		    	//Recherche pour le GENE
		    	if ($categorie=="Gene"){
		    		echo '<form action=\'Search.php\' method="get"><TABLE>';
		    		echo 'Formulaire à faire';

		    	//Recherche pour la PROTEINE
		    	}else if ($categorie=="Proteine") {
		    		echo '<form action=\'Search.php\' method="get"><TABLE>';
		    		echo 'Formulaire à faire';

		    	//Recherche pour l'UTILISATEUR
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
