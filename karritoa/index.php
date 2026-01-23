<?php
require_once '../klaseak/com/leartik/unai/produktuak/produktuak.php';
require_once '../klaseak/com/leartik/unai/produktuak/produktuak_DB.php';
require_once '../klaseak/com/leartik/unai/eskariak/Detailea.php';
require_once '../klaseak/com/leartik/unai/eskariak/Saskia.php';

session_start();

if (!isset($_SESSION['saskia'])) {
    $saskia = new Saskia();
    $_SESSION['saskia'] = $saskia;
} else {
    $saskia = $_SESSION['saskia'];
}

if (isset($_POST['gehitu'])) {
    $id = $_POST['id'];
    $kopurua = $_POST['kopurua'];

    $produktuaDB = new ProduktuaDB();
    $produktua = $produktuaDB->getProduktuaById($id);

    if ($produktua) {
        $detailea = new Detailea();
        $detailea->setProduktua($produktua);
        $detailea->setKopurua($kopurua);

        $saskia->detaileaGehitu($detailea);
        $_SESSION['saskia'] = $saskia;
    }
}

include 'saskia_erakutsi.php';
?>