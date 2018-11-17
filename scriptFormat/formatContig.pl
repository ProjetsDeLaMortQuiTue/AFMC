#!/usr/bin/perl -W
#usage: ./formatContig.pl ../botrytis_cinerea/botrytis_cinerea__b05.10__1_contigs.fasta
$file1=$ARGV[0];

open(IN1,$file1);
$seq="";
$compteur=0;

#Fichier de sortie
open(OUT, ">../botrytis_cinerea/contig.csv");
while (<IN1>)
{
    chomp; 
    if (/^>/)
    {
    	#Ecrit la sequence du contig dans le fichiers si elle existe
    	print OUT ";\"$seq\";1;\n" unless($seq eq "");
    	#Split les informations
        ($id,$numCont,$numSuperCont,$positions,$nbN)=split(/ \| /,$_);
        #Traite les informations
        $id=~s/>//;
        $numCont=~s/CONTIG_//;
        $numSuperCont=~s/part of Botrytis cinerea supercontig //;
        ($deb,$fin)=split(/-/,$positions);
        $deb=~s/\[//;
        $fin=~s/\]//;
        $nbN=~s/nt//;
        $nbN=~s/ //g;
        #Ecrit les informations selon le bon format
        print OUT "\"$id\";$numCont;$numSuperCont;$deb;$fin;$nbN";
        $seq="";
        $compteur++;
    }
    else
    {
        $seq.=$_
    }
}
print OUT ";\"$seq\";1;";
close IN1;
close OUT;
print "Le nombre de contig est de: $compteur\n";
