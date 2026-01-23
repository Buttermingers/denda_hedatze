<?php
if (!isset($produktua) || !isset($kategoriak)) {
    header("Location: index.php");
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
    label{display:block;margin-bottom:6px}
    input[type="text"],input[type="number"],textarea,select{width:100%;padding:8px;border:1px solid #ccc;border-radius:4px}
    input[type="submit"]{background:#007bff;color:#fff;padding:10px 15px;border-radius:4px;border:none;cursor:pointer;margin-top:10px}
    .form-group{margin-bottom:15px}
    .checkbox-group{display:flex;align-items:center;margin-bottom:15px}
    .checkbox-group label{margin-bottom:0;margin-right:10px}
    </style>
    <script>
        function validarFloat(event) {
            const input = event.target;
            input.value = input.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
        }

        function validarInt(event) {
            const input = event.target;
            input.value = input.value.replace(/[^0-9]/g, '');
        }
    </script>
</head>
<body>
    <h1>Produktua Aldatu</h1>
    <form action="index.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($produktua->getId()); ?>">

        <div class="form-group">
            <label for="izena">Izena:</label>
            <input type="text" id="izena" name="izena" value="<?php echo htmlspecialchars($produktua->getIzena()); ?>" required>
        </div>

        <div class="form-group">
            <label for="deskribapena">Deskribapena:</label>
            <textarea id="deskribapena" name="deskribapena" rows="4"><?php echo htmlspecialchars($produktua->getDeskribapena()); ?></textarea>
        </div>

        <div class="form-group">
            <label for="prezioa">Prezioa:</label>
            <input type="text" id="prezioa" name="prezioa" value="<?php echo htmlspecialchars($produktua->getPrezioa()); ?>" oninput="validarFloat(event)" required>
        </div>

        <div class="form-group">
            <label for="irudia">Irudia:</label>
            <select id="irudia" name="irudia">
                <option value="">-- Aukeratu irudia --</option>
                <?php foreach ($irudiak as $irudi_fitxategia): ?>
                    <option value="<?php echo htmlspecialchars($irudi_fitxategia); ?>" <?php echo ($irudi_fitxategia == $produktua->getIrudia()) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($irudi_fitxategia); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="checkbox-group"><label for="ofertas">Ofertan?</label><input type="checkbox" id="ofertas" name="ofertas" value="1" <?php echo $produktua->getOfertas() ? 'checked' : ''; ?>></div>
        <div class="checkbox-group"><label for="novedades">Berria?</label><input type="checkbox" id="novedades" name="novedades" value="1" <?php echo $produktua->getNovedades() ? 'checked' : ''; ?>></div>

        <div class="form-group"><label for="descuento">Deskontua (%):</label><input type="text" id="descuento" name="descuento" value="<?php echo htmlspecialchars($produktua->getDescuento()); ?>" oninput="validarInt(event)"></div>

        <div class="form-group"><label for="kategoria_id">Kategoria:</label><select id="kategoria_id" name="kategoria_id" required><option value="">-- Aukeratu kategoria --</option><?php foreach ($kategoriak as $kategoria): ?><option value="<?php echo htmlspecialchars($kategoria->getId()); ?>" <?php echo ($kategoria->getId() == $produktua->getKategoriaId()) ? 'selected' : ''; ?>><?php echo htmlspecialchars($kategoria->getIzena()); ?></option><?php endforeach; ?></select></div>
        <input type="submit" value="Gorde Aldaketak">
    </form>
    <p><a href="../index.php">Utzi eta zerrendara itzuli</a></p>
</body>
</html>
