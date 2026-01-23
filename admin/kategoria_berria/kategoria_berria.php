<?php

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: ../login.php");
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
    <h1>Kategoria Berria Gehitu</h1>
    <form action="index.php" method="post" onsubmit="return validarFormulario(event)">
        <label for="izena">Izena:</label>
        <input type="text" id="izena" name="izena" >
        <label for="laburpena">Laburpena:</label>
        <textarea id="laburpena" name="laburpena" rows="4" ></textarea>
        <input type="submit" value="Gorde Kategoria">
    </form>
    <p><a href="../index.php">Atzera</a></p>
    <script>
        function validarFormulario(event) {
            var izena = document.getElementById('izena') && document.getElementById('izena').value.trim();
            var laburpena = document.getElementById('laburpena') && document.getElementById('laburpena').value.trim();
            if (!izena || !laburpena) {
                alert('Mesedez, bete itzazu kategoria izena eta laburpena.');
                event.preventDefault();
                return false;
            }
            return true;
        }
    </script>
</body>
</html>