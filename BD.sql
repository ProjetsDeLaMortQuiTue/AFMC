DROP TABLE IF EXISTS KEGG;
DROP TABLE IF EXISTS PathwayReaction;
DROP TABLE IF EXISTS Structure;
DROP TABLE IF EXISTS Phylogenie;
DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Transcript;
DROP TABLE IF EXISTS Proteine;
DROP TABLE IF EXISTS PFAM;
DROP TABLE IF EXISTS Gene;
DROP TABLE IF EXISTS Contigue;
DROP TABLE IF EXISTS Espece;

CREATE TABLE IF NOT EXISTS Espece (
	idEsp SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
	nomEsp VARCHAR(100) NOT NULL,
	nbContigs SMALLINT UNSIGNED,
	nbGenes SMALLINT UNSIGNED,
	nbPFAM SMALLINT UNSIGNED,
	nbProts SMALLINT UNSIGNED,
	nbTrans SMALLINT UNSIGNED,
	pourcCodant TINYINT UNSIGNED,
	soucheEsp VARCHAR(10),
	nomImageEspece VARCHAR(100) NOT NULL,
	PRIMARY KEY (idEsp)
)
ENGINE=INNODB;

INSERT INTO Espece 
VALUES (1,'Botrytis Cinerea',4534,16448,42635,16448,16448,42,'B05.10','botrytis_cinerea.jpg');


CREATE TABLE IF NOT EXISTS Contigue (
	idContig CHAR(12) NOT NULL,
	numContig SMALLINT,
	numSuperContig DECIMAL(5,3),
	debContig INT,
	finContig INT,
	tailleContig INT,
	seqContig TEXT(65536),
	idEsp SMALLINT UNSIGNED NOT NULL,
	PRIMARY KEY (idContig),
	CONSTRAINT fk_idEspContigue
        FOREIGN KEY (idEsp)
        REFERENCES Espece(idEsp)
)
ENGINE=INNODB;

LOAD DATA LOCAL INFILE '/opt/lampp/htdocs/AFMC/botrytis_cinerea/contig.csv'
INTO TABLE Contigue
FIELDS TERMINATED BY ';' ENCLOSED BY '"'
LINES TERMINATED BY '\n';

CREATE TABLE IF NOT EXISTS Gene (
	idGene CHAR(10) NOT NULL,
	nomProtGene VARCHAR(100),
	tailleGene INT,
	debGene INT,
	finGene INT,
	brin CHAR(1),
	numChromosome INT UNSIGNED,
	seqGene TEXT,
	nomFichierFasta VARCHAR(100) NOT NULL,
	idEsp SMALLINT UNSIGNED NOT NULL,
	PRIMARY KEY (idGene),
	CONSTRAINT fk_idEspGene
        FOREIGN KEY (idEsp)
        REFERENCES Espece(idEsp)
)
ENGINE=INNODB;

LOAD DATA LOCAL INFILE '/opt/lampp/htdocs/AFMC/botrytis_cinerea/gene.csv'
INTO TABLE Gene
FIELDS TERMINATED BY ';' ENCLOSED BY '"'
LINES TERMINATED BY '\n';


CREATE TABLE IF NOT EXISTS PFAM (
	idPFAM SMALLINT UNSIGNED AUTO_INCREMENT, 
	nomProt VARCHAR(100),
	accPFAM CHAR(10),
	nomPFAM VARCHAR(100),
	description TEXT,
	startPFAM INT UNSIGNED,
	stopPFAM INT UNSIGNED,
	taillePFAM INT UNSIGNED,
	score VARCHAR(100),
	PFAMattendu VARCHAR(100),
	numSuperContig DECIMAL(5,3),
	idGene CHAR(10) NOT NULL,

	PRIMARY KEY (idPFAM),

	CONSTRAINT fk_idGenePFAM
        FOREIGN KEY (idGene)
        REFERENCES Gene(idGene)
)
ENGINE=INNODB;

LOAD DATA LOCAL INFILE '/opt/lampp/htdocs/AFMC/botrytis_cinerea/PFAM.csv'
INTO TABLE PFAM
FIELDS TERMINATED BY ';' ENCLOSED BY '"'
LINES TERMINATED BY '\n';

CREATE TABLE IF NOT EXISTS Proteine (
	idProt CHAR(10), 
	nomProt VARCHAR(100),
	tailleProt INT UNSIGNED,
	seqProt TEXT,
	idGene CHAR(10) NOT NULL,

	PRIMARY KEY (idProt),
	CONSTRAINT fk_idGeneProt
        FOREIGN KEY (idGene)
        REFERENCES Gene(idGene)
)
ENGINE=INNODB;

LOAD DATA LOCAL INFILE '/opt/lampp/htdocs/AFMC/botrytis_cinerea/prot.csv'
INTO TABLE Proteine
FIELDS TERMINATED BY ';' ENCLOSED BY '"'
LINES TERMINATED BY '\n';

CREATE TABLE IF NOT EXISTS Transcript (
	idTrans CHAR(10), 
	nomTrans VARCHAR(100),
	tailleTrans INT,
	annotation TEXT,
	seqTrans TEXT,
	PRIMARY KEY (idTrans),
	CONSTRAINT fk_idProtTrans
        FOREIGN KEY (idTrans)
        REFERENCES Proteine(idProt)
)
ENGINE=INNODB;

LOAD DATA LOCAL INFILE '/opt/lampp/htdocs/AFMC/botrytis_cinerea/trans.csv'
INTO TABLE Transcript
FIELDS TERMINATED BY ';' ENCLOSED BY '"'
LINES TERMINATED BY '\n';

CREATE TABLE IF NOT EXISTS User (
	idUser INT UNSIGNED NOT NULL AUTO_INCREMENT,
	alias VARCHAR(100),
	mdp VARCHAR(100) not null,
	email VARCHAR(100) not null,
	civilite varchar(4),
	nom VARCHAR(50),
	prenom VARCHAR(50),
	nomLabo VARCHAR(100),
	dateDeCreation DATE,
	dateDerniereCo DATETIME,

	PRIMARY KEY (idUser)
)
ENGINE=INNODB;

INSERT INTO User
VALUES (1,'MeilleurWebmaster','topmoumoute','coralie.rohmer@hotmail.fr','Mlle','Rohmer','Coralie','CD Projekt RED','2018-09-15','2018-09-16 20:00:00'),
(2,'RootSuprem','coralieestlameilleur','marine.aglave@u-psud.fr','Mme','Aglave','Marine','Institut Pasteur','2018-09-15','2018-09-16 20:00:00'),
(3,'Nirvana','chatsupersympa','coralie.rohmer@u-psud.fr','M.','Monsieur','leChat','Institut Félin du Siam','2018-09-15','2018-09-16 20:00:00');

CREATE TABLE IF NOT EXISTS Phylogenie(
	idGene CHAR(10) NOT NULL,
	idUser int unsigned,
	fichier VARCHAR(100),
	autreDonnee TEXT,
	annotation TEXT,

	PRIMARY KEY (idGene,idUser),
	CONSTRAINT fk_idGenePhylo
        FOREIGN KEY (idGene)
        REFERENCES Gene(idGene),
	CONSTRAINT fk_idUserPhylo
        FOREIGN KEY (idUser)
        REFERENCES User(idUser)
)
ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS Structure(
	idProt CHAR(10),
	idUser int unsigned,
	fichier VARCHAR(100),
	autreDonnee TEXT,
	annotation TEXT,

	PRIMARY KEY (idProt,idUser),
	CONSTRAINT fk_idProtStruc
        FOREIGN KEY (idProt)
        REFERENCES Proteine(idProt),
	CONSTRAINT fk_idUserStruc
        FOREIGN KEY (idUser)
        REFERENCES User(idUser)
)
ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS PathwayReaction(
	idProt CHAR(10),
	idUser int unsigned,
	idPathway VARCHAR(50),
	autreDonnee TEXT,
	annotation TEXT,

	PRIMARY KEY (idProt,idUser),
	CONSTRAINT fk_idProtPath
        FOREIGN KEY (idProt)
        REFERENCES Proteine(idProt),
	CONSTRAINT fk_idUserPath
        FOREIGN KEY (idUser)
        REFERENCES User(idUser)
)
ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS KEGG(
	idProt CHAR(10),
	idUser int unsigned,
	codeProt VARCHAR(100),
	autreDonnee TEXT,
	annotation TEXT,

	PRIMARY KEY (idProt,idUser),
	CONSTRAINT fk_idProtKEGG
        FOREIGN KEY (idProt)
        REFERENCES Proteine(idProt),
	CONSTRAINT fk_idUserKEGG
        FOREIGN KEY (idUser)
        REFERENCES User(idUser)
)
ENGINE=INNODB;

DROP TABLE Structure;
CREATE TABLE IF NOT EXISTS Structure(
  idProt CHAR(10),
  idUser int unsigned,
  nomFichier VARCHAR(100),
  annotation TEXT,

  PRIMARY KEY (idProt,idUser),
  CONSTRAINT fk_idProtStruc
        FOREIGN KEY (idProt)
        REFERENCES Proteine(idProt),
  CONSTRAINT fk_idUserStruc
        FOREIGN KEY (idUser)
        REFERENCES User(idUser)
)
ENGINE=INNODB;
INSERT INTO Structure (idProt,idUser,nomFichier,annotation) VALUES ('BC1T_00004',1,'Structure/BC1T_00004/Struc_BC1T_00004_1.pdb','Easy');

DROP TABLE Phylogenie;
CREATE TABLE IF NOT EXISTS Phylogenie(
  idGene CHAR(10) NOT NULL,
  idUser int unsigned,
  nomFichierPhylo VARCHAR(100) NOT NULL,
  nomFichierAlignement VARCHAR(100) NOT NULL,
  outil VARCHAR(100) NOT NULL,
  annotation TEXT,

  PRIMARY KEY (idGene,idUser),
  CONSTRAINT fk_idGenePhylo
        FOREIGN KEY (idGene)
        REFERENCES Gene(idGene),
  CONSTRAINT fk_idUserPhylo
        FOREIGN KEY (idUser)
        REFERENCES User(idUser)
)
ENGINE=INNODB;
INSERT INTO Phylogenie (idGene,idUser,nomFichierPhylo,nomFichierAlignement,outil,annotation) VALUES ('BC1G_00001',1,'Phylogenie/BC1G_00001/Tree_BC1G_00001_1.tree','Phylogenie/BC1G_00001/Ali_BC1G_00001_1.fasta','Mon oeil','Rien'),('BC1G_00001',3,'Phylogenie/BC1G_00001/Tree_BC1G_00001_3.tree','Phylogenie/BC1G_00001/Ali_BC1G_00001_3.fasta','Phylogeny.fr','Cest chiant à faire');








