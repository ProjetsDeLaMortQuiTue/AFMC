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
		$attributs='idProt';
		$tables=' FROM Proteine NATURAL JOIN Gene NATURAL JOIN Espece ';
		$conditions='';
		$data = array();

		//Ajoute la condition sur l'identifiant de la proteine
		if ((isset($_GET['id'])) && ($_GET['id']!="")){
	  		$id=$_GET['id'];
	  		array_push($data,"%".$id."%");
	  		if($conditions==''){
	  			$conditions.='WHERE idProt LIKE ? ';
	  		}else{$conditions.='AND idProt LIKE ? ';}
	  	}

	  	//Ajoute la condition sur le nom de la proteine
	  	if (isset($_GET['nomProt']) && $_GET['nomProt']!=""){
	  		$nom=$_GET['nomProt'];
	  		array_push($data,"%".$nom."%");
	  		if($conditions==''){
	  			$conditions.='WHERE nomProt LIKE ? ';
	  		}else{$conditions.='AND nomProt LIKE ? ';}
	  		$attributs.=',nomProt';
	  	}

	  	//Ajoute la condition sur l'intervalle pour la taille'
	  	if (isset($_GET['taille1']) && $_GET['taille1']!=""){
	  		array_push($data,$_GET['taille1']);
	  		array_push($data,$_GET['taille2']);
	  		if($conditions==''){
	  			$conditions.='WHERE tailleProt BETWEEN ? AND ?';
	  		}else{$conditions.='AND tailleProt BETWEEN ? AND ?';}
	  		$attributs.=',tailleProt';
	  	}

	  	//Ajoute la condition sur l'identifiant du gène associé
	  	if (isset($_GET['idGene']) && $_GET['idGene']!=""){
	  		array_push($data,"%".$_GET['idGene']."%");
	  		if($conditions==''){
	  			$conditions.='WHERE idGene LIKE ? ';
	  		}else{$conditions.='AND idGene LIKE ? ';}
	  		$attributs.=',idGene';

	  	}

	  	//Termine la requête avec la condition non optionnel sur l'espece
	  	array_push($data,$_SESSION['orga']);
	  	if($conditions==''){
	  		$conditions.='WHERE nomEsp = ? ';
	  	}else{$conditions.=' AND nomEsp = ? ';}

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
			   		//Affiche un lien vers la proteine
			    	echo "<TR><TD><a href=\"../proteines/ProtSheet.php?prot=".$data['idProt'].'" >'.$data['idProt']."</a></TD>";
			    	
			    	//Affiche les attributs autres que idProt
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
