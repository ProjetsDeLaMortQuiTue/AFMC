<!DOCTYPE html>
<!-- Page du tuto pour les expression régulière -->

<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../AFMC.css"> 
	<title>AFMC</title>
  </head>
  
  <?php session_start();$_SESSION['currentPage']="search"; ?>
  
  <body>
	<?php include("../Title2.php"); ?>
	<?php include("../Menu.php"); ?>
	
	<!-- Milieu de page -->
	<div id="conteneur">
		<!-- Contenu de la page -->
		<section>
			<h1>Expression régulière</h1>
			Les expressions régulière permettent d'expliciter un motif avec des caractères particuliers: <br>
			<table BORDER="1" style="text-align:center">
			  <thead>
			    <tr>
			    	<th>Caractère</th><th>Motif</th><th>Exemple motif</th><th>Les séquences qui</th>
			    </tr>
			  </thead>
			  <tbody>
			  	 <tr>
			  	 	<td>A</td>
			  	 	<td>Un A dans la sequence</td>
			  	 	<td><red>ACGTTGA</red></td>
			  	 	<td>possèdent le motif <red>ACGTTGA</red></td>
			  	 </tr>
			    <tr>
			    	<td>^</td><td>Début de la séquence</td><td>^<red>ATG</red></td><td>commencent par <red>ATG</red></td>
			    </tr>
			    <tr>
			    	<td>$</td>
			    	<td>Fin de la séquence</td>
			    	<td><red>TAG</red>$</td>
			    	<td>se terminent par <red>TAG</red></td>
			    </tr>
			    <tr>
			    	<td>A|C</td>
			    	<td>Contiens A ou C</td>
			    	<td><vert>A</vert>(<red>CG</red>|<bleu>TA</bleu>)<vert>A</vert></td>
			    	<td>possèdent le motif <vert>A</vert><red>CG</red><vert>A</vert> 
			    			   ou le motif <vert>A</vert><bleu>TA</bleu><vert>A</vert></td>
			    </tr>
			    <tr>
			    	<td>.</td>
			    	<td>N'importe quel lettre</td>
			    	<td><vert>A</vert><red>.</red><vert>A</vert></td>
			    	<td>possèdent les motifs <vert>A</vert><red>A</red><vert>A</vert>,
			    							 <vert>A</vert><red>T</red><vert>A</vert>,
			    							 <vert>A</vert><red>G</red><vert>A</vert> 
			    							 ou <vert>A</vert><red>C</red><vert>A</vert></td>
			    </tr>
			    <tr>
			    	<td>A{5}</td>
			    	<td>Exactement cinq A</td>
			    	<td><vert>A</vert>(<red>CT</red>){2}<vert>A</vert></td>
			    	<td>possèdent le motif <vert>A</vert><red>CTCT</red><vert>A</vert>,</td>
			    </tr>
			    <tr>
			    	<td>A*</td>
			    	<td>Pas ou plusieur A</td>
			    	<td><vert>A</vert>(<red>CT</red>)*<vert>A</vert></td>
			    	<td>possèdent les motifs <vert>A</vert><vert>A</vert>
			    							 <vert>A</vert><red>CT</red><vert>A</vert>
											 <vert>A</vert><red>CTCT</red><vert>A</vert>
											 <vert>A</vert><red>CTCTCT</red><vert>A</vert>
											 <vert>A</vert><red>CTCTCTCT</red><vert>A</vert>...</td>

			    </tr>
			    <tr>
			    	<td>A+</td>
			    	<td>Un ou plusieur A</td>
			    	<td><vert>A</vert>(<red>CT</red>)+<vert>A</vert></td>
			    	<td>possèdent les motifs <vert>A</vert><red>CT</red><vert>A</vert>
			    							 <vert>A</vert><red>CTCT</red><vert>A</vert>
			    						     <vert>A</vert><red>CTCTCT</red><vert>A</vert>
			    							 <vert>A</vert><red>CTCTCTCT</red><vert>A</vert>...</td>
			    </tr>
			    <tr>
			    	<td>A?</td>
			    	<td>Pas ou un seul A</td>
			    	<td><vert>A</vert>(<red>CT</red>)?<vert>A</vert></td>
			    	<td>possèdent les motifs <vert>A</vert><vert>A</vert>
			    					      ou <vert>A</vert><red>CT</red><vert>A</vert></td>
			    </tr>
			  </tbody>
			</table><br>
			Ces caractères sont tous combinable:<br> Exemple:<br><br>
			<table>
			    <TR>
			    	<TD>Motif:</TD>
			    	<TD><red>^ATG</red><vert>.*<violet>(AAAA|TTTT)+</violet></vert><orange>(G{2}|(A|T){7})?</orange><bleu>TAG$</bleu></TD>
			    </TR>
			    <TR>
			    	<TD>Sequences:</TD>
			    	<TD><red>ATG</red><vert>ATCGCGTAGCAGTAGCAAACGT</vert><violet>AAAAAAAAATTTTAAAATTTT</violet><orange>ATATTAT</orange><bleu>TAG</bleu></TD>
			    </TR>
			    <TR>
			    	<TD></TD><TD><red>ATG</red><vert>TGCATCCGCCCTGAAATCGTTCGATGC</vert><violet>TTTT</violet><orange>GG</orange><bleu>TAG</bleu></TD>
			    </TR>
			    <TR>
			    	<TD></TD>
			    	<TD><red>ATG</red><vert>TGCATGGAC</vert><violet>AAAAAAAAAAAATTTTAAAATTTTTTTT</violet><bleu>TAG</bleu></TD>
			    </TR>

			</table>
        </section>
	</div>
	
	<?php include("../Footer.php"); ?>
	
  </body>
</html>
