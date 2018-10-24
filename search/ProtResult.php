<!DOCTYPE html>

<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../AFMC.css"> 
	<title>AFMC</title>
  </head>
  
  <?php session_start();$_SESSION['currentPage']="search";
  		try
		{	//Connection à la base de donnée avec l'utilisateur afmc
			$bdd = new PDO('mysql:host=localhost;dbname=AFMC;charset=utf8','afmc','marine&coralie');
			
		}
		catch (Exception $e)
		{
	        	die('Erreur : ' . $e->getMessage());
		} 

		//Initialisation de la requête et les informations à mettre dans cette requête
		$requete='SELECT idProt FROM Proteine NATURAL JOIN Gene NATURAL JOIN Espece ';
		$info = array();

		//Ajoute la condition sur l'identifiant de la proteine
		if ((isset($_GET['id'])) && ($_GET['id']!="")){
	  		$id=$_GET['id'];
	  		array_push($info,"%".$id."%");
	  		if($requete=='SELECT idProt FROM Proteine NATURAL JOIN Gene NATURAL JOIN Espece '){
	  			$requete.='WHERE ( idProt LIKE ? ';
	  		}else{$requete.='OR idProt LIKE ? ';}
	  	}

	  	//Ajoute la condition sur le nom de la proteine
	  	if (isset($_GET['nomProt']) && $_GET['nomProt']!=""){
	  		$nom=$_GET['nomProt'];
	  		array_push($info,"%".$nom."%");
	  		if($requete=='SELECT idProt FROM Proteine NATURAL JOIN Gene NATURAL JOIN Espece '){
	  			$requete.='WHERE ( nomProt LIKE ? ';
	  		}else{$requete.='OR nomProt LIKE ? ';}
	  	}

	  	//Ajoute la condition sur l'intervalle pour la taille'
	  	if (isset($_GET['taille1']) && $_GET['taille1']!=""){
	  		array_push($info,$_GET['taille1']);
	  		array_push($info,$_GET['taille2']);
	  		if($requete=='SELECT idProt FROM Proteine NATURAL JOIN Gene NATURAL JOIN Espece '){
	  			$requete.='WHERE ( tailleProt BETWEEN ? AND ?';
	  		}else{$requete.='OR tailleProt BETWEEN ? AND ?';}
	  	}

	  	//Ajoute la condition sur l(identifaint du gène associé)
	  	if (isset($_GET['idGene']) && $_GET['idGene']!=""){
	  		array_push($info,"%".$_GET['idGene']."%");
	  		if($requete=='SELECT idProt FROM Proteine NATURAL JOIN Gene NATURAL JOIN Espece '){
	  			$requete.='WHERE ( idGene LIKE ? ';
	  		}else{$requete.='OR idGene LIKE ? ';}
	  	}

	  	//Termine la requête avec la condition non optionnel sur l'espece
	  	array_push($info,$_SESSION['orga']);
	  	if($requete=='SELECT idProt FROM Proteine NATURAL JOIN Gene NATURAL JOIN Espece '){
	  		$requete.='WHERE nomEsp = ? ';
	  	}else{$requete.=' ) AND nomEsp = ? ';}

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
			<div id="header_txt_box">
				<h2 class="titre">AFMC</h2>
				L'Analyse Facile de Marine et Coralie<br>
				<br>
			</div>
			<?php
			//Affiche le resultat de la requête (idProt+lien vers la page associé à la proteine)
			while ($data = $answer->fetch())
			   	{
			    	echo "<a href=\"../proteines/ProtSheet.php?prot=".$data['idProt'].'" >'.$data['idProt']."</a><br>";
				}
				$answer->closeCursor(); 
			?>
        </section>
	</div>
	
	<?php include("../Footer.php"); ?>
	
  </body>
</html>
