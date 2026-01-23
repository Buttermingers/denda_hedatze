<?php
session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: ../login.php");
    exit;
}

require_once dirname(__DIR__, 2) . '/klaseak/com/leartik/unai/kategoriak/kategoriak_DB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $izena = trim($_POST['izena'] ?? '');
    $laburpena = trim($_POST['laburpena'] ?? '');

    if (!empty($izena)) {
        $kategoria = new Kategoria();
        $kategoria->setIzena($izena);
        $kategoria->setLaburpena($laburpena);

        $kategoriaDB = new KategoriaDB();
        
        if ($kategoriaDB->gehitu($kategoria)) {
            include 'kategoria_gorde_da.php';
        } else {
            include 'kategoria_ez_da_gorde.php';
        }
    } else {
        include 'kategoria_ez_da_gorde.php';
    }
} else {
    include 'kategoria_berria.php';
}
?>