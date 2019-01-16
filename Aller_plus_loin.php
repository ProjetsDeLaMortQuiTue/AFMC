<!DOCTYPE html>

<!-- Page pour contacter les webmasters de la page-->


<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="AFMC.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<title>AFMC</title>
  </head>
  
  <?php session_start();$_SESSION['currentPage']="aller_plus_loin"; ?>
  <body>
    <?php include("Title.php"); ?>
  	<?php include("Menu.php"); ?>
  	<div id="conteneur">
		<section>
			<p class="text">
				Ici se trouve une liste non-exhaustive des différents outils utilisables pour l'analyse de vos données:<br>
				<TABLE>
					<TR><TD colspan=2><hr color=rgb(246,163,61) width="100%" align=left></TD></TR>
					<TR><TD align=center><img src="ImagesOutils/logo_phylogeny-fr.png" alt="Logo_phylogeny"/></TD><TD><a href="http://www.phylogeny.fr/" target="_blank">Phylogeny</a><br>Phylogeny.fr exécute et relie différents programmes de bioinformatique afin de reconstruire un arbre phylogénétique robuste à partir d’un ensemble de séquences.</TD></TR>
					<TR><TD colspan=2><hr color=rgb(246,163,61) width="100%" align=left></TD></TR>
					<TR><TD align=center><img src="ImagesOutils/logo_blast.jpg" alt="Logo_blast" /></TD><TD><a href="https://blast.ncbi.nlm.nih.gov/Blast.cgi" target="_blank">Blast</a><br>BLAST trouve des régions de similitude entre les séquences biologiques. Le programme compare les séquences de nucléotides ou de protéines aux bases de données de séquences et en calcule la signification statistique.</TD></TR>
					<TR><TD colspan=2><hr color=rgb(246,163,61) width="100%" align=left></TD></TR>
					<TR><TD align=center><img src="ImagesOutils/logo_interpro_seq_analysis.png" alt="Logo_interpro_seq_analysis" /></TD><TD><a href="http://www.ebi.ac.uk/interpro/search/sequence-search" target="_blank">InterProScan: protein sequence analysis & classification</a><br>InterPro fournit une analyse fonctionnelle des protéines en les classant dans des familles et en prédisant des domaines et des sites importants. Il combine les signatures de protéines d'un certain nombre de bases de données membres dans une seule ressource pouvant faire l'objet d'une recherche, en tirant parti de leurs forces individuelles pour produire une puissante base de données intégrée et un outil de diagnostic.</TD></TR>
					<TR><TD colspan=2><hr color=rgb(246,163,61) width="100%" align=left></TD></TR>
					<TR><TD align=center><img src="ImagesOutils/logo_clustal_omega.png" alt="Logo_ilogo_clustal_omega" /></TD><TD><a href="https://www.ebi.ac.uk/Tools/msa/clustalo/" target="_blank">Clustal Omega</a><br>Clustal Omega est un programme d’alignement de séquences multiples qui utilise des arbres guides ensemencés et des techniques de profil de profil HMM pour générer des alignements entre trois séquences ou plus.</TD></TR>
					<TR><TD colspan=2><hr color=rgb(246,163,61) width="100%" align=left></TD></TR>
					<TR><TD align=center><img src="ImagesOutils/logo_hmmer.png" alt="Logo_hmmer" /></TD><TD><a href="https://www.ebi.ac.uk/Tools/hmmer/#" target="_blank">HMMER</a><br>Le serveur Web HMMER: recherches d'homologie rapides et sensibles. Ce site a été conçu pour fournir des recherches quasi interactives pour la plupart des requêtes, associées à des visualisations de résultats intuitives et interactives.</TD></TR>
					<TR><TD colspan=2><hr color=rgb(246,163,61) width="100%" align=left></TD></TR>
					<TR><TD align=center><img src="ImagesOutils/logo_tcoffee.png" alt="Logo_tcoffee" /></TD><TD><a href="http://tcoffee.crg.cat/apps/tcoffee/all.html" target="_blank">T-Coffee</a><br>Une collection d'outils de calcul, d'évaluation et de manipulation d'alignements multiples d'ADN, d'ARN, de séquences et de structures protéiques</TD></TR>
					<TR><TD colspan=2><hr color=rgb(246,163,61) width="100%" align=left></TD></TR>
					<TR><TD align=center><img src="ImagesOutils/logo_simple_phylogeny.png" alt="logo_simple_phylogeny" /></TD><TD><a href="https://www.ebi.ac.uk/Tools/phylogeny/simple_phylogeny/" target="_blank">Simple Phylogeny</a><br>Cet outil permet d'accéder aux méthodes de génération d'arborescence phylogénétique à partir du package ClustalW2. Veuillez noter qu'il ne s'agit pas d'un outil d'alignement de séquences multiples.</TD></TR>
					<TR><TD colspan=2><hr color=rgb(246,163,61) width="100%" align=left></TD></TR>
					<TR><TD align=center><img src="ImagesOutils/logo_psi_blast.jpg" alt="logo_psi_blast" /></TD><TD><a href="https://www.ebi.ac.uk/Tools/sss/psiblast/" target="_blank">PSI-BLAST</a><br>PSI-BLAST permet aux utilisateurs de créer et d’effectuer une recherche NCBI BLAST à l’aide d’une matrice de notation personnalisée, propre à chaque position, qui permet de retrouver des relations évolutives lointaines.</TD></TR>
					<TR><TD colspan=2><hr color=rgb(246,163,61) width="100%" align=left></TD></TR>
					<TR><TD align=center><img src="ImagesOutils/logo_emboss_dotmatcher.jpg" alt="logo_emboss_dotmatcher" /></TD><TD><a href="https://www.ebi.ac.uk/Tools/seqstats/emboss_dotmatcher/" target="_blank">EMBOSS Dotmatcher</a><br>EMBOSS dotmatcher dessine un diagramme à points de seuil à partir de deux séquences d'entrée.</TD></TR>
					<TR><TD colspan=2><hr color=rgb(246,163,61) width="100%" align=left></TD></TR>
					<TR><TD align=center><img src="ImagesOutils/logo_pdbefold.png" alt="logo_pdbefold" /></TD><TD><a href="http://www.ebi.ac.uk/msd-srv/ssm/" target="_blank">PDEeFold</a><br>Outil permettant la comparaison par pairs et multiple, par alignement 3D des structures protéiques, l'examination d'une structure protéique à des fins de similarité, ainsi que le téléchargement et la visualisation des structures les mieux superposées.</TD></TR>
					<TR><TD colspan=2><hr color=rgb(246,163,61) width="100%" align=left></TD></TR>
					
				</TABLE>
			</p>
		</section>
	</div>
  	<?php include("Footer.php"); ?>
  </body>
</html>
