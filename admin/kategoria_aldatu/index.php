<?php
session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: ../login.php");
    exit;
}

require_once dirname(__DIR__, 2) . '/klaseak/com/leartik/unai/kategoriak/kategoriak_DB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $izena = trim($_POST['izena'] ?? '');
    $laburpena = trim($_POST['laburpena'] ?? '');

    if ($id && !empty($izena)) {
        $kategoria = new Kategoria();
        $kategoria->setId($id);
        $kategoria->setIzena($izena);
        $kategoria->setLaburpena($laburpena);

        $kategoriaDB = new KategoriaDB();

        if ($kategoriaDB->aldatu($kategoria)) {
            include 'kategoria_gorde_da.php';
        } else {
            include 'kategoria_ez_da_gorde.php';
        }
    } else {
        include 'kategoria_ez_da_gorde.php';
    }

} else {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if (!$id) {
        include 'kategoria_id_baliogabea.php';
        exit;
    }

    $kategoriaDB = new KategoriaDB();
    $kategoria = $kategoriaDB->getKategoriaById($id);

    if (!$kategoria) {
        include 'kategoria_id_baliogabea.php';
        exit;
    }

    include 'kategoria_aldatu.php';
}
?>