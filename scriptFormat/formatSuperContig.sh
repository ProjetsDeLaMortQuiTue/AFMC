#!/bin/bash
grep -e \> ../botrytis_cinerea/botrytis_cinerea__b05.10__1_contigs.fasta|cut -d " " -f 10|sed -re "s/$/;1/" >../botrytis_cinerea/supercontig.csv

