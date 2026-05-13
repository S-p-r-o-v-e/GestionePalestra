============================================================
  5Dsprovieri_GestionePalestra
  Classe 5D — ITIS E. Mattei — A.S. 2024/2025
  Studente: Sprovieri Davide
============================================================

DESCRIZIONE
-----------
Sistema web per la gestione di una palestra sviluppato
in PHP (MVC) con database MySQL.

Funzionalità:
  A — Lista clienti con abbonamento attivo
  B — Storico ingressi di un cliente in un periodo
  C — Inserimento nuovo abbonamento
  D — Disattivazione di un abbonamento scaduto

STRUTTURA CARTELLE
------------------
5Dsprovieri_GestionePalestra/
├── style.css                          ← CSS globale
├── config/
│   ├── database.php                   ← Credenziali DB
│   └── schema.sql                     ← Struttura DB + dati esempio
├── public/
│   └── index.php                      ← Entry point (reindirizza al controller)
└── app/
    ├── controllers/
    │   └── PalestraController.php     ← Controller MVC
    ├── models/
    │   └── Palestra.php               ← Funzioni DB (mysqli)
    └── views/
        └── palestra/
            ├── index.php              ← Dashboard
            ├── attivi.php             ← Pagina A
            ├── storico.php            ← Pagina B
            ├── nuovo.php              ← Pagina C
            └── disattiva.php          ← Pagina D

INSTALLAZIONE
-------------
1. Importare config/schema.sql nel proprio MySQL/MariaDB
2. Modificare config/database.php con host, user, password
3. Aprire nel browser: public/index.php

TECNOLOGIE USATE
----------------
- PHP (mysqli, pattern MVC)
- MySQL / MariaDB
- HTML + CSS
============================================================
