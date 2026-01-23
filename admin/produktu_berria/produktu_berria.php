<?php
if (!isset($kategoriak)) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Denda</title>
    <style>
    body{font-family:Arial,Helvetica,sans-serif;background:#f8f9fb;color:#222;margin:0;padding:20px}
    h1{color:#222}
    a{color:#007bff}
    label{display:block;margin-bottom:6px}
    input[type="text"],textarea,select{width:100%;padding:8px;border:1px solid #ccc;border-radius:4px}
    input[type="submit"]{background:#007bff;color:#fff;padding:8px 12px;border-radius:4px;border:none}
    </style>
    <script>
        function validarPrezioa(event) {
            const valor = event.target.value;
            event.target.value = valor.replace(/[^0-9.]/g, '');
        }
        
        function validarFormulario(event) {
            const izena = document.getElementById('izena').value.trim();
            const deskribapena = document.getElementById('deskribapena').value.trim();
            const prezioa = document.getElementById('prezioa').value.trim();
            const kategoria_id = document.getElementById('kategoria_id').value.trim();
            
            if (izena === '' || deskribapena === '' || prezioa === '' || kategoria_id === '') {
                alert('Eremu guztiak bete behar dira: Izena, Deskribapena, Prezioa eta Kategoria');
                event.preventDefault();
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <h1>Albistearen administratzio gunexa</h1>
    <p><a href="../index.php">Hasiera</a> &gt;</p>
    <h2>Albisite berria</h2>
    <p><?php echo $mezua ?></p>
    <form action="index.php" method="post" onsubmit="return validarFormulario(event)">
        <p>
            <label for="izena">Izena</label>
            <input type="text" id="izena" name="izena" size="50" maxlength="255" value="<?php echo $izena ?>">
        </p>
        <p>
            <label for="deskribapena">Deskribapena</label>
            <textarea id="deskribapena" name="deskribapena"><?php echo $deskribapena ?></textarea>
        </p>
        <p>
            <label for="prezioa">Prezioa</label>
            <input type="text" id="prezioa" name="prezioa" value="<?php echo $prezioa ?>" oninput="validarPrezioa(event)">
        </p>
        <p>
            <label for="irudia">Irudia</label>
            <select id="irudia" name="irudia">
                <option value="">-- Aukeratu irudia --</option>
                <?php foreach ($irudiak as $irudi_fitxategia): ?>
                    <option value="<?php echo htmlspecialchars($irudi_fitxategia); ?>"<?php if ($irudia == $irudi_fitxategia) echo ' selected'; ?>>
                        <?php echo htmlspecialchars($irudi_fitxategia); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="kategoria_id">Kategoria</label>
            <select id="kategoria_id" name="kategoria_id">
                <option value="">-- Aukeratu kategoria --</option>
                <?php foreach ($kategoriak as $kategoria): ?>
                    <option value="<?php echo htmlspecialchars($kategoria->getId()); ?>"<?php if ($kategoria_id == $kategoria->getId()) echo ' selected'; ?>>
                        <?php echo htmlspecialchars($kategoria->getIzena()); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="ofertas">Ofertan?</label>
            <input type="checkbox" id="ofertas" name="ofertas" value="1"<?php if ($ofertas) echo ' checked'; ?>>
        </p>
        <p>
            <label for="novedades">Berria?</label>
            <input type="checkbox" id="novedades" name="novedades" value="1"<?php if ($novedades) echo ' checked'; ?>>
        </p>
        <p>
            <label for="descuento">Deskontua (%)</label>
            <input type="text" id="descuento" name="descuento" value="<?php echo $descuento ?>" oninput="validarPrezioa(event)">
        </p>
        <p>
            <input type="submit" name="gorde" value="Gorde">
        </p>
    </form>
</body>
</html>