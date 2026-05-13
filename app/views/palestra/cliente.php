<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitUP Montelabbate — Nuovo Cliente</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>

<div class="navbar">
    <span class="brand">FIT<span>UP</span></span>
    <span class="info">Montelabbate · Via Bellini, 25 · Aperto 24/7</span>
</div>

<div class="main-content">
    <a href="../controllers/PalestraController.php" class="back-link">← Torna alla Dashboard</a>
    <h1>E — Nuovo Cliente</h1>

    <div class="form-container">
        <form method="POST" action="../controllers/PalestraController.php?page=cliente">
            <label>Cognome:
                <input type="text" name="cognome" maxlength="50"
                       value="<?php echo htmlspecialchars($_POST['cognome'] ?? ''); ?>" required>
            </label>
            <label>Nome:
                <input type="text" name="nome" maxlength="50"
                       value="<?php echo htmlspecialchars($_POST['nome'] ?? ''); ?>" required>
            </label>
            <label>Email:
                <input type="text" name="email" maxlength="100"
                       value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
            </label>
            <label>Telefono:
                <input type="text" name="telefono" maxlength="20"
                       value="<?php echo htmlspecialchars($_POST['telefono'] ?? ''); ?>">
            </label>
            <input type="submit" value="Registra Cliente">
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
