<!DOCTYPE html>

<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../AFMC.css"> 
	<title>AFMC</title>
  </head>
  
  <?php session_start();$_SESSION['currentPage']="search";
		//CONSULTATION DE LA BASE DE DONNEE
		include("../DatabaseConnection.php");

		//Initialisation des variables nécessairent à la requête
		$attributs='alias';
		$tables=' FROM User ';
		$conditions='';
		$data = array();
		
		//Ajoute la condition sur l'alias de l'utilisateur
		if ((isset($_GET['id'])) && ($_GET['id']!="")){
	  		$id=$_GET['id'];
	  		array_push($data,"%".$id."%");
	  		if($conditions==''){
	  			$conditions.='WHERE alias LIKE ? ';
	  		}else{$conditions.='AND alias LIKE ? ';}
	  	}

	  	//Ajoute la condition sur le nom de l'utilisateur
	  	if (isset($_GET['nom']) && $_GET['nom']!=""){
	  		$nom=$_GET['nom'];
	  		array_push($data,"%".$nom."%");
	  		if($conditions==''){
	  			$conditions.='WHERE nom LIKE ? ';
	  		}else{$conditions.='AND nom LIKE ? ';}
	  		$attributs.=",nom";
	  	}

	  	//Ajoute la condition sur le prénom de l'utilisateur
	  	if (isset($_GET['prenom']) && $_GET['prenom']!=""){
	  		$prenom=$_GET['prenom'];
	  		array_push($data,"%".$prenom."%");
	  		if($conditions==''){
	  			$conditions.='WHERE prenom LIKE ? ';
	  		}else{$conditions.='AND prenom LIKE ? ';}
	  		$attributs.=",prenom";
	  	}

	  	//Ajoute la condition sur l'email de l'utilisateur
	  	if (isset($_GET['email']) && $_GET['email']!=""){
	  		$email=$_GET['email'];
	  		array_push($data,"%".$email."%");
	  		if($conditions==''){
	  			$conditions.='WHERE email LIKE ? ';
	  		}else{$conditions.='AND email LIKE ? ';}
	  		$attributs.=",email";
	  	}

	  	//Ajoute la condition sur le nom du laboratoire de l'utilisateur
	  	if (isset($_GET['nomLabo']) && $_GET['nomLabo']!=""){
	  		$nomLabo=$_GET['nomLabo'];
	  		array_push($data,"%".$nomLabo."%");
	  		if($conditions==''){
	  			$conditions.='WHERE nomLabo LIKE ? ';
	  		}else{$conditions.='OR nomLabo LIKE ? ';}
	  		$attributs.=",nomLabo";
	  	}

	  	//Lance la requête ainsi crée
	  	$answer= $bdd->prepare("SELECT ".$attributs.$tables.$conditions);
		$answer->execute($data);
  ?>
  <body>
	<?php include("../Menu.php"); ?>
	
	<!-- Milieu de page -->
	<div id="conteneur">
		<!-- Contenu de la page -->
		<section>
			<?php include("../Title.php"); ?>
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
			   		//Affiche un lien vers la fiche utilisateur'
			    	echo "<TR><TD><a href=\"UserSheet.php?id=".$data['alias'].'" >'.$data['alias']."</a></TD>";

			    	//Affiche les attributs autres que l'alias
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
