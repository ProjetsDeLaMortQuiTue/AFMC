<!DOCTYPE html>

<!-- Fonction de connexion à la base de de donnée -->
<html lang="fr">
<?php
	try
	{	//Connection à la base de donnée avec l'utilisateur afmc
		$bdd = new PDO('mysql:host=localhost;dbname=AFMC;charset=utf8','afmc','marine&coralie');
		
	}
	catch (Exception $e)
	{
        	die('Erreur : ' . $e->getMessage());
	}
?>
</html>