<?php
// Rinomina questo file in database.php e inserisci i tuoi dati
$host     = "localhost";
$user     = "tuo_utente";
$password = "tua_password";
$database = "5Dsprovieri_GestionePalestra";

$connection = mysqli_connect($host, $user, $password, $database);
if (!$connection) {
    die("Errore di connessione: " . mysqli_connect_error());
}
?>
