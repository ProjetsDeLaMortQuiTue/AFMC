<!DOCTYPE html>

<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="AFMC.css"> 
	<title>AFMC</title>
  </head>
  <?php
  	$navigation_home="\"navigation_out\"";
  	$navigation_general_data="\"navigation_out\"";
  	$navigation_genes="\"navigation_out\"";
  	$navigation_proteines="\"navigation_out\"";
  	$navigation_contact="\"navigation_out\"";
  	$navigation_user="\"navigation_out\"";

  	$home_path="Home.php";
  	$general_data_path="General_data.php";
  	$genes_path="genes/Genes.php";
  	$proteines_path="proteines/Proteines.php";
  	$contact_path="Contact.php";
  	$logIn_path="user/LogIn.php";
  	$user_path="user/HomeUser.php";


  	//Si la variable globale contenant le nom de la page courante existe
	if ((isset($_SESSION['currentPage'])) && ($_SESSION['currentPage'] != '')){
		$currentPage=$_SESSION['currentPage'];
		//Si la page courante est l'accueil
		if ($currentPage=="home"){
			$navigation_home="\"navigation_in\"";
		}
		//Si la page courante est l'information générale
		else if ($currentPage=="general_data"){
				$navigation_general_data="\"navigation_in\"";
			}
			//Si la page courante est la pages des genes
			else if ($currentPage=="genes"){
					$navigation_genes="\"navigation_in\"";
					$home_path="../Home.php";
				  	$general_data_path="../General_data.php";
				  	$genes_path="Genes.php";
				  	$proteines_path="../proteines/Proteines.php";
				  	$contact_path="../Contact.php";
				  	$logIn_path="../user/LogIn.php";
  					$user_path="../user/HomeUser.php";
				}
				//Si la page courante est la page des proteines
				else if ($currentPage==="proteines"){
						$navigation_proteines="\"navigation_in\"";
						$home_path="../Home.php";
					  	$general_data_path="../General_data.php";
					  	$genes_path="../genes/Genes.php";
					  	$proteines_path="Proteines.php";
					  	$contact_path="../Contact.php";
					  	$logIn_path="../user/LogIn.php";
	  					$user_path="../user/HomeUser.php";
					}
					//Si la page courante est la page de contact
					else if ($currentPage==="contact"){
							$navigation_contact="\"navigation_in\"";
						}
						//Si la page courante est la page pour l'utilisateur
						else if ($currentPage==="user"){
								$navigation_user="\"navigation_in\"";
								$home_path="../Home.php";
							  	$general_data_path="../General_data.php";
							  	$genes_path="../genes/Genes.php";
							  	$proteines_path="../proteines/Proteines.php";
							  	$contact_path="../Contact.php";
							  	$logIn_path="LogIn.php";
			  					$user_path="HomeUser.php";
							}
	}
	if ((isset($_SESSION['orga'])) && ($_SESSION['orga'] != '')){
		$orga=$_SESSION['orga'];
		}
	?>
  
  <body>
	 <!-- Affiche le menu -->
	 <div id="menu_home">
			<p class=<?php echo $navigation_home ?> >
				<a href="<?php echo $home_path ?>" class="nav">Accueil</a><br>
			</p>
			<!-- Affiche la suite du menu seulement si la page courante n'est pas l'accueil-->
			<?php
			if ($currentPage!="home"){
			echo "<p class=$navigation_general_data>
						<a href=\"$general_data_path\" class=\"nav\">$orga</a><br>
					</p>
					<p class=$navigation_genes>
						<a href=\"$genes_path\" class=\"nav\">Gènes</a><br>
					</p>
					<p class=$navigation_proteines>
						<a href=\"$proteines_path\" class=\"nav\">Proteines</a><br>
					</p>
					<p class=$navigation_contact>
						<a href=\"$contact_path\" class=\"nav\">Contact</a><br>
					</p>";
			}
			if ((isset($_SESSION['user'])) && ($_SESSION['user'] != '')){
				$user=$_SESSION['user'];
				echo "<p class=$navigation_user>
						<a href=\"$user_path\" class=\"nav\">$user</a><br>
					</p>";
			}
			else{
			echo "<p class=$navigation_user>
						<a href=\"$logIn_path\" class=\"nav\">Se connecter</a><br>
			</p>";
			}

			?>
	</div>
  </body>
</html>
