<?php
session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: ../login.php");
    exit;
}

require_once dirname(__DIR__, 2) . '/klaseak/com/leartik/unai/produktuak/produktuak_DB.php';
require_once dirname(__DIR__, 2) . '/klaseak/com/leartik/unai/kategoriak/kategoriak_DB.php';

$mezua = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $izena = trim($_POST['izena'] ?? '');
    $deskribapena = trim($_POST['deskribapena'] ?? '');
    $prezioa = filter_input(INPUT_POST, 'prezioa', FILTER_VALIDATE_FLOAT);
    $irudia = trim($_POST['irudia'] ?? '');
    $kategoria_id = filter_input(INPUT_POST, 'kategoria_id', FILTER_VALIDATE_INT);
    $ofertas = isset($_POST['ofertas']) ? 1 : 0;
    $novedades = isset($_POST['novedades']) ? 1 : 0;

    $descuento_options = [
        'options' => ['min_range' => 0, 'max_range' => 100, 'default' => 0]
    ];
    $descuento = filter_input(INPUT_POST, 'descuento', FILTER_VALIDATE_INT, $descuento_options);

    if ($ofertas == 0) {
        $descuento = 0;
    }

    if ($id && !empty($izena) && $prezioa !== false && $kategoria_id !== false && $descuento !== false) {
        $produktua = new Produktua();
        $produktua->setId($id);
        $produktua->setIzena($izena);
        $produktua->setDeskribapena($deskribapena);
        $produktua->setPrezioa($prezioa);
        $produktua->setIrudia($irudia);
        $produktua->setKategoriaId($kategoria_id);
        $produktua->setOfertas($ofertas);
        $produktua->setNovedades($novedades);
        $produktua->setDescuento($descuento);

        $produktuaDB = new ProduktuaDB();

        if ($produktuaDB->aldatu($produktua)) {
            include 'produktu_gorde_da.php';
            exit;
        }
    }

    $mezua = "Errorea: Datu batzuk ez dira zuzenak. Ziurtatu derrigorrezko eremuak (izena, prezioa, kategoria) ondo beteta daudela eta deskontua 0 eta 100 artean dagoela.";
    

    $produktua = new Produktua();
    $produktua->setId($id);
    $produktua->setIzena($izena);
    $produktua->setDeskribapena($deskribapena);
    $produktua->setPrezioa($prezioa !== false ? $prezioa : 0);
    $produktua->setIrudia($irudia);
    $produktua->setKategoriaId($kategoria_id);
    $produktua->setOfertas($ofertas);
    $produktua->setNovedades($novedades);
    $produktua->setDescuento($descuento !== false ? $descuento : 0);

} else { 
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if (!$id) { include 'produktu_id_baliogabea.php'; exit; }

    $produktuaDB = new ProduktuaDB();
    $produktua = $produktuaDB->getProduktuaById($id);
    if (!$produktua) { include 'produktu_id_baliogabea.php'; exit; }
}

$kategoriaDB = new KategoriaDB();
$kategoriak = $kategoriaDB->getKategoriak();
$irudiak = array_diff(scandir(dirname(__DIR__, 2) . '/img/'), ['.', '..']);
include 'produktu_aldatu.php';
?>