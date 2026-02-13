<?php
$page_title = $page_title ?? 'Denda';
$page_css = $page_css ?? 'style.css';
?><!DOCTYPE html>
<html lang="eu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link rel="stylesheet" href="../css/<?php echo htmlspecialchars($page_css); ?>">
    <link rel="icon" type="image/png" href="../mediateka/multimedia/waluigi.png">
</head>

<body>
    <header>
        <h1>Denda</h1>
    </header>
    <nav>
        <ul>
            <li><a href="../hasiera/index.php">Hasiera</a></li>
            <li><a href="../katalogoa/">Katalogoa</a></li>
            <li><a href="../mezuak/index.php">Kontaktua</a></li>
            <li><a href="../karritoa/index.php">Karritoa</a></li>
            <li><a href="../mediateka/index.php">Mediateka</a></li>
            <li><a href="../albisteak/index.php">Albisteak</a></li>
        </ul>
    </nav>
    <main>