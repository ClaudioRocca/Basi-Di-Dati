DROP DATABASE IF EXISTS ESQLDB;
CREATE DATABASE IF NOT EXISTS ESQLDB;

USE ESQLDB;

SET SQL_SAFE_UPDATES=0;

CREATE TABLE DOCENTE(
	MAIL VARCHAR(20),
	NOME VARCHAR(20),
	COGNOME VARCHAR(20),
	RECAPITO VARCHAR(20),
    DIPARTIMENTO VARCHAR(20) NOT NULL, 
    CORSO VARCHAR(20) NOT NULL,
    
    PRIMARY KEY (MAIL, NOME, COGNOME)
)
ENGINE=INNODB;

CREATE TABLE STUDENTE(
	MAIL VARCHAR(20),
	NOME VARCHAR(20),
	COGNOME VARCHAR(20),
	RECAPITO VARCHAR(20),
    ANNO_IMMATRICOLAZIONE CHAR(4) NOT NULL, 
    CODICE CHAR(16) NOT NULL,
    
	PRIMARY KEY (MAIL, NOME, COGNOME)
)
ENGINE=INNODB;

CREATE TABLE MESSAGGIO(
	TITOLO VARCHAR(20),
    TESTO VARCHAR(20) NOT NULL,
    DATA_INSERIMENTO DATE NOT NULL,
    MAIL_PROF VARCHAR(20) REFERENCES PROFESSORE.MAIL,
    NOME_PROF VARCHAR(20) REFERENCES PROFESSORE.NOME,
    COGNOME_PROF VARCHAR(20) REFERENCES PROFESSORE.COGNOME,
    MAIL_STUDENTE VARCHAR(20) REFERENCES STUDENTE.MAIL,
    NOME_STUDENTE VARCHAR(20) REFERENCES STUDENTE.NOME,
    COGNOME_STUDENTE VARCHAR(20) REFERENCES STUDENTE.COGNOME,
    TITOLO_TEST VARCHAR(20) REFERENCES TEST.TITOLO,
    
    PRIMARY KEY(TITOLO, MAIL_PROF, NOME_PROF, COGNOME_PROF, MAIL_STUDENTE, NOME_STUDENTE, COGNOME_STUDENTE, TITOLO_TEST)
)
ENGINE = INNODB;

CREATE TABLE TEST(
	TITOLO VARCHAR(20) NOT NULL,
    DATA_TEST DATE NOT NULL,
    FOTO VARCHAR(20),
    MAIL_PROF VARCHAR(20) REFERENCES PROFESSORE.MAIL,
    NOME_PROF VARCHAR(20) REFERENCES PROFESSORE.NOME,
    COGNOME_PROF VARCHAR(20) REFERENCES PROFESSORE.COGNOME,
    
    PRIMARY KEY(TITOLO, MAIL_PROF, NOME_PROF, COGNOME_PROF)
)
ENGINE = INNODB;

CREATE TABLE COMPLETAMENTO(
	STATO VARCHAR(20) NOT NULL,
    DATA_PRIMA_RISPOSTA DATE NOT NULL,
    DATA_ULTIMA_RISPOSTA DATE NOT NULL,
    MAIL_STUDENTE VARCHAR(20) REFERENCES STUDENTE.MAIL,
    NOME_STUDENTE VARCHAR(20) REFERENCES STUDENTE.NOME,
    COGNOME_STUDENTE VARCHAR(20) REFERENCES STUDENTE.COGNOME,
    TITOLO_TEST VARCHAR(20) REFERENCES TEST.TITOLO,
    
    PRIMARY KEY(MAIL_STUDENTE, NOME_STUDENTE, COGNOME_STUDENTE, TITOLO_TEST)
)
ENGINE = INNODB;

CREATE TABLE QUESITO_RISPOSTA_CHIUSA(

	ID INT AUTO_INCREMENT,
    LIVELLO VARCHAR(20) NOT NULL,
    DESCRIZIONE VARCHAR(20) NOT NULL,
    NUMERO_RISPOSTE INT NOT NULL,
    TITOLO_TEST VARCHAR(20) REFERENCES TEST.TITOLO,
    
    PRIMARY KEY(ID, TITOLO_TEST)
)
ENGINE = INNODB;

CREATE TABLE QUESITO_CODICE(
	ID INT AUTO_INCREMENT,
    LIVELLO VARCHAR(20) NOT NULL,
    DESCRIZIONE VARCHAR(20) NOT NULL,
    NUMERO_RISPOSTE INT NOT NULL,
    TITOLO_TEST VARCHAR(20) REFERENCES TEST.TITOLO,
    SKETCH VARCHAR(255),
    
    PRIMARY KEY(ID, TITOLO_TEST)
)
ENGINE = INNODB;

CREATE TABLE RISPOSTA(
	MAIL_STUDENTE VARCHAR(20) REFERENCES STUDENTE.MAIL,
    NOME_STUDENTE VARCHAR(20) REFERENCES STUDENTE.NOME,
    COGNOME_STUDENTE VARCHAR(20) REFERENCES STUDENTE.COGNOME,
    ID_QUESITO INT REFERENCES QUESITO.ID,
    
    PRIMARY KEY(MAIL_STUDENTE, NOME_STUDENTE, COGNOME_STUDENTE, ID_QUESITO)
)
ENGINE = INNODB;

CREATE TABLE TABELLA(
	NOME VARCHAR(20) NOT NULL,
    DATA_CREAZIONE DATE NOT NULL,
    NUMERO_RIGHE INT NOT NULL,
    MAIL_PROF VARCHAR(20) REFERENCES PROFESSORE.MAIL,
    NOME_PROF VARCHAR(20) REFERENCES PROFESSORE.NOME,
    COGNOME_PROF VARCHAR(20) REFERENCES PROFESSORE.COGNOME,	
    
    PRIMARY KEY(NOME, MAIL_PROF, NOME_PROF, COGNOME_PROF)
)
ENGINE = INNODB;

CREATE TABLE ATTRIBUTO(
	NOME VARCHAR(20) NOT NULL,
    TIPO VARCHAR(20) NOT NULL,
    NOME_TABELLA VARCHAR(20) NOT NULL,
    
    PRIMARY KEY(NOME, NOME_TABELLA)
)
ENGINE = INNODB;

DELIMITER $
CREATE PROCEDURE VISUALIZZAZIONE_TEST_DISPONIBILI()
	SELECT * FROM TEST;
$

CALL VISUALIZZAZIONE_TEST_DISPONIBILI;


DELIMITER $
CREATE PROCEDURE VISUALIZZAZIONE_QUESITI_TEST(IN TITOLO VARCHAR(20))
	SELECT ID, LIVELLO, DESCRIZIONE, NUMERO_RISPOSTE
    FROM QUESITO_RISPOSTA_CHIUSA 
	WHERE TITOLO = TITOLO_TEST
    UNION
    SELECT ID, LIVELLO, DESCRIZIONE, NUMERO_RISPOSTE
    FROM QUESITO_CODICE
    WHERE TITOLO = TITOLO_TEST
$










    
    
    



