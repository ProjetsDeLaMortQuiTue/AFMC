<!DOCTYPE html>

<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../AFMC.css"> 
	<title>AFMC</title>
  </head>
  
  <?php 
		session_start();
		$_SESSION['currentPage']="search";
  		
  		try
		{	//Connection à la base de donnée avec l'utilisateur afmc
			$bdd = new PDO('mysql:host=localhost;dbname=AFMC;charset=utf8','afmc','marine&coralie');
			
		}
		catch (Exception $e)
		{
	        	die('Erreur : ' . $e->getMessage());
		}

		//Initialisation de la requête et les informations à mettre dans cette requête
		$requete='SELECT idGene FROM Gene NATURAL JOIN Espece ';
		$info = array();

		//Ajoute la condition sur la proteine associé
		if (isset($_GET['idProt']) && $_GET['idProt']!=""){
	  		$idProt=$_GET['idProt'];
	  		array_push($info,"%".$idProt."%");
	  		$requete.='NATURAL JOIN Proteine WHERE ( idProt LIKE ? ';
	  	}

	  	//Ajoute la condition sur l'identifiant du gène
		if ((isset($_GET['id'])) && ($_GET['id']!="")){
	  		$id=$_GET['id'];
	  		array_push($info,"%".$id."%");
	  		if($requete=='SELECT idGene FROM Gene NATURAL JOIN Espece '){
	  			$requete.='WHERE ( idGene LIKE ? ';
	  		}else{$requete.='OR idGene LIKE ? ';}
	  	}

	  	//Ajoute la condition sur le nom de la proteine issus au gene
	  	if (isset($_GET['nomProt']) && $_GET['nomProt']!=""){
	  		$nom=$_GET['nomProt'];
	  		array_push($info,"%".$nom."%");
	  		if($requete=='SELECT idGene FROM Gene NATURAL JOIN Espece '){
	  			$requete.='WHERE ( nomProtGene LIKE ? ';
	  		}else{$requete.='OR nomProtGene LIKE ? ';}
	  	}

	  	//Ajoute la condition sur l'intervalle pour la taille
	  	if (isset($_GET['taille1']) && $_GET['taille1']!=""){
	  		array_push($info,$_GET['taille1']);
	  		array_push($info,$_GET['taille2']);
	  		if($requete=='SELECT idGene FROM Gene NATURAL JOIN Espece '){
	  			$requete.='WHERE ( tailleGene BETWEEN ? AND ?';
	  		}else{$requete.='OR tailleGene BETWEEN ? AND ?';}
	  	}

	  	//Ajoute la condition sur l'orientation du brin
	  	if (isset($_GET['brin']) && $_GET['brin']!=""){
	  		$brin=$_GET['brin'];
	  		array_push($info,$brin);
	  		if($requete=='SELECT idGene FROM Gene NATURAL JOIN Espece '){
	  			$requete.='WHERE ( brin = ? ';
	  		}else{$requete.='OR brin = ? ';}
	  	}

	  	//Ajoute la condition sur le numéro du chromosome
	  	if (isset($_GET['chromosome']) && $_GET['chromosome']!=""){
	  		$chromosome=$_GET['chromosome'];
	  		array_push($info,$chromosome);
	  		if($requete=='SELECT idGene FROM Gene NATURAL JOIN Espece '){
	  			$requete.='WHERE ( numChromosome = ? ';
	  		}else{$requete.='OR numChromosome = ? ';}
	  	}

	  	//Ajoute la condition sur un motif pour la sequence
	  	if (isset($_GET['motif']) && $_GET['motif']!=""){
	  		array_push($info,$_GET['motif']);
	  		if($requete=='SELECT idGene FROM Gene NATURAL JOIN Espece '){
	  			$requete.='WHERE ( seqGene REGEXP ? ';
	  		}else{$requete.='OR seqGene REGEXP ? ';}
	  	}

	  	//Termine la requête avec la condition non optionnel sur l'espece
	  	array_push($info,$_SESSION['orga']);
	  	if($requete=='SELECT idGene FROM Gene NATURAL JOIN Espece '){
	  		$requete.='WHERE nomEsp = ? ';
	  	}else{$requete.=') AND nomEsp = ? ';}

	  	//Lance la requête ainsi crée
	  	$answer= $bdd->prepare($requete);
		$answer->execute($info);
  ?>
  <body>

	<?php include("../Menu.php"); ?>
	
	<!-- Milieu de page -->
	<div id="conteneur">
		<!-- Contenu de la page -->
		<section>
			<?php include("../Title.php"); ?>
			<?php
			//Affiche le resultat de la requête (idGene+lien vers la page associé au gène)
			while ($data = $answer->fetch())
		   	{
		    	echo "<a href=\"../genes/GeneSheet.php?gene=".$data['idGene'].'" >'.$data['idGene']."</a><br>";
			}
			$answer->closeCursor(); 
			?>
        </section>
	</div>
	
	<?php include("../Footer.php"); ?>
	
  </body>
</html>
