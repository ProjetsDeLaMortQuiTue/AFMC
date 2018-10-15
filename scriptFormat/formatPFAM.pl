#!/usr/bin/perl -W
#usage: ./formatPFAM.pl ../botrytis_cinerea/botrytis_cinerea__b05.10__1_pfam_to_genes.txt
$file1=$ARGV[0];

open(IN1,$file1);
$compteur=0;

#Fichier de sortie
open(OUT, ">../botrytis_cinerea/PFAM.csv");

while (<IN1>)
{
    chomp;
    if (!/^PROTEIN_NAME/)
    {
        ($nomProt,$idGene,$numSuperContig,$accPFAM,$nomPFAM,
            $descriptionPFAM,$debPFAM,$finPFAM,$taille,$score,
            $PFAM_EXPECTED)=split(/\t/,$_);

        $numSuperContig=~s/Botrytis cinerea supercontig //;
        $compteur++;

        #Ecrit au bon format
        print OUT "$compteur;\"$nomProt\";\"$accPFAM\";\"".
        "$nomPFAM\";\"$descriptionPFAM\";$debPFAM;$finPFAM;$taille;".
        "\"$score\";\"$PFAM_EXPECTED\";$numSuperContig;\"$idGene\"\n";
    }
}
close IN1;
print "Le nombre de PFAM est de: $compteur\n";