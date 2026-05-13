<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitUP Montelabbate — Gestione Palestra</title>
    <link rel="stylesheet" href="../../../style.css">
</head>
<body>

<!-- ── Navbar ── -->
<div class="navbar">
    <span class="brand">FIT<span>UP</span></span>
    <span class="info">Montelabbate - Via Bellini, 25 - Aperto 24/7</span>
</div>

<!-- ── Hero con immagine palestra (Unsplash, libera da copyright) ── -->
<div class="hero">
    <img src="https://fitup.it/wp-content/uploads/2026/03/Montelabbate-CLUB.jpg"
         alt="Palestra FitUP Montelabbate">
    <div class="hero-text">
        <h1>FIT<span>UP</span> MONTELABBATE</h1>
        <p>Aperti 24h - 7 giorni su 7</p>
    </div>
</div>

<!-- ── Barra info rapide ── -->
<div class="info-bar">
    <div class="info-item"><strong>Indirizzo</strong>Via Bellini 25, Osteria Nuova (PU)</div>
    <div class="info-item"><strong>Telefono</strong>375 937 7663</div>
    <div class="info-item"><strong>Orari</strong>Aperto 24 ore · 365 giorni l'anno</div>
</div>

<!-- ── Pannello di controllo ── -->
<div class="main-content">
    <h2>PANNELLO DI GESTIONE</h2>

    <!-- Cards navigazione: una per ogni funzione del sistema -->
    <div class="dashboard-grid">

        <a href="../controllers/PalestraController.php?page=attivi" class="dashboard-card">
            <span class="card-letter">A</span>
            <span class="card-label">Clienti Abbonati Attivi</span>
        </a>

        <a href="../controllers/PalestraController.php?page=storico" class="dashboard-card">
            <span class="card-letter">B</span>
            <span class="card-label">Storico Ingressi Cliente</span>
        </a>

        <a href="../controllers/PalestraController.php?page=nuovo" class="dashboard-card">
            <span class="card-letter">C</span>
            <span class="card-label">Nuovo Abbonamento</span>
        </a>

        <a href="../controllers/PalestraController.php?page=disattiva" class="dashboard-card">
            <span class="card-letter">D</span>
            <span class="card-label">Disattiva Abbonamento</span>
        </a>

        <a href="../controllers/PalestraController.php?page=cliente" class="dashboard-card">
            <span class="card-letter">E</span>
            <span class="card-label">Nuovo Cliente</span>
        </a>

    </div>
</div>

<!-- ── Footer ── -->
<div class="footer">
    <span>FitUP</span> Montelabbate
</div>

</body>
</html>
