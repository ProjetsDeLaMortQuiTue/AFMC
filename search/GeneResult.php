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

		//Initialisation des variables nécessairent à la requête
		$attributs='idGene';
		$tables=' FROM Gene NATURAL JOIN Espece ';
		$conditions='';
		$data = array();

	  	//Ajoute la condition sur l'identifiant du gène
		if ((isset($_GET['id'])) && ($_GET['id']!="")){
	  		array_push($data,"%".$_GET['id']."%");
	  		$conditions.='WHERE idGene LIKE ? ';
	  	}

	  	//Ajoute la condition sur le nom de la proteine issus au gene
	  	if (isset($_GET['nomProt']) && $_GET['nomProt']!=""){
	  		array_push($data,"%".$_GET['nomProt']."%");
	  		if($conditions==''){
	  			$conditions.='WHERE nomProtGene LIKE ? ';
	  		}else{$conditions.='AND nomProtGene LIKE ? ';}
	  		$attributs.=',nomProtGene';
	  	}

	  	//Ajoute la condition sur l'intervalle pour la taille
	  	if (isset($_GET['taille1']) && $_GET['taille1']!=""){
	  		array_push($data,$_GET['taille1']);
	  		array_push($data,$_GET['taille2']);
	  		if($conditions==''){
	  			$conditions.='WHERE tailleGene BETWEEN ? AND ? ';
	  		}else{$conditions.='AND tailleGene BETWEEN ? AND ?';}
	  		$attributs.=',tailleGene';
	  	}

	  	//Ajoute la condition sur l'orientation du brin
	  	if (isset($_GET['brin']) && $_GET['brin']!=""){
	  		array_push($data,$_GET['brin']);
	  		if($conditions==''){
	  			$conditions.='WHERE brin = ? ';
	  		}else{$conditions.='AND brin = ? ';}
	  		$attributs.=',brin';
	  	}

	  	//Ajoute la condition sur le numéro du chromosome
	  	if (isset($_GET['chromosome']) && $_GET['chromosome']!=""){
	  		array_push($data,$_GET['chromosome']);
	  		if($conditions==''){
	  			$conditions.='WHERE numChromosome = ? ';
	  		}else{$conditions.='AND numChromosome = ? ';}
	  		$attributs.=',numChromosome';
	  	}

	  	//Ajoute la condition sur la proteine associé
		if (isset($_GET['idProt']) && $_GET['idProt']!=""){
	  		array_push($data,"%".$_GET['idProt']."%");
	  		$tables.='NATURAL JOIN Proteine ';
	  		if($conditions==''){
	  			$conditions.=' WHERE idProt LIKE ? ';
	  		}else{$conditions.=' AND idProt LIKE ? ';}
	  		$attributs.=',idProt';
	  	}

	  	//Ajoute la condition sur un motif pour la sequence
	  	if (isset($_GET['motif']) && $_GET['motif']!=""){
	  		array_push($data,$_GET['motif']);
	  		if($conditions==''){
	  			$conditions.='WHERE seqGene REGEXP ? ';
	  		}else{$conditions.='AND seqGene REGEXP ? ';}
	  	}

	  	//Termine la requête avec la condition non optionnel sur l'espece
	  	array_push($data,$_SESSION['orga']);
	  	if($conditions==''){
	  		$conditions.='WHERE nomEsp = ? ';
	  	}else{$conditions.=' AND nomEsp = ? ';}

	  	//Lance la requête ainsi crée
	  	$answer= $bdd->prepare('SELECT '.$attributs.$tables.$conditions);
		$answer->execute($data);
  ?>
  <body>
	<?php include("../Title2.php"); ?>
	<?php include("../Menu.php"); ?>
	
	<!-- Milieu de page -->
	<div id="conteneur">
		<!-- Contenu de la page -->
		<section>
			Résultats : <br>
			<TABLE cellpadding=8>
			<TR>
			<?php
			$liste_attributs=preg_split ( "/,/", $attributs);
			foreach ($liste_attributs as $attribut) {
				echo '<TD>'.$attribut.'</TD>';
			}
			unset($liste_attributs[0]);
			echo '</TR>';
			while ($data = $answer->fetch())
		   	{
		   		//Affiche un lien vers le gène
		    	echo '<TR><TD><a href="../genes/GeneSheet.php?gene='.$data['idGene'].'" >'.$data['idGene'].'</a></TD>';

		    	//Affiche les attributs autres que idGene
		    	foreach ($liste_attributs as $attribut) {
					echo '<TD>'.$data[$attribut].'</TD>';
				}
				echo '</TR>';
			}

			$answer->closeCursor(); 
			?>
			</TABLE>
        </section>
	</div>
	
	<?php include("../Footer.php"); ?>
	
  </body>
</html>
