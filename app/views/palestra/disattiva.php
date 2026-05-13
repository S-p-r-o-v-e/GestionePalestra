<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitUP Montelabbate — Disattiva Abbonamento</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>

<div class="navbar">
    <span class="brand">FIT<span>UP</span></span>
    <span class="info">Montelabbate · Via Bellini, 25 · Aperto 24/7</span>
</div>

<div class="main-content">
    <a href="../controllers/PalestraController.php" class="back-link">← Torna alla Dashboard</a>
    <h1>D — Disattiva Abbonamento</h1>

    <?php
    $righe = [];
    while ($r = mysqli_fetch_assoc($listaAttivi)) { $righe[] = $r; }
    ?>

    <?php if (!empty($righe)): ?>
        <h2>Abbonamenti attivi: <?php echo count($righe); ?></h2>
        <table>
            <tr>
                <th>#</th>
                <th>Cognome</th>
                <th>Nome</th>
                <th>Tipo</th>
                <th>Inizio</th>
                <th>Scadenza</th>
            </tr>
            <?php foreach ($righe as $a): ?>
            <tr>
                <td><?php echo htmlspecialchars($a['id_abbonamento']); ?></td>
                <td><?php echo htmlspecialchars($a['cognome']); ?></td>
                <td><?php echo htmlspecialchars($a['nome']); ?></td>
                <td><?php echo htmlspecialchars($a['tipo']); ?></td>
                <td><?php echo htmlspecialchars($a['data_inizio']); ?></td>
                <td><?php echo htmlspecialchars($a['data_fine']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <div class="form-container">
            <form method="POST" action="../controllers/PalestraController.php?page=disattiva">
                <label>Seleziona abbonamento da disattivare:
                    <select name="id_abbonamento" required>
                        <option value="">-- Seleziona --</option>
                        <?php foreach ($righe as $a): ?>
                            <option value="<?php echo $a['id_abbonamento']; ?>">
                                #<?php echo $a['id_abbonamento']; ?> —
                                <?php echo htmlspecialchars($a['cognome'] . ' ' . $a['nome']); ?> —
                                <?php echo htmlspecialchars($a['tipo']); ?>
                                (scad. <?php echo htmlspecialchars($a['data_fine']); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <input type="submit" value="Disattiva Abbonamento">
            </form>
        </div>
    <?php else: ?>
        <p class="msg-err">Nessun abbonamento attivo da disattivare.</p>
    <?php endif; ?>

    <?php if (!empty($errore)): ?>
        <p class="msg-err"><?php echo htmlspecialchars($errore); ?></p>
    <?php endif; ?>
    <?php if (!empty($successo)): ?>
        <p class="msg-ok"><?php echo htmlspecialchars($successo); ?></p>
    <?php endif; ?>
</div>

<!-- ── Footer ── -->
<div class="footer">
    <span>FitUP</span> Montelabbate
</div>

</body>
</html>
