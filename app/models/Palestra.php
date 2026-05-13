<?php
/* ============================================================
 * Palestra.php — Model
 * Contiene tutte le funzioni che interagiscono con il database.
 * Ogni funzione esegue una query e restituisce il risultato.
 * Si usa mysqli_real_escape_string() per prevenire SQL injection.
 * ============================================================ */


/* ── A) Clienti con abbonamento attivo ──────────────────────
 * Restituisce tutti i clienti che hanno almeno un abbonamento
 * con attivo = 1, ordinati per cognome e nome.
 */
function getClientiAttivi($conn) {
    $sql = "SELECT c.id_cliente, c.cognome, c.nome, c.email, c.telefono,
                   t.nome AS tipo_abbonamento, a.data_inizio, a.data_fine
            FROM Clienti c
            JOIN Abbonamenti a ON c.id_cliente = a.cliente
            JOIN TipiAbbonamento t ON a.tipo = t.id_tipo
            WHERE a.attivo = 1
            ORDER BY c.cognome, c.nome";
    return mysqli_query($conn, $sql);
}


/* ── B) Storico ingressi di un cliente in un periodo ────────
 * Restituisce tutti gli ingressi registrati per il cliente
 * indicato, filtrati per intervallo di date.
 */
function getIngressiCliente($conn, $id_cliente, $data_inizio, $data_fine) {
    /* Escape dei parametri per sicurezza */
    $id_cliente  = (int)$id_cliente;
    $data_inizio = mysqli_real_escape_string($conn, $data_inizio);
    $data_fine   = mysqli_real_escape_string($conn, $data_fine);

    $sql = "SELECT i.id_ingresso, i.data_ingresso,
                   c.cognome, c.nome,
                   t.nome AS tipo_abbonamento
            FROM Ingressi i
            JOIN Abbonamenti a     ON i.abbonamento = a.id_abbonamento
            JOIN Clienti c         ON a.cliente     = c.id_cliente
            JOIN TipiAbbonamento t ON a.tipo        = t.id_tipo
            WHERE a.cliente       = $id_cliente
            AND   i.data_ingresso >= '$data_inizio'
            AND   i.data_ingresso <= '$data_fine'
            ORDER BY i.data_ingresso DESC";
    return mysqli_query($conn, $sql);
}


/* ── C) Inserimento nuovo abbonamento ───────────────────────
 * Registra un nuovo abbonamento per il cliente selezionato.
 * Calcola automaticamente la data_fine in base alla durata
 * del tipo di abbonamento scelto.
 * Restituisce true se ok, false con messaggio in $errore.
 */
function inserisciAbbonamento($conn, $id_cliente, $id_tipo, $data_inizio, &$errore) {
    $id_cliente  = (int)$id_cliente;
    $id_tipo     = (int)$id_tipo;
    $data_inizio = mysqli_real_escape_string($conn, $data_inizio);

    /* Recupero la durata in giorni del tipo abbonamento scelto */
    $res = mysqli_query($conn,
        "SELECT durata_gg FROM TipiAbbonamento WHERE id_tipo = $id_tipo");
    if (mysqli_num_rows($res) === 0) {
        $errore = "Tipo abbonamento non trovato.";
        return false;
    }
    $row       = mysqli_fetch_assoc($res);
    $durata_gg = (int)$row['durata_gg'];

    /* Calcolo data_fine: data_inizio + durata in giorni */
    $data_fine = date('Y-m-d', strtotime("$data_inizio + $durata_gg days"));

    /* Inserimento nel database */
    if (!mysqli_query($conn,
        "INSERT INTO Abbonamenti (cliente, tipo, data_inizio, data_fine, attivo)
         VALUES ($id_cliente, $id_tipo, '$data_inizio', '$data_fine', 1)")) {
        $errore = "Errore DB: " . mysqli_error($conn);
        return false;
    }
    return true;
}


/* ── D) Disattivazione abbonamento ──────────────────────────
 * Imposta attivo = 0 sull'abbonamento indicato.
 * Usato per segnare manualmente un abbonamento come scaduto.
 * Restituisce true se ok, false con messaggio in $errore.
 */
function disattivaAbbonamento($conn, $id_abbonamento, &$errore) {
    $id_abbonamento = (int)$id_abbonamento;

    /* Controllo che esista e sia ancora attivo */
    $check = mysqli_query($conn,
        "SELECT id_abbonamento FROM Abbonamenti
         WHERE id_abbonamento = $id_abbonamento AND attivo = 1");
    if (mysqli_num_rows($check) === 0) {
        $errore = "Abbonamento #$id_abbonamento non trovato o già disattivato.";
        return false;
    }

    /* Aggiornamento: imposto attivo = 0 */
    if (!mysqli_query($conn,
        "UPDATE Abbonamenti SET attivo = 0
         WHERE id_abbonamento = $id_abbonamento")) {
        $errore = "Errore DB: " . mysqli_error($conn);
        return false;
    }
    return true;
}


/* ── E) Inserimento nuovo cliente ───────────────────────────
 * Registra un nuovo cliente nella tabella Clienti.
 * Restituisce true se ok, false con messaggio in $errore.
 */
function inserisciCliente($conn, $cognome, $nome, $email, $telefono, &$errore) {
    $cognome   = mysqli_real_escape_string($conn, $cognome);
    $nome      = mysqli_real_escape_string($conn, $nome);
    $email     = mysqli_real_escape_string($conn, $email);
    $telefono  = mysqli_real_escape_string($conn, $telefono);

    /* Controllo che l'email non sia già presente nel database */
    $check = mysqli_query($conn,
        "SELECT id_cliente FROM Clienti WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) {
        $errore = "Esiste già un cliente con questa email.";
        return false;
    }

    if (!mysqli_query($conn,
        "INSERT INTO Clienti (cognome, nome, email, telefono)
         VALUES ('$cognome', '$nome', '$email', '$telefono')")) {
        $errore = "Errore DB: " . mysqli_error($conn);
        return false;
    }
    return true;
}


/* ── Helper: lista tutti i clienti (per select nei form) ────*/
function getAllClienti($conn) {
    return mysqli_query($conn,
        "SELECT id_cliente, cognome, nome FROM Clienti ORDER BY cognome, nome");
}


/* ── Helper: lista tutti i tipi abbonamento (per select) ────*/
function getAllTipi($conn) {
    return mysqli_query($conn,
        "SELECT id_tipo, nome, durata_gg, prezzo
         FROM TipiAbbonamento ORDER BY durata_gg");
}


/* ── Helper: abbonamenti attivi (per pagina D) ──────────────*/
function getAbbonamentiAttivi($conn) {
    return mysqli_query($conn,
        "SELECT a.id_abbonamento, c.cognome, c.nome,
                t.nome AS tipo, a.data_inizio, a.data_fine
         FROM Abbonamenti a
         JOIN Clienti c         ON a.cliente = c.id_cliente
         JOIN TipiAbbonamento t ON a.tipo    = t.id_tipo
         WHERE a.attivo = 1
         ORDER BY a.data_fine ASC");
}
?>
