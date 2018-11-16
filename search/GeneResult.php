<!DOCTYPE html>
<!-- Page de résultas pour les gènes-->

<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../AFMC.css"> 
	<title>AFMC</title>
  </head>
  
  <?php 
		session_start();
		$_SESSION['currentPage']="search";
  		
		//CONSULTATION DE LA BASE DE DONNEE
		include("../DatabaseConnection.php");

		//Initialisation des conditions et des tables nécessairent à la requête
		$tables='Gene NATURAL JOIN Espece ';
		$conditions='';
		$data = array();

		//Ajoute la condition sur la proteine associé
		if (isset($_GET['idProt']) && $_GET['idProt']!=""){
	  		array_push($data,"%".$_GET['idProt']."%");
	  		$tables.='NATURAL JOIN Proteine ';
	  		$conditions.=' WHERE ( idProt LIKE ? ';
	  	}

	  	//Ajoute la condition sur l'identifiant du gène
		if ((isset($_GET['id'])) && ($_GET['id']!="")){
	  		array_push($data,"%".$_GET['id']."%");
	  		if($conditions==''){
	  			$conditions.='WHERE ( idGene LIKE ? ';
	  		}else{$conditions.='OR idGene LIKE ? ';}
	  	}

	  	//Ajoute la condition sur le nom de la proteine issus au gene
	  	if (isset($_GET['nomProt']) && $_GET['nomProt']!=""){
	  		array_push($data,"%".$_GET['nomProt']."%");
	  		if($conditions==''){
	  			$conditions.='WHERE ( nomProtGene LIKE ? ';
	  		}else{$conditions.='OR nomProtGene LIKE ? ';}
	  	}

	  	//Ajoute la condition sur l'intervalle pour la taille
	  	if (isset($_GET['taille1']) && $_GET['taille1']!=""){
	  		array_push($data,$_GET['taille1']);
	  		array_push($data,$_GET['taille2']);
	  		if($conditions==''){
	  			$conditions.='WHERE ( tailleGene BETWEEN ? AND ? ';
	  		}else{$conditions.='OR tailleGene BETWEEN ? AND ?';}
	  	}

	  	//Ajoute la condition sur l'orientation du brin
	  	if (isset($_GET['brin']) && $_GET['brin']!=""){
	  		array_push($data,$_GET['brin']);
	  		if($conditions==''){
	  			$conditions.='WHERE ( brin = ? ';
	  		}else{$conditions.='OR brin = ? ';}
	  	}

	  	//Ajoute la condition sur le numéro du chromosome
	  	if (isset($_GET['chromosome']) && $_GET['chromosome']!=""){
	  		array_push($data,$_GET['chromosome']);
	  		if($conditions==''){
	  			$conditions.='WHERE ( numChromosome = ? ';
	  		}else{$conditions.='OR numChromosome = ? ';}
	  	}

	  	//Ajoute la condition sur un motif pour la sequence
	  	if (isset($_GET['motif']) && $_GET['motif']!=""){
	  		array_push($info,$_GET['motif']);
	  		if($conditions==''){
	  			$conditions.='WHERE ( seqGene REGEXP ? ';
	  		}else{$conditions.='OR seqGene REGEXP ? ';}
	  	}

	  	//Termine la requête avec la condition non optionnel sur l'espece
	  	array_push($data,$_SESSION['orga']);
	  	if($conditions==''){
	  		$conditions.='WHERE nomEsp = ? ';
	  	}else{$conditions.=') AND nomEsp = ? ';}

	  	//Lance la requête ainsi crée
	  	$answer= $bdd->prepare('SELECT idGene FROM '.$tables.$conditions);
		$answer->execute($data);
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
