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
    
	PRIMARY KEY (MAIL)
)
ENGINE=INNODB;

CREATE TABLE TEST (
    TITOLO VARCHAR(20) NOT NULL,
    DATA_CREAZIONE DATE,
    FOTO BLOB,
    MAIL_DOCENTE VARCHAR(20) NOT NULL,
    VISUALIZZA_RISPOSTE BOOLEAN DEFAULT TRUE,
    PRIMARY KEY (TITOLO, MAIL_DOCENTE),
    FOREIGN KEY (MAIL_DOCENTE) REFERENCES DOCENTE(MAIL)
)
ENGINE=INNODB;

    
CREATE TABLE MESSAGGIO (
    TITOLO_MESSAGGIO VARCHAR(20),
    TESTO VARCHAR(255),
    DATA_INSERIMENTO DATE,
	TITOLO_TEST VARCHAR(20),
    MAIL_DOCENTE VARCHAR(20),
    MAIL_STUDENTE VARCHAR(20),
    PRIMARY KEY (TITOLO_MESSAGGIO, MAIL_DOCENTE, MAIL_STUDENTE),
    FOREIGN KEY (TITOLO_TEST) REFERENCES TEST(TITOLO),
    FOREIGN KEY (MAIL_DOCENTE) REFERENCES DOCENTE(MAIL),
    FOREIGN KEY (MAIL_STUDENTE) REFERENCES STUDENTE(MAIL)
  )
ENGINE=INNODB; 


CREATE TABLE QUESITO_RISPOSTA_CHIUSA (
    ID INT NOT NULL,
    LIVELLO ENUM('BASSO', 'MEDIO', 'ALTO') NOT NULL,
    DESCRIZ VARCHAR(20),
    NUM_RISP INT,
    TITOLO_TEST VARCHAR(20) NOT NULL,
    MAIL_DOCENTE VARCHAR(20) REFERENCES TEST.MAIL_DOCENTE,
    PRIMARY KEY (ID, TITOLO_TEST, MAIL_DOCENTE),
    FOREIGN KEY (TITOLO_TEST) REFERENCES TEST(TITOLO)
)
ENGINE=INNODB;

CREATE TABLE QUESITO_CODICE (
    ID INT NOT NULL,
    LIVELLO ENUM('BASSO', 'MEDIO', 'ALTO') NOT NULL,
    DESCRIZ VARCHAR(20),
    NUM_RISP INT,
    TITOLO_TEST VARCHAR(20) NOT NULL,
    MAIL_DOCENTE VARCHAR(20) REFERENCES TEST.MAIL_DOCENTE,
    PRIMARY KEY (ID, TITOLO_TEST, MAIL_DOCENTE),
    FOREIGN KEY (TITOLO_TEST) REFERENCES TEST(TITOLO)
)
ENGINE=INNODB;

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
    TIPO ENUM('VARCHAR', 'INT', 'BOOLEAN', 'DATE', 'BLOB'),
    NOME_TABELLA VARCHAR(20),
    FOREIGN KEY (NOME_TABELLA) REFERENCES TABELLA(NOME),
    PRIMARY KEY (NOME, NOME_TABELLA)
    
)
ENGINE=INNODB;

CREATE TABLE OPZIONE(
	ID_OPZIONE INT AUTO_INCREMENT,
    TESTO VARCHAR(50) NOT NULL,
    ID_TEST INT REFERENCES RISPOSTA_CHIUSA.ID,
    TITOLO_TEST VARCHAR(20) REFERENCES RISPOSTA_CHIUSA.TITOLO_TEST,
    MAIL_DOCENTE VARCHAR(20) REFERENCES RISPOSTA_CHIUSA.MAIL_DOCENTE,
    
    PRIMARY KEY(ID_OPZIONE, ID_TEST, TITOLO_TEST, MAIL_DOCENTE)
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
    
CREATE TABLE RISPOSTA (
    ESITO BOOLEAN,
    TESTO VARCHAR(255),
	MAIL_STUDENTE VARCHAR(20),
    ID_QUESITO INT,
    PRIMARY KEY (MAIL_STUDENTE, ID_QUESITO),
    FOREIGN KEY (MAIL_STUDENTE) REFERENCES STUDENTE(MAIL),
    FOREIGN KEY (ID_QUESITO) REFERENCES QUESITO_RISPOSTA_CHIUSA(ID)
    -- FOREIGN KEY (ID_QUESITO) REFERENCES QUESITO_CODICE(ID)
)
ENGINE=INNODB;

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

CREATE TABLE VINCOLO_INTEGRITA (
	NOME_ATTRIBUTO VARCHAR(20),
	ATTRIBUTO_RIFERITO VARCHAR(20),
    PRIMARY KEY(NOME_ATTRIBUTO, ATTRIBUTO_RIFERITO),
    FOREIGN KEY(NOME_ATTRIBUTO) REFERENCES ATTRIBUTO(NOME),
    FOREIGN KEY(ATTRIBUTO_RIFERITO) REFERENCES ATTRIBUTO(NOME)
)
ENGINE=INNODB;

CREATE TABLE APPARTENENZA(
	ID INT,
    TITOLO_TEST VARCHAR(20),
    NOME_TABELLA VARCHAR(20) REFERENCES TABELLA.NOME,
    MAIL_DOCENTE VARCHAR(20),
    
    PRIMARY KEY(ID, TITOLO_TEST, NOME_TABELLA, MAIL_DOCENTE),
    
    FOREIGN KEY(ID) REFERENCES QUESITO_RISPOSTA_CHIUSA(ID),
    FOREIGN KEY(ID) REFERENCES QUESITO_CODICE(ID),
    FOREIGN KEY(TITOLO_TEST) REFERENCES QUESITO_RISPOSTA_CHIUSA(TITOLO_TEST),
    FOREIGN KEY(TITOLO_TEST) REFERENCES QUESITO_CODICE(TITOLO_TEST),
	FOREIGN KEY(MAIL_DOCENTE) REFERENCES TABELLA(MAIL_DOCENTE)
    
)
ENGINE = INNODB;

CREATE TABLE CREDENZIALI(
	MAIL VARCHAR(20) NOT NULL,
    UTENTE VARCHAR(20) NOT NULL,
    PAZZWORD VARCHAR(20) NOT NULL,
    RUOLO BOOLEAN NOT NULL, -- ruolo=true(1): docente, ruolo=false(0): studente
    
    
    FOREIGN KEY (MAIL) REFERENCES DOCENTE(MAIL),
    -- FOREIGN KEY (MAIL) REFERENCES STUDENTE(MAIL),
    PRIMARY KEY(MAIL)
)
ENGINE=INNODB;

DELIMITER $
CREATE VIEW CLASSIFICA_STUDENTI_TEST_COMPLETATI AS
SELECT STUDENTE.CODICE, COUNT(STATO) AS NUMERO_TEST_COMPLETATI
FROM STUDENTE
JOIN COMPLETAMENTO ON MAIL = MAIL_STUDENTE
WHERE STATO = 'CONCLUSO'
GROUP BY CODICE
ORDER BY CODICE;
$


DELIMITER $
CREATE VIEW CLASSIFICA_STUDENTI_QUESITI_CORRETTI AS
SELECT CODICE, COUNT(ESITO) AS NUMERO_QUESITI_CORRETTI
FROM STUDENTE, RISPOSTA
WHERE MAIL = MAIL_STUDENTE AND ESITO = TRUE
GROUP BY CODICE
ORDER BY CODICE;
$

DELIMITER $
CREATE VIEW CLASSIFICA_STUDENTI_QUESITI_INSERITI AS
SELECT CODICE, COUNT(*) AS NUMERO_QUESITI_INSERITI
FROM STUDENTE, RISPOSTA
WHERE MAIL = MAIL
$

DELIMITER $
CREATE VIEW QUESITI_COMPLETATI_MAGGIORMENTE AS
SELECT ID, COUNT(ID_QUESITO) AS NUMERO_RISPOSTE
FROM QUESITO_RISPOSTA_CHIUSA, RISPOSTA
WHERE ID = ID_QUESITO
GROUP BY ID
ORDER BY NUMERO_RISPOSTE;
$

DELIMITER $
CREATE PROCEDURE VISUALIZZAZIONE_TEST_DISPONIBILI()
	SELECT * FROM TEST;
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
CREATE PROCEDURE INSERIMENTO_NUOVO_TEST(IN TITOLO VARCHAR(20), IN DATA_CREAZIONE DATE, FOTO BLOB, MAIL_DOCENTE VARCHAR(20))

	INSERT INTO TEST(TITOLO, DATA_CREAZIONE, FOTO, MAIL_DOCENTE) VALUES(TITOLO, DATA_CREAZIONE, FOTO, MAIL_DOCENTE)
$


DELIMITER $
CREATE PROCEDURE INVIO_MESSAGGIO(IN TITOLO_MESSAGGIO VARCHAR(20), TESTO VARCHAR(255), TITOLO_TEST VARCHAR(20), MAIL_DOCENTE VARCHAR(20), MAIL_STUDENTE VARCHAR(20))

	INSERT INTO MESSAGGIO (TITOLO_MESSAGGIO, TESTO, DATA_INSERIMENTO, TITOLO_TEST, MAIL_DOCENTE, MAIL_STUDENTE) VALUES(TITOLO_MESSAGGIO, TESTO, '19/02/2024', TITOLO_TEST, MAIL_DOCENTE, MAIL_STUDENTE)
$

DELIMITER $
CREATE PROCEDURE CAMBIAMENTO_VISUALIZZAZIONE_RISPOSTE_TEST(IN TITOLO_TEST VARCHAR(20), MAIL_DOCENTE VARCHAR(20), OPZIONE_SCELTA BOOLEAN)

	UPDATE TEST
    SET VISUALIZZA_RISPOSTE = OPZIONE_SCELTA
    WHERE TEST.TITOLO_TEST = TITOLO_TEST AND TEST.MAIL_DOCENTE = MAIL_DOCENTE
$

INSERT INTO DOCENTE(MAIL, NOME, COGNOME, RECAPITO, DIPARTIMENTO, CORSO) VALUES ('Mario.rossi@uni.it','Mario', 'Rossi', '12345', 'Scienze', 'Database');

INSERT INTO STUDENTE(MAIL, NOME, COGNOME, RECAPITO, ANNO_IMMATRICOLAZIONE, CODICE) VALUES ('Luca.neri@uni.it', 'Luca', 'Neri', '23456', '2024', '1234123412341234');
INSERT INTO STUDENTE(MAIL, NOME, COGNOME, RECAPITO, ANNO_IMMATRICOLAZIONE, CODICE) VALUES ('Marco.bianchi@uni.it', 'Marco', 'Bianchi', '00000', '2024', '0123012301230123');

INSERT INTO CREDENZIALI(MAIL, UTENTE, PAZZWORD, RUOLO) VALUES ('Mario.rossi@uni.it','Zio','Pera', TRUE);

INSERT INTO TEST(TITOLO, DATA_CREAZIONE, FOTO, MAIL_DOCENTE, VISUALIZZA_RISPOSTE) VALUES('Test di prova', '2024/02/29', 'Foto di prova', 'Mario.rossi@uni.it', true);
INSERT INTO TEST(TITOLO, DATA_CREAZIONE, FOTO, MAIL_DOCENTE, VISUALIZZA_RISPOSTE) VALUES('Test di prova 2', '2024/03/03', 'Foto di prova', 'Mario.rossi@uni.it', true);

INSERT INTO COMPLETAMENTO(DATA_PRIMA_RISPOSTA, DATA_ULTIMA_RISPOSTA, STATO, MAIL_STUDENTE, TITOLO_TEST)
VALUES('2024/03/04', '2024/03/04', 'CONCLUSO', 'Luca.neri@uni.it', 'Test di prova');

INSERT INTO COMPLETAMENTO(DATA_PRIMA_RISPOSTA, DATA_ULTIMA_RISPOSTA, STATO, MAIL_STUDENTE, TITOLO_TEST)
VALUES('2024/03/04', '2024/03/04', 'CONCLUSO', 'Luca.neri@uni.it', 'Test di prova 2');

INSERT INTO COMPLETAMENTO(DATA_PRIMA_RISPOSTA, DATA_ULTIMA_RISPOSTA, STATO, MAIL_STUDENTE, TITOLO_TEST)
VALUES('2024/03/04', '2024/03/04', 'CONCLUSO', 'Marco.bianchi@uni.it', 'Test di prova');

INSERT INTO QUESITO_RISPOSTA_CHIUSA(ID, LIVELLO, DESCRIZ, NUM_RISP, TITOLO_TEST, MAIL_DOCENTE)
VALUES(1, 'Basso', 'Quesito di prova', 4, 'Test di prova', 'Mario.rossi@uni.it');

INSERT INTO RISPOSTA(ESITO, TESTO, MAIL_STUDENTE, ID_QUESITO)
VALUES(TRUE, "risposta", "Luca.neri@uni.it", 1);

INSERT INTO QUESITO_RISPOSTA_CHIUSA(ID, LIVELLO, DESCRIZ, NUM_RISP, TITOLO_TEST, MAIL_DOCENTE)
VALUES(2, 'Medio', 'Quesito di prova 2', 3, 'Test di prova 2', 'Mario.rossi@uni.it');

INSERT INTO RISPOSTA(ESITO, TESTO, MAIL_STUDENTE, ID_QUESITO)
VALUES(TRUE, "risposta", "Luca.neri@uni.it", 2);

SELECT * FROM RISPOSTA;
SELECT * FROM QUESITO_RISPOSTA_CHIUSA;
SELECT * FROM QUESITI_COMPLETATI_MAGGIORMENTE;