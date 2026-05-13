<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitUP Montelabbate — Storico Ingressi</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>

<div class="navbar">
    <span class="brand">FIT<span>UP</span></span>
    <span class="info">Montelabbate · Via Bellini, 25 · Aperto 24/7</span>
</div>

<div class="main-content">
    <a href="../controllers/PalestraController.php" class="back-link">← Torna alla Dashboard</a>
    <h1>B — Storico Ingressi Cliente</h1>

    <div class="form-container">
        <form method="POST" action="../controllers/PalestraController.php?page=storico">
            <label>Cliente:
                <select name="id_cliente" required>
                    <option value="">-- Seleziona cliente --</option>
                    <?php while ($c = mysqli_fetch_assoc($listaClienti)): ?>
                        <option value="<?php echo $c['id_cliente']; ?>"
                            <?php if ($c['id_cliente'] == $id_cliente) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($c['cognome'] . ' ' . $c['nome']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </label>
            <label>Data inizio:
                <input type="date" name="data_inizio"
                       value="<?php echo htmlspecialchars($data_inizio); ?>" required>
            </label>
            <label>Data fine:
                <input type="date" name="data_fine"
                       value="<?php echo htmlspecialchars($data_fine); ?>" required>
            </label>
            <input type="submit" value="Cerca Ingressi">
        </form>
    </div>

    <?php if (!empty($errore)): ?>
        <p class="msg-err"><?php echo htmlspecialchars($errore); ?></p>
    <?php endif; ?>

    <?php if ($cercato && empty($errore)): ?>
        <?php
        $righe = [];
        while ($r = mysqli_fetch_assoc($risultato)) { $righe[] = $r; }
        ?>
        <?php if (!empty($righe)): ?>
            <h2><?php echo count($righe); ?> ingresso/i trovati</h2>
            <table>
                <tr>
                    <th>#</th>
                    <th>Cognome</th>
                    <th>Nome</th>
                    <th>Tipo Abbonamento</th>
                    <th>Data Ingresso</th>
                </tr>
                <?php foreach ($righe as $i): ?>
                <tr>
                    <td><?php echo htmlspecialchars($i['id_ingresso']); ?></td>
                    <td><?php echo htmlspecialchars($i['cognome']); ?></td>
                    <td><?php echo htmlspecialchars($i['nome']); ?></td>
                    <td><?php echo htmlspecialchars($i['tipo_abbonamento']); ?></td>
                    <td><?php echo htmlspecialchars($i['data_ingresso']); ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p class="msg-err">Nessun ingresso trovato nel periodo selezionato.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>

<!-- ── Footer ── -->
<div class="footer">
    <span>FitUP</span> Montelabbate
</div>

</body>
</html>
