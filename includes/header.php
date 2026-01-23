<?php
$page_title = $page_title ?? 'Denda';
$page_css = $page_css ?? 'styleFlexbox.css';
?><!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link rel="stylesheet" href="/denda/css/style.css">
</head>
<body>
    <header>
        <h1>Denda</h1>
    </header>
    <nav>
        <ul>
            <li><a href="/denda/hasiera/index.php">Hasiera</a></li>
            <li><a href="/denda/katalogoa/">Katalogoa</a></li>
            <li><a href="/denda/mezuak/index.php">Kontaktua</a></li> 
            <li><a href="/denda/karritoa/index.php">Karritoa</a></li> 
            <li><a href="/denda/mediateka/index.php">Mediateka</a></li> 
        </ul>
    </nav>
    <main>
