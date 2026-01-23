<?php
if (!isset($kategoria)) {
    echo "<p>Kategoriaren datuak ez dira aurkitu.</p>";
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
    label{display:block;margin-bottom:6px}
    input[type="text"],textarea{width:100%;padding:8px;border:1px solid #ccc;border-radius:4px}
    input[type="submit"]{background:#007bff;color:#fff;padding:8px 12px;border-radius:4px;border:none}
    </style>
</head>
<body>
    <h1>Kategoria Aldatu</h1>
    <form action="index.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($kategoria->getId()); ?>">
        
        <label for="izena">Izena:</label>
        <input type="text" id="izena" name="izena" value="<?php echo htmlspecialchars($kategoria->getIzena()); ?>" required>
        
        <label for="laburpena">Laburpena:</label>
        <textarea id="laburpena" name="laburpena" rows="4"><?php echo htmlspecialchars($kategoria->getLaburpena()); ?></textarea>
        
        <input type="submit" value="Gorde Aldaketak">
    </form>
    <p><a href="../index.php">Atzera</a></p>
</body>
</html>