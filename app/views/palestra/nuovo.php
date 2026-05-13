<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitUP Montelabbate — Nuovo Abbonamento</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>

<div class="navbar">
    <span class="brand">FIT<span>UP</span></span>
    <span class="info">Montelabbate · Via Bellini, 25 · Aperto 24/7</span>
</div>

<div class="main-content">
    <a href="../controllers/PalestraController.php" class="back-link">← Torna alla Dashboard</a>
    <h1>C — Nuovo Abbonamento</h1>

    <div class="form-container">
        <form method="POST" action="../controllers/PalestraController.php?page=nuovo">
            <label>Cliente:
                <select name="id_cliente" required>
                    <option value="">-- Seleziona cliente --</option>
                    <?php while ($c = mysqli_fetch_assoc($listaClienti)): ?>
                        <option value="<?php echo $c['id_cliente']; ?>">
                            <?php echo htmlspecialchars($c['cognome'] . ' ' . $c['nome']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </label>
            <label>Tipo abbonamento:
                <select name="id_tipo" required>
                    <option value="">-- Seleziona tipo --</option>
                    <?php while ($t = mysqli_fetch_assoc($listaTipi)): ?>
                        <option value="<?php echo $t['id_tipo']; ?>">
                            <?php echo htmlspecialchars(
                                $t['nome'] . ' — ' . $t['durata_gg'] . ' gg — ' .
                                number_format($t['prezzo'], 2, ',', '.') . ' €'
                            ); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </label>
            <label>Data inizio:
                <input type="date" name="data_inizio"
                       min="<?php echo date('Y-m-d'); ?>"
                       value="<?php echo date('Y-m-d'); ?>" required>
            </label>
            <input type="submit" value="Registra Abbonamento">
        </form>
    </div>

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
