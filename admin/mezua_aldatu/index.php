<?php
session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: ../login.php");
    exit;
}

require_once dirname(__DIR__, 2) . '/klaseak/com/leartik/unai/mezuak/mezuaDB.php';
require_once dirname(__DIR__, 2) . '/klaseak/com/leartik/unai/mezuak/mezuak.php';

$mezuaDB = new MezuaDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $izena = $_POST['izena'] ?? '';
    $emaila = $_POST['emaila'] ?? '';
    $mezuaText = $_POST['mezua'] ?? '';
    $erantzunda = isset($_POST['erantzunda']);

    if ($id && $izena && $emaila && $mezuaText) {
        $mezua = new Mezua();
        $mezua->setId($id);
        $mezua->setIzena($izena);
        $mezua->setEmaila($emaila);
        $mezua->setMezua($mezuaText);
        $mezua->setErantzunda($erantzunda);

        if ($mezuaDB->eguneratu($mezua)) {
            include 'mezua_aldatu_da.php';
        } else {
            include 'mezua_ez_da_aldatu.php';
        }
    } else {
        include 'mezua_id_baliogabea.php';
    }

} else {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if (!$id) {
        include 'mezua_id_baliogabea.php';
        exit;
    }

    $mezua = $mezuaDB->getMezuaById($id);

    if (!$mezua) {
        include 'mezua_id_baliogabea.php';
        exit;
    }

    include 'mezua_aldatu.php';
}
?>
