<link rel="stylesheet" href="../../style.css">
<?php
/* ============================================================
 * PalestraController.php — Controller principale (MVC)
 * Legge il parametro GET 'page' e instrada verso la view
 * corrispondente, dopo aver eseguito la logica necessaria.
 *
 * Pagine gestite:
 *   A — clienti con abbonamento attivo
 *   B — storico ingressi di un cliente
 *   C — nuovo abbonamento
 *   D — disattivazione abbonamento scaduto
 * ============================================================ */

require_once "../../config/database.php";
require_once "../models/Palestra.php";

$oggi = date('Y-m-d');
$page = $_GET['page'] ?? '';

// ═══════════════════════════════════════════════════════════
// A) CLIENTI CON ABBONAMENTO ATTIVO
// ═══════════════════════════════════════════════════════════
if ($page === 'attivi') {
    /* Recupero tutti i clienti con abbonamento attivo */
    $risultato = getClientiAttivi($connection);

    require __DIR__ . "/../views/palestra/attivi.php";
    exit;
}

// ═══════════════════════════════════════════════════════════
// B) STORICO INGRESSI DI UN CLIENTE
// ═══════════════════════════════════════════════════════════
if ($page === 'storico') {
    $errore     = '';
    $cercato    = false;
    $risultato  = null;
    $id_cliente = '';
    $data_inizio = date('Y-m-d', strtotime('-1 month')); /* default: ultimo mese */
    $data_fine   = $oggi;
    $listaClienti = getAllClienti($connection);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_cliente  = $_POST['id_cliente']  ?? '';
        $data_inizio = $_POST['data_inizio'] ?? '';
        $data_fine   = $_POST['data_fine']   ?? '';
        $cercato     = true;

        /* Validazione campi obbligatori */
        if (empty($id_cliente) || empty($data_inizio) || empty($data_fine)) {
            $errore = 'Compilare tutti i campi.';
        } elseif ($data_fine < $data_inizio) {
            $errore = 'La data di fine deve essere successiva alla data di inizio.';
        } else {
            $risultato = getIngressiCliente($connection, $id_cliente, $data_inizio, $data_fine);
        }
    }

    require __DIR__ . "/../views/palestra/storico.php";
    exit;
}

// ═══════════════════════════════════════════════════════════
// C) INSERIMENTO NUOVO ABBONAMENTO
// ═══════════════════════════════════════════════════════════
if ($page === 'nuovo') {
    $errore      = '';
    $successo    = '';
    $listaClienti = getAllClienti($connection);
    $listaTipi    = getAllTipi($connection);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_cliente  = $_POST['id_cliente']  ?? '';
        $id_tipo     = $_POST['id_tipo']     ?? '';
        $data_inizio = trim($_POST['data_inizio'] ?? '');

        /* Validazione: tutti i campi sono obbligatori */
        if (empty($id_cliente) || empty($id_tipo) || empty($data_inizio)) {
            $errore = 'Tutti i campi sono obbligatori.';
        } elseif ($data_inizio < $oggi) {
            $errore = 'La data di inizio non può essere nel passato.';
        } else {
            /* Chiamata al model per inserire il nuovo abbonamento */
            if (inserisciAbbonamento($connection, $id_cliente, $id_tipo, $data_inizio, $errore)) {
                $successo = "Abbonamento registrato con successo!";
                /* Ricarico le liste dopo l'inserimento */
                $listaClienti = getAllClienti($connection);
                $listaTipi    = getAllTipi($connection);
            }
        }
    }

    require __DIR__ . "/../views/palestra/nuovo.php";
    exit;
}

// ═══════════════════════════════════════════════════════════
// D) DISATTIVAZIONE ABBONAMENTO SCADUTO
// ═══════════════════════════════════════════════════════════
if ($page === 'disattiva') {
    $errore   = '';
    $successo = '';
    $listaAttivi = getAbbonamentiAttivi($connection);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_abbonamento = $_POST['id_abbonamento'] ?? '';

        /* Validazione: deve essere un intero positivo */
        if (empty($id_abbonamento) || (int)$id_abbonamento <= 0) {
            $errore = 'Selezionare un abbonamento valido.';
        } else {
            /* Chiamata al model per disattivare l'abbonamento */
            if (disattivaAbbonamento($connection, $id_abbonamento, $errore)) {
                $successo    = "Abbonamento #$id_abbonamento disattivato con successo.";
                $listaAttivi = getAbbonamentiAttivi($connection);
            }
        }
    }

    require __DIR__ . "/../views/palestra/disattiva.php";
    exit;
}

// ═══════════════════════════════════════════════════════════
// E) INSERIMENTO NUOVO CLIENTE
// ═══════════════════════════════════════════════════════════
if ($page === 'cliente') {
    $errore   = '';
    $successo = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $cognome  = trim($_POST['cognome']  ?? '');
        $nome     = trim($_POST['nome']     ?? '');
        $email    = trim($_POST['email']    ?? '');
        $telefono = trim($_POST['telefono'] ?? '');

        /* Validazione: cognome, nome ed email sono obbligatori */
        if (empty($cognome) || empty($nome) || empty($email)) {
            $errore = 'Cognome, nome ed email sono obbligatori.';
        } else {
            if (inserisciCliente($connection, $cognome, $nome, $email, $telefono, $errore)) {
                $successo = "Cliente $nome $cognome registrato con successo!";
            }
        }
    }

    require __DIR__ . "/../views/palestra/cliente.php";
    exit;
}

// ─── Default: dashboard principale ──────────────────────────
require __DIR__ . "/../views/palestra/index.php";
?>
