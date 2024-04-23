drop database esqldb;
CREATE DATABASE IF NOT EXISTS ESQLDB;

USE ESQLDB;

SET SQL_SAFE_UPDATES=0;

CREATE TABLE DOCENTE(
	MAIL VARCHAR(60),
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
	MAIL VARCHAR(60),
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


CREATE TABLE IF NOT EXISTS SEQUENZA_ID_QUESITI (
	TITOLO_TEST VARCHAR(20),
	ID_QUESITO INT NOT NULL,
    PRIMARY KEY(TITOLO_TEST)
    
)
ENGINE = INNODB;

CREATE INDEX idx_id_quesito ON sequenza_id_quesiti (ID_QUESITO);


CREATE TABLE QUESITO_RISPOSTA_CHIUSA (
    ID INT NOT NULL,
    LIVELLO ENUM('BASSO', 'MEDIO', 'ALTO') NOT NULL,
    TITOLO_TEST VARCHAR(60) NOT NULL,
    DESCRIZ VARCHAR(60),
    NUM_RISPOSTE INT,

    FOREIGN KEY (TITOLO_TEST) REFERENCES TEST(TITOLO),
    PRIMARY KEY(ID, TITOLO_TEST)
)
ENGINE=INNODB;

CREATE TABLE QUESITO_CODICE (
    ID INT NOT NULL,
    LIVELLO ENUM('BASSO', 'MEDIO', 'ALTO') NOT NULL,
    TITOLO_TEST VARCHAR(60) NOT NULL,
    DESCRIZ VARCHAR(60),
    NUM_RISPOSTE INT,

    FOREIGN KEY (TITOLO_TEST) REFERENCES TEST(TITOLO),
    PRIMARY KEY(ID, TITOLO_TEST)
)
ENGINE=INNODB;

CREATE TABLE SOLUZIONE(
	ID INT NOT NULL,
    TESTO VARCHAR(255),

    FOREIGN KEY (ID) REFERENCES QUESITO_CODICE(ID),
    PRIMARY KEY(ID, TESTO)
)
ENGINE = INNODB;

CREATE TABLE TABELLA(
    NOME VARCHAR(60),
    DATA_CREAZIONE DATE,
    NUMRIGHE INT,
    MAIL_DOCENTE VARCHAR(60),
    PRIMARY KEY (NOME),
    FOREIGN KEY (MAIL_DOCENTE) REFERENCES DOCENTE(MAIL)
)
ENGINE=INNODB;  

CREATE TABLE ATTRIBUTO (
    NOME VARCHAR(20),
    TIPO VARCHAR(255) NOT NULL CHECK (TIPO LIKE 'varchar%' OR TIPO 	 IN ('INT', 'BOOLEAN', 'DATE', 'BLOB')),
    NOME_TABELLA VARCHAR(60),
    FOREIGN KEY (NOME_TABELLA) REFERENCES TABELLA(NOME),
    PRIMARY KEY (NOME, NOME_TABELLA)
    
)
ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS SEQUENZA_ID_OPZIONI (
	ID INT NOT NULL AUTO_INCREMENT,
	TITOLO_TEST VARCHAR(20),
	ID_QUESITO INT NOT NULL,
    ID_OPZIONE INT NOT NULL,
    PRIMARY KEY(ID)
    
)
ENGINE = INNODB;

CREATE INDEX idx_id_opzione ON sequenza_id_opzioni (ID_OPZIONE);

CREATE TABLE OPZIONE(
	ID_OPZIONE INT,
    TESTO VARCHAR(50) NOT NULL,
    ID_QUESITO INT REFERENCES QUESITO_RISPOSTA_CHIUSA.ID,
    TITOLO_TEST VARCHAR(20) REFERENCES QUESITO_RISPOSTA_CHIUSA.TITOLO_TEST,
    CORRETTA BOOLEAN NOT NULL DEFAULT FALSE,
    
    PRIMARY KEY(ID_OPZIONE, ID_QUESITO, TITOLO_TEST)
    )
ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS SEQUENZA_ID_SKETCH (
	ID INT NOT NULL AUTO_INCREMENT,
	TITOLO_TEST VARCHAR(20),
	ID_QUESITO INT NOT NULL,
    ID_SKETCH INT NOT NULL,
    PRIMARY KEY(ID)
    
)
ENGINE = INNODB;

CREATE INDEX idx_id_sketch ON sequenza_id_sketch (ID_SKETCH);

CREATE TABLE SKETCH(
	ID_SKETCH INT,
    TESTO VARCHAR(255) NOT NULL,
    TITOLO_TEST VARCHAR(60) REFERENCES QUESITO_CODICE.TITOLO_TEST,
    ID_QUESITO INT REFERENCES QUESITO_CODICE.ID,
    
    PRIMARY KEY(ID_SKETCH, TITOLO_TEST, ID_QUESITO)
)
ENGINE=INNODB;

CREATE TABLE RISPOSTA (
    DATA DATETIME,
    MAIL_STUDENTE VARCHAR(255),
    ESITO BOOLEAN DEFAULT FALSE,
    PRIMARY KEY (data, MAIL_STUDENTE),
    FOREIGN KEY (MAIL_STUDENTE) REFERENCES STUDENTE(mail) ON DELETE CASCADE
);


CREATE TABLE RISPOSTA_QUESITO_CHIUSO (
	MAIL_STUDENTE VARCHAR(20),
    ESITO BOOLEAN,
    SCELTA INT,
    ID_QUESITO INT,
    TITOLO_TEST VARCHAR(20),
    PRIMARY KEY (MAIL_STUDENTE, ID_QUESITO, TITOLO_TEST),
    FOREIGN KEY (MAIL_STUDENTE) REFERENCES STUDENTE(MAIL),
    FOREIGN KEY(SCELTA) REFERENCES OPZIONE(ID_OPZIONE),
    FOREIGN KEY (ID_QUESITO) REFERENCES QUESITO_RISPOSTA_CHIUSA(ID),
    FOREIGN KEY(TITOLO_TEST) REFERENCES QUESITO_RISPOSTA_CHIUSA(TITOLO_TEST) 	
)
ENGINE=INNODB;

CREATE TABLE RISPOSTA_QUESITO_CODICE(
	MAIL_STUDENTE VARCHAR(20),
    TESTO VARCHAR(255),
    ESITO BOOLEAN,
    ID_QUESITO INT,
    TITOLO_TEST VARCHAR(20),
    PRIMARY KEY (MAIL_STUDENTE, ID_QUESITO, TITOLO_TEST),
    FOREIGN KEY (ID_QUESITO) REFERENCES QUESITO_CODICE(ID),
    FOREIGN KEY (MAIL_STUDENTE) REFERENCES STUDENTE(MAIL),
    FOREIGN KEY (ID_QUESITO) REFERENCES QUESITO_CODICE(ID)
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
	TABELLA_REFERENTE VARCHAR(20),
	ATTRIBUTO_REFERENTE VARCHAR(20),
    TABELLA_RIFERITA VARCHAR(20),
	ATTRIBUTO_RIFERITO VARCHAR(20),
    PRIMARY KEY(TABELLA_REFERENTE, ATTRIBUTO_REFERENTE, TABELLA_RIFERITA, ATTRIBUTO_RIFERITO),
    
    FOREIGN KEY(ATTRIBUTO_RIFERITO) REFERENCES ATTRIBUTO(NOME),
    FOREIGN KEY(TABELLA_RIFERITA) REFERENCES TABELLA(NOME)
)
ENGINE=INNODB;

CREATE TABLE APPARTENENZA_QUESITO_CHIUSO(
	NOME_TABELLA VARCHAR(20),
    TITOLO_TEST VARCHAR(20) NOT NULL,
    ID_QUESITO INT NOT NULL,
    
    
    PRIMARY KEY(NOME_TABELLA, TITOLO_TEST, ID_QUESITO),
    
    FOREIGN KEY (NOME_TABELLA) REFERENCES TABELLA(NOME),
    FOREIGN KEY(TITOLO_TEST) REFERENCES QUESITO_RISPOSTA_CHIUSA(TITOLO_TEST),
    FOREIGN KEY(ID_QUESITO) REFERENCES QUESITO_RISPOSTA_CHIUSA(ID)
)
ENGINE = INNODB;



CREATE TABLE APPARTENENZA_QUESITO_CODICE(

	NOME_TABELLA VARCHAR(20),
    TITOLO_TEST VARCHAR(20) NOT NULL,
    ID_QUESITO INT NOT NULL,

    PRIMARY KEY(NOME_TABELLA, TITOLO_TEST, ID_QUESITO),

    FOREIGN KEY(TITOLO_TEST) REFERENCES QUESITO_CODICE(TITOLO_TEST),
    FOREIGN KEY (NOME_TABELLA) REFERENCES TABELLA(NOME),
    FOREIGN KEY(ID_QUESITO) REFERENCES QUESITO_CODICE(ID)
)
ENGINE = INNODB;


-- ------ VISTE ------------------------------
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
SELECT CODICE, COUNT(RISPOSTA_QUESITO_CODICE.ESITO)  + COUNT(RISPOSTA_QUESITO_CHIUSO.ESITO) AS NUMERO_QUESITI_CORRETTI
FROM STUDENTE, RISPOSTA_QUESITO_CODICE, RISPOSTA_QUESITO_CHIUSO
WHERE MAIL =  RISPOSTA_QUESITO_CHIUSO.MAIL_STUDENTE AND RISPOSTA_QUESITO_CHIUSO.MAIL_STUDENTE = RISPOSTA_QUESITO_CODICE.MAIL_STUDENTE AND (RISPOSTA_QUESITO_CODICE.ESITO = TRUE OR RISPOSTA_QUESITO_CHIUSO.ESITO = TRUE)
GROUP BY CODICE
ORDER BY CODICE DESC;
$

-- DELIMITER $
CREATE VIEW CLASSIFICA_STUDENTI_QUESITI_INSERITI AS
SELECT CODICE, COUNT(RISPOSTA_QUESITO_CODICE.ESITO)  + COUNT(RISPOSTA_QUESITO_CHIUSO.ESITO) AS NUMERO_QUESITI_CORRETTI
FROM STUDENTE, RISPOSTA_QUESITO_CODICE, RISPOSTA_QUESITO_CHIUSO
WHERE MAIL =  RISPOSTA_QUESITO_CHIUSO.MAIL_STUDENTE AND RISPOSTA_QUESITO_CHIUSO.MAIL_STUDENTE = RISPOSTA_QUESITO_CODICE.MAIL_STUDENTE
GROUP BY CODICE
ORDER BY CODICE DESC;
-- $

-- DELIMITER $
-- CREATE VIEW QUESITI_COMPLETATI_MAGGIORMENTE AS
-- SELECT ID_QUESITO, COUNT(ID_QUESITO) AS NUMERO_RISPOSTE
-- FROM RISPOSTA_QUESITO_CODICE
-- GROUP BY ID_QUESITO
-- ORDER BY NUMERO_RISPOSTE DESC;
-- UNION
-- SELECT ID_QUESITO, COUNT(ID_QUESITO) AS NUMERO_RISPOSTE
-- FROM RISPOSTA_QUESITO_CHIUSO
-- GROUP BY ID_QUESITO
-- ORDER BY NUMERO_RISPOSTE DESC;
-- $

DELIMITER $

CREATE VIEW QUESITI_COMPLETATI_MAGGIORMENTE AS

SELECT ID_QUESITO, SUM(NUMERO_RISPOSTE) AS NUMERO_RISPOSTE
FROM (
    SELECT ID_QUESITO, COUNT(ID_QUESITO) AS NUMERO_RISPOSTE
    FROM RISPOSTA_QUESITO_CODICE
    GROUP BY ID_QUESITO

    UNION ALL

    SELECT ID_QUESITO, COUNT(ID_QUESITO) AS NUMERO_RISPOSTE
    FROM RISPOSTA_QUESITO_CHIUSO
    GROUP BY ID_QUESITO
) AS Subquery

GROUP BY ID_QUESITO
ORDER BY NUMERO_RISPOSTE DESC;

$
-- ------ PROCEDURE ------------------------------
DELIMITER $
CREATE PROCEDURE VISUALIZZAZIONE_TEST_DISPONIBILI()
	SELECT TITOLO, DATA_CREAZIONE, VISUALIZZA_RISPOSTE FROM TEST;
$

DELIMITER $
CREATE PROCEDURE VISUALIZZAZIONE_QUESITI(IN TITOLO VARCHAR(20))
	SELECT ID, LIVELLO, DESCRIZ
    FROM QUESITO_RISPOSTA_CHIUSA 
	WHERE TITOLO = TITOLO_TEST
    UNION
    SELECT ID, LIVELLO, DESCRIZ
    FROM QUESITO_CODICE
    WHERE TITOLO = TITOLO_TEST
    ORDER BY ID ASC;
$

DELIMITER $
CREATE PROCEDURE INSERIMENTO_NUOVO_TEST(IN TITOLO VARCHAR(20), IN DATA_CREAZIONE DATE, FOTO BLOB, MAIL_DOCENTE VARCHAR(20), VISUALIZZA_RISPOSTE BOOLEAN)

	INSERT INTO TEST(TITOLO, DATA_CREAZIONE, FOTO, MAIL_DOCENTE, VISUALIZZA_RISPOSTE) VALUES(TITOLO, DATA_CREAZIONE, FOTO, MAIL_DOCENTE, VISUALIZZA_RISPOSTE)
$


DELIMITER $
CREATE PROCEDURE INSERIMENTO_QUESITO_CODICE(IN TITOLO_TEST VARCHAR(20), IN LIVELLO VARCHAR(20), IN DESCRIZ VARCHAR(60), IN NUM_RISPOSTE INT)
BEGIN
	INSERT INTO QUESITO_CODICE (TITOLO_TEST, LIVELLO, ID, DESCRIZ, NUM_RISPOSTE)
	VALUES (TITOLO_TEST, LIVELLO, 0, DESCRIZ, NUM_RISPOSTE);
    
	UPDATE QUESITO_CODICE
	SET ID = (SELECT ID_QUESITO FROM SEQUENZA_ID_QUESITI WHERE SEQUENZA_ID_QUESITI.TITOLO_TEST = TITOLO_TEST)
    WHERE QUESITO_CODICE.TITOLO_TEST = TITOLO_TEST AND ID = 0;
END $
DELIMITER ;

DELIMITER $
CREATE PROCEDURE INSERIMENTO_QUESITO_RISPOSTA_CHIUSA(IN TITOLO_TEST VARCHAR(20), IN LIVELLO VARCHAR(20), IN DESCRIZ VARCHAR(60), IN NUM_RISPOSTE INT)
BEGIN
	INSERT INTO QUESITO_RISPOSTA_CHIUSA (TITOLO_TEST, LIVELLO, ID, DESCRIZ, NUM_RISPOSTE)
	VALUES (TITOLO_TEST, LIVELLO, 0, DESCRIZ, NUM_RISPOSTE);
    
	UPDATE QUESITO_RISPOSTA_CHIUSA
	SET ID = (SELECT ID_QUESITO FROM SEQUENZA_ID_QUESITI WHERE SEQUENZA_ID_QUESITI.TITOLO_TEST = TITOLO_TEST)
    WHERE QUESITO_RISPOSTA_CHIUSA.TITOLO_TEST = TITOLO_TEST AND ID = 0;
END $
DELIMITER ;

DELIMITER $
CREATE PROCEDURE INSERIMENTO_OPZIONE(IN TITOLO_TEST VARCHAR(20), IN ID_QUESITO INT, TESTO VARCHAR(50), CORRETTA BOOLEAN)
BEGIN
	INSERT INTO OPZIONE(ID_OPZIONE, TESTO, ID_QUESITO, TITOLO_TEST, CORRETTA) VALUES(0, TESTO, ID_QUESITO, TITOLO_TEST, CORRETTA);

	UPDATE OPZIONE
    SET ID_OPZIONE = (SELECT ID_OPZIONE 
			  FROM SEQUENZA_ID_OPZIONI 
              WHERE SEQUENZA_ID_OPZIONI.TITOLO_TEST = TITOLO_TEST AND SEQUENZA_ID_OPZIONI.ID_QUESITO = ID_QUESITO)
	WHERE OPZIONE.TITOLO_TEST = TITOLO_TEST AND OPZIONE.ID_QUESITO = ID_QUESITO AND ID_OPZIONE = 0;
END $
DELIMITER ;


DELIMITER $
CREATE PROCEDURE INSERIMENTO_SKETCH(TESTO VARCHAR(50), IN TITOLO_TEST VARCHAR(20), IN ID_QUESITO INT)
BEGIN
	INSERT INTO SKETCH(ID_SKETCH, TESTO, ID_QUESITO, TITOLO_TEST) VALUES(0, TESTO, ID_QUESITO, TITOLO_TEST);

	UPDATE SKETCH
    SET ID_SKETCH = (SELECT ID_SKETCH
			  FROM SEQUENZA_ID_SKETCH 
              WHERE SEQUENZA_ID_SKETCH.TITOLO_TEST = TITOLO_TEST AND SEQUENZA_ID_SKETCH.ID_QUESITO = ID_QUESITO)
	WHERE SKETCH.TITOLO_TEST = TITOLO_TEST AND SKETCH.ID_QUESITO = ID_QUESITO AND ID_SKETCH = 0;
END $
DELIMITER ;


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
CREATE PROCEDURE INSERIMENTO_NUOVO_STUDENTE(IN MAIL VARCHAR(20),IN NOME VARCHAR(20),IN COGNOME VARCHAR(20),IN RECAPITO VARCHAR(20),IN ANNO_IMMATRICOLAZIONE CHAR(4),
IN CODICE CHAR(16), IN PAZZWORD VARCHAR(60) )

	INSERT INTO STUDENTE(MAIL, NOME, COGNOME, RECAPITO, ANNO_IMMATRICOLAZIONE, CODICE, PAZZWORD) VALUES(MAIL, NOME, COGNOME, RECAPITO, ANNO_IMMATRICOLAZIONE, CODICE, PAZZWORD)
$

DELIMITER $

CREATE PROCEDURE CAMBIO_STATO_TEST (IN MAIL VARCHAR(60), IN TITOLO_TEST VARCHAR(60))
BEGIN
    IF ((SELECT COUNT(*) FROM COMPLETAMENTO WHERE MAIL_STUDENTE = MAIL AND COMPLETAMENTO.TITOLO_TEST = TITOLO_TEST) = 0) THEN
        INSERT INTO COMPLETAMENTO (DATA_PRIMA_RISPOSTA, DATA_ULTIMA_RISPOSTA, STATO, MAIL_STUDENTE, TITOLO_TEST)
        VALUES (null, null, 'APERTO', MAIL, TITOLO_TEST);
    END IF;
END $

DELIMITER ;


DELIMITER $$

CREATE PROCEDURE inserisci_risposta_quesito_chiuso(
    IN mail_studente VARCHAR(20),
    IN id_quesito INT,
    IN titolo_test VARCHAR(20),
    IN scelta INT
)
BEGIN
DECLARE C int;
SELECT COUNT(*)  INTO C FROM RISPOSTA_QUESITO_CHIUSO WHERE MAIL_STUDENTE = RISPOSTA_QUESITO_CHIUSO.MAIL_STUDENTE
		AND ID_QUESITO = RISPOSTA_QUESITO_CHIUSO.ID_QUESITO AND TITOLO_TEST = RISPOSTA_QUESITO_CHIUSO.TITOLO_TEST;
	IF(C = 0)
        THEN
		INSERT INTO RISPOSTA_QUESITO_CHIUSO (MAIL_STUDENTE, ID_QUESITO, TITOLO_TEST, scelta, ESITO)
		VALUES (mail_studente, id_quesito, titolo_test, scelta, esito);
    END IF;
    
    IF(C <> 0)
        THEN
     UPDATE RISPOSTA_QUESITO_CHIUSO SET RISPOSTA_QUESITO_CHIUSO.SCELTA = SCELTA WHERE MAIL_STUDENTE = RISPOSTA_QUESITO_CHIUSO.MAIL_STUDENTE
		AND ID_QUESITO = RISPOSTA_QUESITO_CHIUSO.ID_QUESITO AND TITOLO_TEST = RISPOSTA_QUESITO_CHIUSO.TITOLO_TEST;
	END IF;
    
    IF (SCELTA IN (SELECT ID_OPZIONE 
					   FROM OPZIONE 
					   WHERE CORRETTA = 1 AND ID_QUESITO = OPZIONE.ID_QUESITO AND TITOLO_TEST = OPZIONE.TITOLO_TEST)) THEN
		UPDATE RISPOSTA_QUESITO_CHIUSO
		SET ESITO = 1 WHERE ID_QUESITO = RISPOSTA_QUESITO_CHIUSO.ID_QUESITO AND TITOLO_TEST = RISPOSTA_QUESITO_CHIUSO.TITOLO_TEST AND MAIL_STUDENTE = RISPOSTA_QUESITO_CHIUSO.MAIL_STUDENTE;
        
	END IF;
    
    IF (SCELTA NOT IN (SELECT ID_OPZIONE 
					   FROM OPZIONE 
					   WHERE CORRETTA = 1 AND ID_QUESITO = OPZIONE.ID_QUESITO AND TITOLO_TEST = OPZIONE.TITOLO_TEST)) THEN
		UPDATE RISPOSTA_QUESITO_CHIUSO
		SET ESITO = 0 WHERE ID_QUESITO = RISPOSTA_QUESITO_CHIUSO.ID_QUESITO AND TITOLO_TEST = RISPOSTA_QUESITO_CHIUSO.TITOLO_TEST AND MAIL_STUDENTE = RISPOSTA_QUESITO_CHIUSO.MAIL_STUDENTE;
	END IF;
    
END;
$$
DELIMITER $


CREATE PROCEDURE inserisci_risposta_quesito_codice(
    IN mail_studente VARCHAR(20),
    IN id_quesito INT,
    IN titolo_test VARCHAR(20),
    IN testo_risposta VARCHAR(255)
)
BEGIN
DECLARE C int;
SELECT COUNT(*)  INTO C FROM RISPOSTA_QUESITO_CODICE WHERE MAIL_STUDENTE = RISPOSTA_QUESITO_CODICE.MAIL_STUDENTE
		AND ID_QUESITO = RISPOSTA_QUESITO_CODICE.ID_QUESITO AND TITOLO_TEST = RISPOSTA_QUESITO_CODICE.TITOLO_TEST;
	IF(C = 0)
        THEN
		INSERT INTO RISPOSTA_QUESITO_CODICE (MAIL_STUDENTE, ID_QUESITO, TITOLO_TEST, TESTO, ESITO)
		VALUES (mail_studente, id_quesito, titolo_test, testo_risposta, esito);
    END IF;
    
    IF(C <> 0)
        THEN
     UPDATE RISPOSTA_QUESITO_CODICE SET TESTO = TESTO_RISPOSTA WHERE MAIL_STUDENTE = RISPOSTA_QUESITO_CODICE.MAIL_STUDENTE
		AND ID_QUESITO = RISPOSTA_QUESITO_CODICE.ID_QUESITO AND TITOLO_TEST = RISPOSTA_QUESITO_CODICE.TITOLO_TEST;
	END IF;

	IF(TESTO_RISPOSTA IN(SELECT TESTO FROM SKETCH WHERE ID_QUESITO = SKETCH.ID_QUESITO AND TITOLO_TEST = SKETCH.TITOLO_TEST)) THEN
	  UPDATE RISPOSTA_QUESITO_CODICE SET ESITO = 1 WHERE MAIL_STUDENTE = RISPOSTA_QUESITO_CODICE.MAIL_STUDENTE
	            AND TITOLO_TEST = RISPOSTA_QUESITO_CODICE.TITOLO_TEST AND ID_QUESITO = RISPOSTA_QUESITO_CODICE.ID_QUESITO;
    END IF;
    IF(TESTO_RISPOSTA NOT IN(SELECT TESTO FROM SKETCH WHERE ID_QUESITO = SKETCH.ID_QUESITO AND TITOLO_TEST = SKETCH.TITOLO_TEST)) THEN
		UPDATE RISPOSTA_QUESITO_CODICE SET ESITO = 0 WHERE MAIL_STUDENTE = RISPOSTA_QUESITO_CODICE.MAIL_STUDENTE
         AND TITOLO_TEST = RISPOSTA_QUESITO_CODICE.TITOLO_TEST AND ID_QUESITO = RISPOSTA_QUESITO_CODICE.ID_QUESITO;
	END IF;
    
    
END;
$
DELIMITER ;



-- ------ TRIGGER ------------------------------

DELIMITER //
CREATE TRIGGER CAMBIO_STATO_COMPLETAMENTO_QUESITO_CODICE
AFTER INSERT ON RISPOSTA_QUESITO_CODICE
FOR EACH ROW
BEGIN
    DECLARE num_risposte INT;
    DECLARE DATA date;
    DECLARE stato_test VARCHAR(20);
    select CURDATE() INTO DATA; 
    
    -- Controlla il numero di risposte per il test inserito
    SELECT COUNT(*) INTO num_risposte FROM RISPOSTA_QUESITO_CODICE WHERE ID_QUESITO = NEW.ID_QUESITO AND MAIL_STUDENTE = NEW.MAIL_STUDENTE AND TITOLO_TEST = NEW.TITOLO_TEST;


    -- Se è la prima risposta, aggiorna lo stato del test
    IF num_risposte = 1 THEN
        UPDATE COMPLETAMENTO SET STATO = 'IN_COMPLETAMENTO', DATA_PRIMA_RISPOSTA = DATA
        WHERE MAIL_STUDENTE = NEW.MAIL_STUDENTE AND TITOLO_TEST = NEW.TITOLO_TEST;
    END IF;
END;
 //
 
 DELIMITER //
CREATE TRIGGER CAMBIO_STATO_COMPLETAMENTO_QUESITO_CHIUSO
AFTER INSERT ON RISPOSTA_QUESITO_CHIUSO
FOR EACH ROW
BEGIN
    DECLARE num_risposte INT;
    DECLARE DATA DATE;
    DECLARE stato_test VARCHAR(20);
    
    SELECT curdate() INTO DATA;

    -- Controlla il numero di risposte per il test inserito
    SELECT COUNT(*) INTO num_risposte FROM RISPOSTA_QUESITO_CHIUSO WHERE ID_QUESITO = NEW.ID_QUESITO AND MAIL_STUDENTE = NEW.MAIL_STUDENTE AND TITOLO_TEST = NEW.TITOLO_TEST;

    -- Se è la prima risposta, aggiorna lo stato del test
    IF num_risposte = 1 THEN
        UPDATE COMPLETAMENTO SET STATO = 'IN_COMPLETAMENTO', DATA_PRIMA_RISPOSTA = DATA
        WHERE MAIL_STUDENTE = NEW.MAIL_STUDENTE AND TITOLO_TEST = NEW.TITOLO_TEST;
    END IF;
    
    
END;
//

DELIMITER //
CREATE TRIGGER AGGIUNTA_SEQUENZA_QUESITI
AFTER INSERT ON TEST
FOR EACH ROW
BEGIN
    INSERT INTO SEQUENZA_ID_QUESITI (TITOLO_TEST, ID_QUESITO) VALUES (NEW.TITOLO, 0);
END;
//

DELIMITER //
CREATE TRIGGER AGGIUNTA_SEQUENZA_OPZIONI
AFTER INSERT ON OPZIONE
FOR EACH ROW
BEGIN
    DECLARE riga_esistente INT;

    SELECT COUNT(*) INTO riga_esistente
    FROM SEQUENZA_ID_OPZIONI
    WHERE TITOLO_TEST = NEW.TITOLO_TEST AND ID_QUESITO = NEW.ID_QUESITO;

    IF riga_esistente = 0 THEN
        INSERT INTO SEQUENZA_ID_OPZIONI (TITOLO_TEST, ID_QUESITO, ID_OPZIONE)
        VALUES (NEW.TITOLO_TEST, NEW.ID_QUESITO, 0);
    END IF;
END;
//
DELIMITER ;

DELIMITER //
CREATE TRIGGER AGGIUNTA_SEQUENZA_SKETCH
AFTER INSERT ON SKETCH
FOR EACH ROW
BEGIN
    DECLARE riga_esistente INT;

    SELECT COUNT(*) INTO riga_esistente
    FROM SEQUENZA_ID_SKETCH
    WHERE TITOLO_TEST = NEW.TITOLO_TEST AND ID_QUESITO = NEW.ID_QUESITO;

    IF riga_esistente = 0 THEN
        INSERT INTO SEQUENZA_ID_SKETCH (TITOLO_TEST, ID_QUESITO, ID_SKETCH)
        VALUES (NEW.TITOLO_TEST, NEW.ID_QUESITO, 0);
    END IF;
END;
//
DELIMITER ;

DELIMITER //

CREATE TRIGGER AGGIORNAMENTO_SEQUENZA_QUESITI_RISPOSTA_CHIUSA
AFTER INSERT ON QUESITO_RISPOSTA_CHIUSA
FOR EACH ROW
BEGIN
    UPDATE SEQUENZA_ID_QUESITI
    SET ID_QUESITO = ID_QUESITO + 1
    WHERE TITOLO_TEST = NEW.TITOLO_TEST;
    
END;
//

DELIMITER //
CREATE TRIGGER AGGIORNAMENTO_SEQUENZA_OPZIONI
AFTER INSERT ON OPZIONE
FOR EACH ROW
BEGIN
    UPDATE SEQUENZA_ID_OPZIONI
    SET ID_OPZIONE= ID_OPZIONE + 1
    WHERE TITOLO_TEST = NEW.TITOLO_TEST AND ID_QUESITO = NEW.ID_QUESITO;
    
END;
//

DELIMITER //
CREATE TRIGGER AGGIORNAMENTO_SEQUENZA_SKETCH
AFTER INSERT ON SKETCH
FOR EACH ROW
BEGIN
    UPDATE SEQUENZA_ID_SKETCH
    SET ID_SKETCH= ID_SKETCH + 1
    WHERE TITOLO_TEST = NEW.TITOLO_TEST AND ID_QUESITO = NEW.ID_QUESITO;
    
END;
//

DELIMITER //

CREATE TRIGGER AGGIORNAMENTO_SEQUENZA_QUESITI_CHIUSI
AFTER INSERT ON QUESITO_CODICE
FOR EACH ROW
BEGIN
    UPDATE SEQUENZA_ID_QUESITI
    SET ID_QUESITO = ID_QUESITO + 1
    WHERE TITOLO_TEST = NEW.TITOLO_TEST;
END; 		
//




DELIMITER //

CREATE TRIGGER CAMBIO_STATO_CONCLUSO
AFTER INSERT ON RISPOSTA_QUESITO_CHIUSO
FOR EACH ROW
BEGIN
DECLARE num_quesiti_chiusi INT;
DECLARE num_quesiti_codice INT;
DECLARE num_risposte_chiuse_corrette INT;
DECLARE num_risposte_codice_corrette INT;

SELECT COUNT(*) INTO num_quesiti_chiusi FROM QUESITO_RISPOSTA_CHIUSA WHERE TITOLO_TEST = NEW.TITOLO_TEST;
SELECT COUNT(*) INTO num_quesiti_codice FROM QUESITO_CODICE WHERE TITOLO_TEST = NEW.TITOLO_TEST;

SELECT COUNT(*) INTO num_risposte_chiuse_corrette FROM RISPOSTA_QUESITO_CHIUSO WHERE MAIL_STUDENTE = NEW.MAIL_STUDENTE AND TITOLO_TEST = NEW.TITOLO_TEST AND ESITO = 1;
SELECT COUNT(*) INTO num_risposte_codice_corrette FROM RISPOSTA_QUESITO_CODICE WHERE MAIL_STUDENTE = NEW.MAIL_STUDENTE AND TITOLO_TEST = NEW.TITOLO_TEST AND ESITO = 1;

if(num_quesiti_chiusi = num_risposte_chiuse_corrette) AND (num_quesiti_codice = num_risposte_codice_corrette) THEN
UPDATE COMPLETAMENTO SET STATO = 'CONCLUSO'
        WHERE MAIL_STUDENTE = NEW.MAIL_STUDENTE AND TITOLO_TEST = NEW.TITOLO_TEST;
    END IF;
END //

DELIMITER ;

DELIMITER //

CREATE TRIGGER CAMBIO_STATO_TUTTICONCLUSO
AFTER UPDATE ON TEST
FOR EACH ROW
BEGIN
    DECLARE stato_test VARCHAR(20);

    -- Se il campo VisualizzaRisposte viene impostato a True, cambia lo stato del test per tutti gli studenti
    IF OLD.VISUALIZZA_RISPOSTE = FALSE AND NEW.VISUALIZZA_RISPOSTE = TRUE THEN
        UPDATE COMPLETAMENTO SET STATO = 'CONCLUSO' WHERE TITOLO_TEST = NEW.TITOLO;
    END IF;
END //

DELIMITER ;

DELIMITER //
CREATE TRIGGER CAMBIA_DATA_ULTIMA_RISPOSTA_CHIUSA
AFTER INSERT ON RISPOSTA_QUESITO_CHIUSO
FOR EACH ROW
BEGIN
	DECLARE DATA VARCHAR(20);
	SET DATA = CURDATE();
    UPDATE COMPLETAMENTO SET DATA_ULTIMA_RISPOSTA = DATA WHERE COMPLETAMENTO.MAIL_STUDENTE = NEW.MAIL_STUDENTE AND COMPLETAMENTO.TITOLO_TEST = NEW.TITOLO_TEST;
END//
DELIMITER ;

DELIMITER //
CREATE TRIGGER CAMBIA_DATA_ULTIMA_RISPOSTA_CODICE
    AFTER INSERT ON RISPOSTA_QUESITO_CODICE
    FOR EACH ROW
BEGIN
    DECLARE DATA VARCHAR(20);
	SET DATA = CURDATE();
    UPDATE COMPLETAMENTO SET DATA_ULTIMA_RISPOSTA = DATA WHERE COMPLETAMENTO.MAIL_STUDENTE = NEW.MAIL_STUDENTE AND COMPLETAMENTO.TITOLO_TEST = NEW.TITOLO_TEST;
END//
DELIMITER ;
-- ------ INSERT ------------------------------
INSERT INTO DOCENTE(MAIL, NOME, COGNOME, RECAPITO, DIPARTIMENTO, CORSO, PAZZWORD) VALUES ('Mario.rossi@uni.it','Mario', 'Rossi', '12345', 'Scienze', 'Database', 'ZioPera');
INSERT INTO STUDENTE(MAIL, NOME, COGNOME, RECAPITO, ANNO_IMMATRICOLAZIONE, CODICE, PAZZWORD) VALUES ('Luca.neri@uni.it', 'Luca', 'Neri', '23456', '2024', '1234123412341234', 'Password');
INSERT INTO STUDENTE(MAIL, NOME, COGNOME, RECAPITO, ANNO_IMMATRICOLAZIONE, CODICE, PAZZWORD) VALUES ('Marco.bianchi@uni.it', 'Marco', 'Bianchi', '00000', '2024', '0123012301230123', 'Password');

INSERT INTO TEST(TITOLO, DATA_CREAZIONE, FOTO, MAIL_DOCENTE, VISUALIZZA_RISPOSTE) VALUES('Test di prova', '2024-02-29', 'Foto di prova', 'Mario.rossi@uni.it', true);
INSERT INTO TEST(TITOLO, DATA_CREAZIONE, FOTO, MAIL_DOCENTE, VISUALIZZA_RISPOSTE) VALUES('Test di prova 2', '2024-03-03', 'Foto di prova', 'Mario.rossi@uni.it', true);



SELECT * FROM DOCENTE;
SELECT * FROM STUDENTE;
SELECT * FROM TEST;
SELECT * FROM quesito_codice;
SELECT * FROM quesito_risposta_chiusa;