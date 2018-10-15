#!/bin/bash
#Lance tout les scripts pour générer les formats csv pour Botrytis Cinerea
#Auteur: Coralie Rohmer 27/08/2018

./formatContig.pl ../botrytis_cinerea/botrytis_cinerea__b05.10__1_contigs.fasta
./formatGene.pl ../botrytis_cinerea/botrytis_cinerea__b05.10__1_genes.fasta ../botrytis_cinerea/botrytis_cinerea__b05.10__1_genome_summary_per_gene.txt
./formatPFAM.pl ../botrytis_cinerea/botrytis_cinerea__b05.10__1_pfam_to_genes.txt
./formatProt.pl ../botrytis_cinerea/botrytis_cinerea__b05.10__1_proteins.fasta
./formatTrans.pl ../botrytis_cinerea/botrytis_cinerea__b05.10__1_transcripts.fasta



