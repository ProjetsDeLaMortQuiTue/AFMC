#!/usr/bin/perl -W
#usage: ./formatGene.pl ../botrytis_cinerea/botrytis_cinerea__b05.10__1_genes.fasta ../botrytis_cinerea/botrytis_cinerea__b05.10__1_genome_summary_per_gene.txt

#Informations sur le gene
$file1=$ARGV[0];
#Information sur le genome
$file2=$ARGV[1];

undef %hashGene;
undef %listeGeneUniqueGene;#Liste des genes spécifiques au fichiers des genes
undef @listeGeneCommun;##Permet de garder les genes commun au deux fichier dans le bonne ordre l'ordre

open(IN1,$file1);
open(IN2,$file2);
$seq="";
$compteur=0;

#Récupére dans le hash les informations du fichier sur les gènes
while (<IN1>)
{
    chomp; 
    if (/^>/)
    {
    	#Stock la sequence du gene dans hashGene
    	$hashGene{$id}{"seq"}=$seq unless($seq eq "");
    	#Sépare l'identifiant du reste
        ($id,$reste)=split(/ \| /,$_);
        $id=~s/>//;
        #Ajoute le gene à la liste
        $listeGeneUniqueGene{$id}='';
        #Split le reste
        $reste=~s/Botrytis cinerea \(B05.10\) //;
        if ($reste =~ /\([0-9]* nt\)/){
        	$nomProtGene=$`;
        	$taille=$&;
        	$nomProtGene=~ s/ $//;
        	$taille=~s/\(//;
        	$taille=~s/ nt\)//;
        }

        #Stock le nom de la proteine associé au gene et la taille dans le hash
        $hashGene{$id}{"nomProtGene"}=$nomProtGene;
        $hashGene{$id}{"taille"}=$taille;

        $seq="";
        $compteur++;
    }
    else
    {
    	#Récupére la sequence
        $seq.=$_;
    }
}

#Ajoute la dernière sequence
$hashGene{$id}{"seq"}=$seq;
close IN1;
print "Le nombre de gene est de: $compteur\n";

#Récupére dans le hash les informations du fichier sur le genome
$erreurGeneGenome=0;
$erreurTaille=0;
$erreurNomProtGene=0;
undef @listErreurGeneGenome;
undef @listErreurTaille;
undef @listErreurNomProtGene;
while (<IN2>)
{
    chomp;
    #Si la ligne est un gene
    if (/^BC/)
    {
    	#split les informations
    	($id,$taille,$start,$stop,$brin,$nomProtGene,$chromosome)=split(/\t+/,$_);

    	#Si le gene existait déja dans le fichier précédent
    	if (exists $hashGene{$id})
    	{
    		#Ajoute le gene à la liste des gènes en commun
        	push(@listeGeneCommun,$id);

        	#Enleve l'identifiant dans liste afin d'avoir seulement les id spécifique au fichier gene
        	delete $listeGeneUniqueGene{$id};

    		#Stock les informations dans le hash
    		$hashGene{$id}{"start"}=$start;
    		$hashGene{$id}{"stop"}=$stop;
    		$hashGene{$id}{"brin"}=$brin;
    		$hashGene{$id}{"chromosome"}=$chromosome;

    		#Vérifie que la taille et le nom de la proteine correspondent 
    		if($hashGene{$id}{"taille"} ne $taille){
    			$erreurTaille++;
    			push(@listErreurTaille,$id);
    		}
    		if($hashGene{$id}{"nomProtGene"} ne $nomProtGene){
    			$erreurNomProtGene++;
    			push(@listErreurNomProtGene,$id);
    		}
    	}
    	#Sinon note l'erreur
    	else{$erreurGeneGenome++;push(@listErreurGeneGenome,$id);}
    }
}
close IN2;

#Vérifie qu'il n'y a pas eu d'erreur
if ($erreurGeneGenome != 0){
	print "Erreur: $erreurGeneGenome gene(s) du genome inconnu dans le fichier du gene\n";
	print "Les gènes sont: ";
	foreach $id (@listErreurGeneGenome){
		print "$id " ;
	}
	print "\n";
}
if ($erreurTaille != 0){
	print "Erreur: $erreurTaille taille(s) ne correspondent pas\n";
	print "Les gènes sont: ";
	foreach $id (@listErreurTaille){
		print "$id " ;
	}
	print "\n";
}
if ($erreurNomProtGene != 0){
	print "Erreur: $erreurNomProtGene nom(s) de proteines ne correspondent pas\n";
	print "Les gènes sont: ";
	foreach $id (@listErreurNomProtGene){
		print "$id " ;
	}
	print "\n";
}

#Affiche les identifiants spécifique au fichier gene
#print "Identifiants spécifiques au fichier gene: ";
#foreach $id (keys %listeGeneUniqueGene){
#	print "$id";
#}
#print "\n";

#Fichier de sortie
open(OUT, ">../botrytis_cinerea/gene.csv");


#Ecrit les informations dans le fichiers de sortie au bon format
foreach $id (@listeGeneCommun){
	print OUT "\"".$id."\";\"".
	$hashGene{$id}{"nomProtGene"}."\";".
	$hashGene{$id}{"taille"}.";".
	$hashGene{$id}{"start"}.";".
    $hashGene{$id}{"stop"}.";\"".
    $hashGene{$id}{"brin"}."\";".
    $hashGene{$id}{"chromosome"}.";\"".
	$hashGene{$id}{"seq"}."\";1\n";
}
