<?php
if (!isset($produktua)) {
    echo "<p>Produktuaren datuak ez dira aurkitu.</p>";
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
    h1,h2{color:#222}
    a{color:#007bff}
    .error{color:#900}
    </style>
</head>
<body>
    <h1>Produktua Ezabatu</h1>
    <p class="error">Ziur zaude produktu hau ezabatu nahi duzula?</p>
    
    <h2><?php echo htmlspecialchars($produktua->getIzena()); ?></h2>
    <p><?php echo htmlspecialchars($produktua->getDeskribapena()); ?></p>
    
    <form action="index.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($produktua->getId()); ?>">
        <input type="submit" value="Bai, Ezabatu">
    </form>
    <br>
    <p><a href="../index.php">Ez, Utzi</a></p>
</body>
</html>