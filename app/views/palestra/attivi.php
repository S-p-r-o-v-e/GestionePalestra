<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitUP Montelabbate — Clienti Attivi</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>

<div class="navbar">
    <span class="brand">FIT<span>UP</span></span>
    <span class="info">Montelabbate · Via Bellini, 25 · Aperto 24/7</span>
</div>

<div class="main-content">
    <a href="../controllers/PalestraController.php" class="back-link">← Torna alla Dashboard</a>
    <h1>A — Clienti Abbonati Attivi</h1>

    <?php
    $righe = [];
    while ($r = mysqli_fetch_assoc($risultato)) {
        $righe[] = $r;
    }
    ?>

    <?php if (!empty($righe)): ?>
        <h2><?php echo count($righe); ?> clienti con abbonamento attivo</h2>
        <table>
            <tr>
                <th>Cognome</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefono</th>
                <th>Tipo Abbonamento</th>
                <th>Inizio</th>
                <th>Scadenza</th>
                <th>Stato</th>
            </tr>
            <?php foreach ($righe as $c): ?>
            <tr>
                <td><?php echo htmlspecialchars($c['cognome']); ?></td>
                <td><?php echo htmlspecialchars($c['nome']); ?></td>
                <td><?php echo htmlspecialchars($c['email']); ?></td>
                <td><?php echo htmlspecialchars($c['telefono']); ?></td>
                <td><?php echo htmlspecialchars($c['tipo_abbonamento']); ?></td>
                <td><?php echo htmlspecialchars($c['data_inizio']); ?></td>
                <td><?php echo htmlspecialchars($c['data_fine']); ?></td>
                <td>
                    <?php
                    $oggi_ts     = strtotime(date('Y-m-d'));
                    $scadenza_ts = strtotime($c['data_fine']);
                    $giorni      = (int)(($scadenza_ts - $oggi_ts) / 86400);
                    if ($giorni < 0): ?>
                        <span class="badge-scaduto">Scaduto</span>
                    <?php elseif ($giorni <= 7): ?>
                        <span class="badge-in-scadenza">In scadenza (<?php echo $giorni; ?>gg)</span>
                    <?php else: ?>
                        <span class="badge-attivo">Attivo</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p class="msg-err">Nessun cliente con abbonamento attivo.</p>
    <?php endif; ?>
</div>

<!-- ── Footer ── -->
<div class="footer">
    <span>FitUP</span> Montelabbate
</div>

</body>
</html>
