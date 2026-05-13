-- ============================================================
-- schema.sql — 5Dsprovieri_GestionePalestra
-- Struttura del database e dati di esempio.
-- Eseguire questo file una sola volta per inizializzare il DB.
-- ============================================================

CREATE DATABASE IF NOT EXISTS 5Dsprovieri_GestionePalestra;

USE 5Dsprovieri_GestionePalestra;

-- ── Tabella Clienti ─────────────────────────────────────────
-- Contiene i dati anagrafici di ogni iscritto alla palestra.
CREATE TABLE IF NOT EXISTS Clienti (
    id_cliente  INT          NOT NULL AUTO_INCREMENT PRIMARY KEY,
    cognome     VARCHAR(50)  NOT NULL,
    nome        VARCHAR(50)  NOT NULL,
    email       VARCHAR(100) NOT NULL,
    telefono    VARCHAR(20)
);

-- ── Tabella TipiAbbonamento ──────────────────────────────────
-- Catalogo dei tipi di abbonamento offerti dalla palestra.
CREATE TABLE IF NOT EXISTS TipiAbbonamento (
    id_tipo     INT          NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome        VARCHAR(50)  NOT NULL,
    durata_gg   INT          NOT NULL,   -- durata in giorni
    prezzo      DECIMAL(8,2) NOT NULL
);

-- ── Tabella Abbonamenti ──────────────────────────────────────
-- Ogni riga rappresenta un abbonamento acquistato da un cliente.
-- La colonna attivo vale 1 se l'abbonamento è in corso, 0 se scaduto.
CREATE TABLE IF NOT EXISTS Abbonamenti (
    id_abbonamento  INT     NOT NULL AUTO_INCREMENT PRIMARY KEY,
    cliente         INT     NOT NULL,
    tipo            INT     NOT NULL,
    data_inizio     DATE    NOT NULL,
    data_fine       DATE    NOT NULL,
    attivo          TINYINT(1) NOT NULL DEFAULT 1,
    FOREIGN KEY (cliente) REFERENCES Clienti(id_cliente),
    FOREIGN KEY (tipo)    REFERENCES TipiAbbonamento(id_tipo)
);

-- ── Tabella Ingressi ─────────────────────────────────────────
-- Registra ogni accesso fisico di un cliente alla palestra.
CREATE TABLE IF NOT EXISTS Ingressi (
    id_ingresso     INT      NOT NULL AUTO_INCREMENT PRIMARY KEY,
    abbonamento     INT      NOT NULL,
    data_ingresso   DATE     NOT NULL,
    FOREIGN KEY (abbonamento) REFERENCES Abbonamenti(id_abbonamento)
);

-- ── Dati di esempio: tipi abbonamento ───────────────────────
INSERT IGNORE INTO TipiAbbonamento (id_tipo, nome, durata_gg, prezzo) VALUES
    (1, 'Mensile',    30,  40.00),
    (2, 'Trimestrale',90, 100.00),
    (3, 'Semestrale', 180, 180.00),
    (4, 'Annuale',    365, 300.00);

-- ── Dati di esempio: clienti ────────────────────────────────
INSERT IGNORE INTO Clienti (id_cliente, cognome, nome, email, telefono) VALUES
    (1, 'Rossi',   'Mario',  'mario.rossi@email.it',   '3331234567'),
    (2, 'Verdi',   'Laura',  'laura.verdi@email.it',   '3479876543'),
    (3, 'Bianchi', 'Luca',   'luca.bianchi@email.it',  '3204561234'),
    (4, 'Neri',    'Sofia',  'sofia.neri@email.it',    '3387654321'),
    (5, 'Ferrari', 'Giorgio','giorgio.ferrari@email.it','3501112233');

-- ── Dati di esempio: abbonamenti ────────────────────────────
INSERT IGNORE INTO Abbonamenti (id_abbonamento, cliente, tipo, data_inizio, data_fine, attivo) VALUES
    (1, 1, 2, '2026-03-01', '2026-05-30', 1),
    (2, 2, 1, '2026-04-01', '2026-04-30', 1),
    (3, 3, 4, '2026-01-10', '2027-01-10', 1),
    (4, 4, 1, '2026-02-01', '2026-03-03', 0),
    (5, 5, 3, '2025-11-01', '2026-05-01', 1);

-- ── Dati di esempio: ingressi ───────────────────────────────
INSERT IGNORE INTO Ingressi (id_ingresso, abbonamento, data_ingresso) VALUES
    (1, 1, '2026-03-03'),
    (2, 1, '2026-03-05'),
    (3, 1, '2026-03-10'),
    (4, 2, '2026-04-02'),
    (5, 2, '2026-04-07'),
    (6, 3, '2026-02-15'),
    (7, 3, '2026-03-01'),
    (8, 5, '2026-04-20'),
    (9, 5, '2026-04-28');
