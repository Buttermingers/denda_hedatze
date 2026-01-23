<?php
if (!isset($mezua)) {
    echo "<p>Mezuaren datuak ez dira aurkitu.</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denda</title>
    <style>
    body{font-family:Arial,Helvetica,sans-serif;background:#f8f9fb;color:#222;margin:0;padding:20px}
    h1{color:#222}
    a{color:#007bff}
    .error{color:#900}
    </style>
</head>
<body>
    <h1>Mezua Ezabatu</h1>
    <p class="error">Ziur zaude mezua hau ezabatu nahi duzula?</p>
    
    <h2><?php echo htmlspecialchars($mezua->getIzena()); ?></h2>
    <p><?php echo htmlspecialchars($mezua->getMezua()); ?></p>
    
    <form action="index.php" method="post">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($mezua->getId()); ?>">
    <input type="submit" value="Bai, Ezabatu">
</form>
    <br>
    <p><a href="../index.php">Ez, Utzi</a></p>
</body>
</html>
