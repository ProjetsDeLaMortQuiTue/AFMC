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
		$requete='SELECT alias FROM User ';
		$info = array();
		if ((isset($_GET['id'])) && ($_GET['id']!="")){
	  		$id=$_GET['id'];
	  		array_push($info,"%".$id."%");
	  		if($requete=='SELECT alias FROM User '){
	  			$requete.='WHERE alias LIKE ? ';
	  		}else{$requete.='OR alias LIKE ? ';}
	  	}
	  	if (isset($_GET['nom']) && $_GET['nom']!=""){
	  		$nom=$_GET['nom'];
	  		array_push($info,"%".$nom."%");
	  		if($requete=='SELECT alias FROM User '){
	  			$requete.='WHERE nom LIKE ? ';
	  		}else{$requete.='OR nom LIKE ? ';}
	  	}
	  	if (isset($_GET['prenom']) && $_GET['prenom']!=""){
	  		$prenom=$_GET['prenom'];
	  		array_push($info,"%".$prenom."%");
	  		if($requete=='SELECT alias FROM User '){
	  			$requete.='WHERE prenom LIKE ? ';
	  		}else{$requete.='OR prenom LIKE ? ';}
	  	}
	  	if (isset($_GET['email']) && $_GET['email']!=""){
	  		$email=$_GET['email'];
	  		array_push($info,"%".$email."%");
	  		if($requete=='SELECT alias FROM User '){
	  			$requete.='WHERE email LIKE ? ';
	  		}else{$requete.='OR email LIKE ? ';}
	  	}
	  	if (isset($_GET['nomLabo']) && $_GET['nomLabo']!=""){
	  		$nomLabo=$_GET['nomLabo'];
	  		array_push($info,"%".$nomLabo."%");
	  		if($requete=='SELECT alias FROM User '){
	  			$requete.='WHERE nomLabo LIKE ? ';
	  		}else{$requete.='OR nomLabo LIKE ? ';}
	  	}

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
			while ($data = $answer->fetch())
			   	{
			    	echo "<a href=\"UserSheet.php?id=".$data['alias'].'" >'.$data['alias']."</a><br>";
				}
				$answer->closeCursor(); 
			?>
        </section>
	</div>
	
	<?php include("../Footer.php"); ?>
	
  </body>
</html>
