<?php
session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: ../login.php");
    exit;
}

require_once dirname(__DIR__, 2) . '/klaseak/com/leartik/unai/produktuak/produktuak_DB.php';

$produktuaDB = new ProduktuaDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if ($id) {
        
        $db = new PDO('sqlite:' . dirname(__DIR__, 2) . '/db/dendadb.sqlite');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $db->prepare("SELECT COUNT(*) FROM eskaria_detaileak WHERE produktua_id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            
            $errorMessage = "Ezin da produktua ezabatu. $count eskaritan agertzen da.";
            include 'produktu_ez_da_ezabatu.php';
        } else {
            
            if ($produktuaDB->ezabatu($id)) {
                include 'produktu_ezabatu_da.php';
            } else {
                include 'produktu_ez_da_ezabatu.php';
            }
        }
    } else {
        include 'produktu_id_baliogabea.php';
    }


} else {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if (!$id) {
        include 'produktu_id_baliogabea.php';
        exit;
    }

    $produktua = $produktuaDB->getProduktuaById($id);

    if (!$produktua) {
        include 'produktu_id_baliogabea.php';
        exit;
    }

    include 'produktu_ezabatu.php';
}
?>