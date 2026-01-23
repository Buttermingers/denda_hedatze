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
    <title>Mezua Aldatu - Denda</title>
    <style>
    body{font-family:Arial,Helvetica,sans-serif;background:#f8f9fb;color:#222;margin:0;padding:20px}
    h1{color:#222}
    a{color:#007bff}
    .error{color:#900}
    form { max-width: 600px; margin-top: 20px; }
    label { display: block; margin-bottom: 5px; font-weight: bold; }
    input[type="text"], input[type="email"], textarea { width: 100%; padding: 8px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
    input[type="checkbox"] { margin-bottom: 15px; }
    input[type="submit"] { background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
    input[type="submit"]:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <h1>Mezua Aldatu</h1>
    
    <form action="index.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($mezua->getId()); ?>">
        
        <label for="izena">Izena:</label>
        <input type="text" id="izena" name="izena" value="<?php echo htmlspecialchars($mezua->getIzena()); ?>" required>
        
        <label for="emaila">Emaila:</label>
        <input type="email" id="emaila" name="emaila" value="<?php echo htmlspecialchars($mezua->getEmaila()); ?>" required>
        
        <label for="mezua">Mezua:</label>
        <textarea id="mezua" name="mezua" rows="5" required><?php echo htmlspecialchars($mezua->getMezua()); ?></textarea>
        
        <label>
            <input type="checkbox" name="erantzunda" <?php echo $mezua->getErantzunda() ? 'checked' : ''; ?>>
            Erantzunda
        </label>
        
        <input type="submit" value="Gorde Aldaketak">
    </form>
    <br>
    <p><a href="../index.php">Utzi eta itzuli</a></p>
</body>
</html>
