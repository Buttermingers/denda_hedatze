<?php
session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: ../login.php");
    exit;
}

require_once dirname(__DIR__, 2) . '/klaseak/com/leartik/unai/kategoriak/kategoriak_DB.php';

$kategoriaDB = new KategoriaDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if ($id) {
        if ($kategoriaDB->ezabatu($id)) {
            include 'kategoria_ezabatu_da.php';
        } else {
            include 'kategoria_ez_da_ezabatu.php';
        }
    } else {
        include 'kategoria_id_baliogabea.php';
    }

} else {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if (!$id) {
        include 'kategoria_id_baliogabea.php';
        exit;
    }

    $kategoria = $kategoriaDB->getKategoriaById($id);

    if (!$kategoria) {
        include 'kategoria_id_baliogabea.php';
        exit;
    }

    include 'kategoria_ezabatu.php';
}
?>