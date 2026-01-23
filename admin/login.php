<?php
session_start();

$erabiltzailea = $_POST['erabiltzailea'] ?? null;
$pasahitza = $_POST['pasahitza'] ?? null;

if ($erabiltzailea === 'admin' && $pasahitza === 'admin') {
    $_SESSION['admin'] = true;
    header('Location: index.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <title>Denda</title>
    <style>
    body{font-family:Arial,Helvetica,sans-serif;background:#f8f9fb;color:#222;margin:0;padding:20px}
    form{max-width:420px;margin:18px 0}
    label{display:block;margin-bottom:6px}
    input[type="text"],input[type="password"]{width:100%;padding:8px;border:1px solid #ccc;border-radius:4px}
    input[type="submit"]{background:#007bff;color:#fff;padding:8px 12px;border-radius:4px;border:none}
    </style>
</head>
<body>

<?php if (isset($erabiltzailea)): ?>
    <div class="flash error">Erabiltzaile edo pasahitz okerra.</div>
<?php endif; ?>

<form action="login.php" method="post">
    <label for="erabiltzailea">Erabiltzailea:</label>
    <input type="text" id="erabiltzailea" name="erabiltzailea">
    <label for="pasahitza">Pasahitza:</label>
    <input type="password" id="pasahitza" name="pasahitza">
    <input type="submit" value="Sartu">
</form>

</body>
</html>
