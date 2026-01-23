<?php
session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: ../login.php");
    exit;
}

require_once dirname(__DIR__, 2) . '/klaseak/com/leartik/unai/eskariak/EskariaDB.php';
require_once dirname(__DIR__, 2) . '/klaseak/com/leartik/unai/eskariak/Eskaria.php';

$eskariaDB = new EskariaDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if ($id) {
        if ($eskariaDB->deleteEskaria($id)) {
            include 'eskaria_ezabatu_da.php';
        } else {
            include 'eskaria_ez_da_ezabatu.php';
        }
    } else {
        include 'eskaria_id_baliogabea.php';
    }

} else {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if (!$id) {
        include 'eskaria_id_baliogabea.php';
        exit;
    }

    $eskaria = $eskariaDB->selectEskaria($id);

    if (!$eskaria) {
        include 'eskaria_id_baliogabea.php';
        exit;
    }

    include 'eskaria_ezabatu.php';
}
?>