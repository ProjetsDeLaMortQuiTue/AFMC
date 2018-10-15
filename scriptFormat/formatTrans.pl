#!/usr/bin/perl -W
#usage: ./formatTrans.pl ../botrytis_cinerea/botrytis_cinerea__b05.10__1_transcripts.fasta
$file1=$ARGV[0];

open(IN1,$file1);
$seq="";
$compteur=0;

#Fichier de sortie
open(OUT, ">../botrytis_cinerea/trans.csv");
while (<IN1>)
{
    chomp; 
    if (/^>/)
    {
    	#Ecrit la sequence du transcript dans le fichiers si elle existe
    	print OUT ";\"$seq\"\n" unless($seq eq "");
    	#Split les informations
        ($id,$reste)=split(/ \| /,$_);
        #Traite les informations
        $id=~s/>//;
        $reste=~s/Botrytis cinerea \(B05.10\) //;
        if ($reste =~ /\([0-9]* nt\)/){
            $nomProt=$`;
            $taille=$&;
            $annotation=$';
            $nomProt=~ s/ $//;
            $taille=~s/\(//;
            $taille=~s/ nt\)//;
            $annotation=~s/^ //;
        }
        #Ecrit les informations selon le bon format
        print OUT "\"$id\";\"$nomProt\";$taille;\"$annotation\"";
        $seq="";
        $compteur++;
    }
    else
    {
        $seq.=$_
    }
}
print OUT ";\"$seq\"";
close IN1;
print "Le nombre de transcript est de: $compteur\n";