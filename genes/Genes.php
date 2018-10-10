<!DOCTYPE html>

<html lang="fr">
<!-- Récupére l'organisme depuis la variable de session -->
<?php
	session_start();
	$_SESSION['currentPage']="genes";
	if ((isset($_SESSION['orga'])) && ($_SESSION['orga'] != '')){
	$orga=$_SESSION['orga'];
	}
else{$orga='INCONNU';}
?>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../AFMC.css"> 
	<title>AFMC</title>
  </head>
  
  <body>
	<?php include("../Menu.php"); ?>

	<div id="conteneur">
			<gene_analysis_start>
				Gènes dont l'analyse a déja commencé: <br>
				gene1<br>
				gene2<br>
				gene3<br>
			</gene_analysis_start>
			<section>
			Gene non analysé:<br>
			gene4<br>
			gene5<br>
			gene6<br>
			</section>
	</div>
	
	<?php include("../Footer.php"); ?>
	
  </body>

</html>
