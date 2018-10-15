#!/usr/bin/perl -W
#usage: ./formatProt.pl ../botrytis_cinerea/botrytis_cinerea__b05.10__1_proteins.fasta
$file1=$ARGV[0];

open(IN1,$file1);
$seq="";
$compteur=0;

#Fichier de sortie
open(OUT, ">../botrytis_cinerea/prot.csv");
while (<IN1>)
{
    chomp; 
    if (/^>/)
    {
    	#Ecrit la sequence de la proteine dans le fichiers si elle existe
    	print OUT ";\"$seq\";\"$idGene\"\n" unless($seq eq "");
    	#Split les informations
        ($id,$idGene,$reste)=split(/ \| /,$_);
        #Traite les informations
        $id=~s/>//;
        $reste=~s/Botrytis cinerea \(B05.10\) //;
        if ($reste =~ /\([0-9]* aa\)/){
            $nomProt=$`;
            $taille=$&;
            $nomProt=~ s/ $//;
            $taille=~s/\(//;
            $taille=~s/ aa\)//;
        }
        #Ecrit les informations selon le bon format
        print OUT "\"$id\";\"$nomProt\";$taille";
        $seq="";
        $compteur++;
    }
    else
    {
        $seq.=$_
    }
}
print OUT ";\"$seq\";\"$idGene\"";
close IN1;
print "Le nombre de proteine est de: $compteur\n";