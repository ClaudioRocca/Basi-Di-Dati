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
    PAZZWORD VARCHAR(20) NOT NULL,
    
    PRIMARY KEY (MAIL)
)
ENGINE=INNODB;

CREATE TABLE STUDENTE(
	MAIL VARCHAR(20),
	NOME VARCHAR(20),
	COGNOME VARCHAR(20),
	RECAPITO VARCHAR(20),
    ANNO_IMMATRICOLAZIONE CHAR(4) NOT NULL, 
    CODICE CHAR(16) NOT NULL,
    PAZZWORD VARCHAR(60) NOT NULL,
    
	PRIMARY KEY (MAIL)
)
ENGINE=INNODB;

CREATE TABLE TEST (
    TITOLO VARCHAR(20) NOT NULL,
    DATA_CREAZIONE DATE,
    FOTO VARCHAR(20),
    MAIL_DOCENTE VARCHAR(20) NOT NULL,
    VISUALIZZA_RISPOSTE BOOLEAN DEFAULT TRUE,
    PRIMARY KEY (TITOLO),
    FOREIGN KEY (MAIL_DOCENTE) REFERENCES DOCENTE(MAIL)
)
ENGINE=INNODB;

    
CREATE TABLE MESSAGGIO_DOCENTE(
    TITOLO_MESSAGGIO VARCHAR(20),
    TESTO VARCHAR(255),
    DATA_INSERIMENTO DATE,
	TITOLO_TEST VARCHAR(20),
    MITTENTE VARCHAR(20),
    PRIMARY KEY (TITOLO_MESSAGGIO, MITTENTE),
    FOREIGN KEY (TITOLO_TEST) REFERENCES TEST(TITOLO),
    FOREIGN KEY (MITTENTE) REFERENCES DOCENTE(MAIL)
  )
ENGINE=INNODB; 

CREATE TABLE MESSAGGIO_STUDENTE(
    TITOLO_MESSAGGIO VARCHAR(20),
    TESTO VARCHAR(255),
    DATA_INSERIMENTO DATE,
	TITOLO_TEST VARCHAR(20),
    MITTENTE VARCHAR(20),
    DESTINATARIO VARCHAR(20),
    PRIMARY KEY (TITOLO_MESSAGGIO, MITTENTE, DESTINATARIO),
    FOREIGN KEY (TITOLO_TEST) REFERENCES TEST(TITOLO),
    FOREIGN KEY (MITTENTE) REFERENCES STUDENTE(MAIL),
    FOREIGN KEY (DESTINATARIO) REFERENCES DOCENTE(MAIL)
    
  )
ENGINE=INNODB; 

CREATE TABLE QUESITO_RISPOSTA_CHIUSA (
    ID INT AUTO_INCREMENT NOT NULL,
    LIVELLO ENUM('BASSO', 'MEDIO', 'ALTO') NOT NULL,
    TITOLO_TEST VARCHAR(20) NOT NULL,
    DESCRIZ VARCHAR(60),
    NUM_RISPOSTE INT,
    
 
    FOREIGN KEY (TITOLO_TEST) REFERENCES TEST(TITOLO),
    PRIMARY KEY(ID)
)
ENGINE=INNODB;

CREATE TABLE QUESITO_CODICE (
    ID INT AUTO_INCREMENT NOT NULL,
    LIVELLO ENUM('BASSO', 'MEDIO', 'ALTO') NOT NULL,
    TITOLO_TEST VARCHAR(20) NOT NULL,
    DESCRIZ VARCHAR(60),
    NUM_RISP INT,
    
    FOREIGN KEY (TITOLO_TEST) REFERENCES TEST(TITOLO),
    PRIMARY KEY(ID)
)
ENGINE=INNODB;

CREATE TABLE SOLUZIONE(
	ID INT AUTO_INCREMENT NOT NULL,
    TESTO VARCHAR(255),
    
    FOREIGN KEY (ID) REFERENCES QUESITO_CODICE(ID),
    PRIMARY KEY(ID, TESTO)
)
ENGINE = INNODB;
    
CREATE TABLE TABELLA(
    NOME VARCHAR(20),
    DATA_CREAZIONE DATE,
    NUMRIGHE INT,
    MAIL_DOCENTE VARCHAR(20),
    PRIMARY KEY (NOME),
    FOREIGN KEY (MAIL_DOCENTE) REFERENCES DOCENTE(MAIL)
)
ENGINE=INNODB;  

CREATE TABLE ATTRIBUTO (
    NOME VARCHAR(20),
    TIPO VARCHAR(255) NOT NULL CHECK (TIPO LIKE 'varchar%' OR TIPO 	 IN ('INT', 'BOOLEAN', 'DATE', 'BLOB')),
    NOME_TABELLA VARCHAR(20),
    FOREIGN KEY (NOME_TABELLA) REFERENCES TABELLA(NOME),
    PRIMARY KEY (NOME, NOME_TABELLA)
    
)
ENGINE=INNODB;

CREATE TABLE OPZIONE(
	ID_OPZIONE INT AUTO_INCREMENT,
    TESTO VARCHAR(50) NOT NULL,
    ID_QUESITO INT REFERENCES QUESITO_RISPOSTA_CHIUSA.ID,
    
    PRIMARY KEY(ID_OPZIONE, ID_QUESITO)
    )
ENGINE=INNODB;

CREATE TABLE SKETCH(
	ID_SKETCH INT AUTO_INCREMENT,
    TESTO VARCHAR(255) NOT NULL,
    ID_TEST INT REFERENCES CODICE.ID,
    TITOLO_TEST VARCHAR(20) REFERENCES CODICE.TITOLO_TEST,
    MAIL_DOCENTE VARCHAR(20) REFERENCES CODICE.MAIL_DOCENTE,
    
    PRIMARY KEY(ID_SKETCH, ID_TEST, TITOLO_TEST, MAIL_DOCENTE)
)
ENGINE=INNODB;
    
CREATE TABLE RISPOSTA_QUESITO_CHIUSO (
    ESITO BOOLEAN,
    SCELTA INT,
	MAIL_STUDENTE VARCHAR(20),
    ID INT AUTO_INCREMENT,
    PRIMARY KEY (MAIL_STUDENTE, ID),
    FOREIGN KEY (MAIL_STUDENTE) REFERENCES STUDENTE(MAIL),
    FOREIGN KEY(SCELTA) REFERENCES OPZIONE(ID_OPZIONE),
    FOREIGN KEY (ID) REFERENCES QUESITO_RISPOSTA_CHIUSA(ID)
)
ENGINE=INNODB;

CREATE TABLE RISPOSTA_QUESITO_CODICE(
    ESITO BOOLEAN,
    TESTO VARCHAR(255),
	MAIL_STUDENTE VARCHAR(20),
    ID INT AUTO_INCREMENT,
    PRIMARY KEY (MAIL_STUDENTE, ID),
    FOREIGN KEY (MAIL_STUDENTE) REFERENCES STUDENTE(MAIL),
    FOREIGN KEY (ID) REFERENCES QUESITO_CODICE(ID)
)
ENGINE=INNODB;


DELIMITER $
CREATE TABLE COMPLETAMENTO (
    DATA_PRIMA_RISPOSTA DATE,
    DATA_ULTIMA_RISPOSTA DATE,
    STATO ENUM('APERTO', 'IN_COMPLETAMENTO', 'CONCLUSO'),
    MAIL_STUDENTE VARCHAR(20),
	TITOLO_TEST VARCHAR(20) NOT NULL,
    PRIMARY KEY (MAIL_STUDENTE, TITOLO_TEST),
    FOREIGN KEY (MAIL_STUDENTE) REFERENCES STUDENTE(MAIL),
    FOREIGN KEY (TITOLO_TEST) REFERENCES TEST(TITOLO)
)
ENGINE=INNODB;
$

DELIMITER $
CREATE TABLE VINCOLO_INTEGRITA (
	NOME_ATTRIBUTO VARCHAR(20),
	ATTRIBUTO_RIFERITO VARCHAR(20),
    PRIMARY KEY(NOME_ATTRIBUTO, ATTRIBUTO_RIFERITO),
    FOREIGN KEY(NOME_ATTRIBUTO) REFERENCES ATTRIBUTO(NOME),
    FOREIGN KEY(ATTRIBUTO_RIFERITO) REFERENCES ATTRIBUTO(NOME)
)
ENGINE=INNODB;
$

DELIMITER $
CREATE TABLE APPARTENENZA_QUESITO_CHIUSO(
	ID INT AUTO_INCREMENT NOT NULL,
    TITOLO_TEST VARCHAR(20) NOT NULL,
    NOME_TABELLA VARCHAR(20),
    
    PRIMARY KEY(ID, TITOLO_TEST, NOME_TABELLA),
    
    FOREIGN KEY(ID) REFERENCES QUESITO_RISPOSTA_CHIUSA(ID),
    FOREIGN KEY(TITOLO_TEST) REFERENCES QUESITO_RISPOSTA_CHIUSA(TITOLO_TEST),
    FOREIGN KEY (NOME_TABELLA)  REFERENCES TABELLA(NOME)
)
ENGINE = INNODB;
$

DELIMITER $
CREATE TABLE APPARTENENZA_QUESITO_CODICE(
	ID INT AUTO_INCREMENT NOT NULL,
    TITOLO_TEST VARCHAR(20) NOT NULL,
    NOME_TABELLA VARCHAR(20),
    
    PRIMARY KEY(ID, TITOLO_TEST, NOME_TABELLA),
    
    FOREIGN KEY(ID) REFERENCES QUESITO_CODICE(ID),
    FOREIGN KEY(TITOLO_TEST) REFERENCES QUESITO_CODICE(TITOLO_TEST),
    FOREIGN KEY (NOME_TABELLA)  REFERENCES TABELLA(NOME)
)
ENGINE = INNODB;
$

DELIMITER $
CREATE VIEW CLASSIFICA_STUDENTI_TEST_COMPLETATI AS
SELECT STUDENTE.CODICE, COUNT(STATO) AS NUMERO_TEST_COMPLETATI
FROM STUDENTE
JOIN COMPLETAMENTO ON MAIL = MAIL_STUDENTE
WHERE STATO = 'CONCLUSO'
GROUP BY CODICE
ORDER BY NUMERO_TEST_COMPLETATI DESC;
$


DELIMITER $
CREATE VIEW CLASSIFICA_STUDENTI_QUESITI_CORRETTI AS
SELECT CODICE, COUNT(RISPOSTA_QUESITO_CODICE.ESITO)  + COUNT(RISPOSTA_QUESITO_CHIUSO.ESITO) AS QUESITI_CORRETTI
FROM STUDENTE, RISPOSTA_QUESITO_CODICE, RISPOSTA_QUESITO_CHIUSO
WHERE MAIL =  RISPOSTA_QUESITO_CHIUSO.MAIL_STUDENTE AND RISPOSTA_QUESITO_CHIUSO.MAIL_STUDENTE = RISPOSTA_QUESITO_CODICE.MAIL_STUDENTE AND (RISPOSTA_QUESITO_CODICE.ESITO = TRUE OR RISPOSTA_QUESITO_CHIUSO.ESITO = TRUE)
GROUP BY CODICE
ORDER BY CODICE DESC;
$

-- DELIMITER $
CREATE VIEW CLASSIFICA_STUDENTI_QUESITI_INSERITI AS
SELECT CODICE, COUNT(RISPOSTA_QUESITO_CODICE.ESITO)  + COUNT(RISPOSTA_QUESITO_CHIUSO.ESITO) AS QUESITI_CORRETTI
FROM STUDENTE, RISPOSTA_QUESITO_CODICE, RISPOSTA_QUESITO_CHIUSO
WHERE MAIL =  RISPOSTA_QUESITO_CHIUSO.MAIL_STUDENTE AND RISPOSTA_QUESITO_CHIUSO.MAIL_STUDENTE = RISPOSTA_QUESITO_CODICE.MAIL_STUDENTE
GROUP BY CODICE
ORDER BY CODICE DESC;
-- $

DELIMITER $
CREATE VIEW QUESITI_COMPLETATI_MAGGIORMENTE AS
SELECT RISPOSTA_QUESITO_CODICE.ID, COUNT(RISPOSTA_QUESITO_CODICE.ID)  + COUNT(RISPOSTA_QUESITO_CHIUSO.ID) AS NUMERO_RISPOSTE
FROM RISPOSTA_QUESITO_CODICE, RISPOSTA_QUESITO_CHIUSO
WHERE RISPOSTA_QUESITO_CODICE.ID = RISPOSTA_QUESITO_CHIUSO.ID
GROUP BY RISPOSTA_QUESITO_CODICE.ID
ORDER BY NUMERO_RISPOSTE DESC;
$

DELIMITER $
CREATE PROCEDURE VISUALIZZAZIONE_TEST_DISPONIBILI()
	SELECT TITOLO, DATA_CREAZIONE, VISUALIZZA_RISPOSTE FROM TEST;
$

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

DELIMITER $
CREATE PROCEDURE INSERIMENTO_NUOVO_TEST(IN TITOLO VARCHAR(20), IN DATA_CREAZIONE DATE, FOTO BLOB, MAIL_DOCENTE VARCHAR(20), VISUALIZZA_RISPOSTE BOOLEAN)

	INSERT INTO TEST(TITOLO, DATA_CREAZIONE, FOTO, MAIL_DOCENTE, VISUALIZZA_RISPOSTE) VALUES(TITOLO, DATA_CREAZIONE, FOTO, MAIL_DOCENTE, VISUALIZZA_RISPOSTE)
$


DELIMITER $
CREATE PROCEDURE INVIO_MESSAGGIO_DOCENTE(IN TITOLO_MESSAGGIO VARCHAR(20), TESTO VARCHAR(255), DATA_INSERIMENTO DATE, TITOLO_TEST VARCHAR(20), MITTENTE VARCHAR(20))

	INSERT INTO MESSAGGIO_DOCENTE(TITOLO_MESSAGGIO, TESTO, DATA_INSERIMENTO, TITOLO_TEST, MITTENTE) VALUES(TITOLO_MESSAGGIO, TESTO, DATA_INSERIMENTO, TITOLO_TEST, MITTENTE)
$

DELIMITER $
CREATE PROCEDURE INVIO_MESSAGGIO_STUDENTE(IN TITOLO_MESSAGGIO VARCHAR(20), TESTO VARCHAR(255), DATA_INSERIMENTO DATE, TITOLO_TEST VARCHAR(20), MITTENTE VARCHAR(20), DESTINATARIO VARCHAR(20))

	INSERT INTO MESSAGGIO_STUDENTE(TITOLO_MESSAGGIO, TESTO, DATA_INSERIMENTO, TITOLO_TEST, MITTENTE, DESTINATARIO) VALUES(TITOLO_MESSAGGIO, TESTO, DATA_INSERIMENTO, TITOLO_TEST, MITTENTE, DESTINATARIO)
$

DELIMITER $
CREATE PROCEDURE CAMBIAMENTO_VISUALIZZAZIONE_RISPOSTE_TEST(IN TITOLO_TEST VARCHAR(20), MAIL_DOCENTE VARCHAR(20), OPZIONE_SCELTA BOOLEAN)

	UPDATE TEST
    SET VISUALIZZA_RISPOSTE = OPZIONE_SCELTA
    WHERE TEST.TITOLO_TEST = TITOLO_TEST AND TEST.MAIL_DOCENTE = MAIL_DOCENTE
$

DELIMITER $
CREATE PROCEDURE INSERIMENTO_NUOVO_STUDENTE(MAIL VARCHAR(20), NOME VARCHAR(20), COGNOME VARCHAR(20), RECAPITO VARCHAR(20), ANNO_IMMATRICOLAZIONE CHAR(4), CODICE CHAR(16), 
PAZZWORD VARCHAR(60) )

	INSERT INTO STUDENTE(MAIL, NOME, COGNOME, RECAPITO, ANNO_IMMATRICOLAZIONE, CODICE, PAZZWORD) VALUES(MAIL, NOME, COGNOME, RECAPITO, ANNO_IMMATRICOLAZIONE, CODICE, PAZZWORD)
$ -- NON USATA PER ORA !*!*!*!*!*!***!!*

INSERT INTO DOCENTE(MAIL, NOME, COGNOME, RECAPITO, DIPARTIMENTO, CORSO, PAZZWORD) VALUES ('Mario.rossi@uni.it','Mario', 'Rossi', '12345', 'Scienze', 'Database', 'ZioPera');

INSERT INTO STUDENTE(MAIL, NOME, COGNOME, RECAPITO, ANNO_IMMATRICOLAZIONE, CODICE, PAZZWORD) VALUES ('Luca.neri@uni.it', 'Luca', 'Neri', '23456', '2024', '1234123412341234', 'Password');
INSERT INTO STUDENTE(MAIL, NOME, COGNOME, RECAPITO, ANNO_IMMATRICOLAZIONE, CODICE, PAZZWORD) VALUES ('Marco.bianchi@uni.it', 'Marco', 'Bianchi', '00000', '2024', '0123012301230123', 'Password');

INSERT INTO TEST(TITOLO, DATA_CREAZIONE, FOTO, MAIL_DOCENTE, VISUALIZZA_RISPOSTE) VALUES('Test di prova', '2024/02/29', 'Foto di prova', 'Mario.rossi@uni.it', true);
INSERT INTO TEST(TITOLO, DATA_CREAZIONE, FOTO, MAIL_DOCENTE, VISUALIZZA_RISPOSTE) VALUES('Test di prova 2', '2024/03/03', 'Foto di prova', 'Mario.rossi@uni.it', true);

INSERT INTO COMPLETAMENTO(DATA_PRIMA_RISPOSTA, DATA_ULTIMA_RISPOSTA, STATO, MAIL_STUDENTE, TITOLO_TEST)
VALUES('2024/03/04', '2024/03/04', 'CONCLUSO', 'Luca.neri@uni.it', 'Test di prova');

INSERT INTO COMPLETAMENTO(DATA_PRIMA_RISPOSTA, DATA_ULTIMA_RISPOSTA, STATO, MAIL_STUDENTE, TITOLO_TEST)
VALUES('2024/03/04', '2024/03/04', 'CONCLUSO', 'Luca.neri@uni.it', 'Test di prova 2');

INSERT INTO COMPLETAMENTO(DATA_PRIMA_RISPOSTA, DATA_ULTIMA_RISPOSTA, STATO, MAIL_STUDENTE, TITOLO_TEST)
VALUES('2024/03/04', '2024/03/04', 'CONCLUSO', 'Marco.bianchi@uni.it', 'Test di prova');


INSERT INTO QUESITO_RISPOSTA_CHIUSA(LIVELLO, TITOLO_TEST, DESCRIZ, NUM_RISPOSTE) VALUES ('BASSO', "Test di prova", "aaa", 3);
INSERT INTO OPZIONE(TESTO, ID_QUESITO) VALUES ("aaa", 1);
INSERT INTO RISPOSTA_QUESITO_CHIUSO(ESITO, SCELTA, MAIL_STUDENTE) VALUES(TRUE, 1, "Luca.neri@uni.it");

