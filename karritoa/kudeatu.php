<?php
define('PROJECT_ROOT', dirname(__DIR__));
require_once PROJECT_ROOT . '/klaseak/com/leartik/unai/eskariak/Eskaria.php';
require_once PROJECT_ROOT . '/klaseak/com/leartik/unai/eskariak/EskariaDB.php';
require_once PROJECT_ROOT . '/klaseak/com/leartik/unai/produktuak/produktuak_DB.php';
require_once PROJECT_ROOT . '/klaseak/com/leartik/unai/eskariak/Saskia.php';
require_once PROJECT_ROOT . '/klaseak/com/leartik/unai/eskariak/Detailea.php';
require_once PROJECT_ROOT . '/klaseak/com/leartik/unai/bezeroak/Bezeroa.php';

session_start();

if (!isset($_SESSION['saskia'])) {
    $_SESSION['saskia'] = new Saskia();
}

$saskia = $_SESSION['saskia'];
$action = $_POST['action'] ?? '';

try {
    if ($action === 'add') {

        $id = (int) $_POST['id'];
        $kantitatea = (int) ($_POST['kantitatea'] ?? 1);

        $produktuaDB = new ProduktuaDB();
        $prod = $produktuaDB->getProduktuaById($id);

        if ($prod) {
            $detailea = new Detailea();
            $detailea->setProduktua($prod);
            $detailea->setKopurua($kantitatea);
            $saskia->detaileaGehitu($detailea);
            $_SESSION['saskia'] = $saskia;
        }

        if (isset($_SERVER['HTTP_REFERER'])) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
        } else {
            header("Location: index.php");
        }
        exit;

    } elseif ($action === 'remove') {
        $id = (int) $_POST['id'];

        $produktuaDB = new ProduktuaDB();
        $prod = $produktuaDB->getProduktuaById($id);

        $produktuaRef = new Produktua();
        $produktuaRef->setId($id);
        $detaileaRef = new Detailea();
        $detaileaRef->setProduktua($produktuaRef);

        $saskia->detaileaEzabatu($detaileaRef);
        $_SESSION['saskia'] = $saskia;

        header("Location: index.php");
        exit;

    } elseif ($action === 'update') {
        $id = (int) $_POST['id'];
        $kantitatea = (int) $_POST['kantitatea'];

        if ($kantitatea > 0) {
            $produktuaRef = new Produktua();
            $produktuaRef->setId($id);
            $detaileaRef = new Detailea();
            $detaileaRef->setProduktua($produktuaRef);
            $detaileaRef->setKopurua($kantitatea);

            $saskia->detaileaAldatu($detaileaRef);
        } else {

            $produktuaRef = new Produktua();
            $produktuaRef->setId($id);
            $detaileaRef = new Detailea();
            $detaileaRef->setProduktua($produktuaRef);
            $saskia->detaileaEzabatu($detaileaRef);
        }
        $_SESSION['saskia'] = $saskia;
        header("Location: index.php");
        exit;

    } elseif ($action === 'checkout') {
        $izena = trim($_POST['izena'] ?? '');
        $abizenak = trim($_POST['abizenak'] ?? '');
        $helbidea = trim($_POST['helbidea'] ?? '');
        $herria = trim($_POST['herria'] ?? '');
        $postaKodea = (int) ($_POST['postaKodea'] ?? 0);
        $probintzia = trim($_POST['probintzia'] ?? '');
        $emaila = trim($_POST['emaila'] ?? '');

        if (empty($izena) || empty($abizenak) || empty($helbidea) || empty($herria) || empty($postaKodea) || empty($probintzia) || empty($emaila)) {
            $_SESSION['checkout_error'] = 'Beharrezko datuak falta dira. Mesedez, bete eremu guztiak: Izena, Abizenak, Helbidea, Herria, Posta Kodea, Probintzia eta Emaila.';
            header("Location: index.php");
            exit;
        }

        if ($saskia->getDetaileKopurua() == 0) {
            $_SESSION['checkout_error'] = 'Saskia hutsik dago.';
            header("Location: index.php");
            exit;
        }


        $bezeroa = new Bezeroa();
        $bezeroa->setIzena($izena);
        $bezeroa->setAbizenak($abizenak);
        $bezeroa->setHelbidea($helbidea);
        $bezeroa->setHerria($herria);
        $bezeroa->setPostaKodea($postaKodea);
        $bezeroa->setProbintzia($probintzia);
        $bezeroa->setEmaila($emaila);

        $eskaria = new Eskaria();
        $eskaria->setData(date("Y-m-d H:i:s"));
        $eskaria->setBezeroa($bezeroa);
        $eskaria->setDetaileak($saskia->getDetaileak());

        $eskariaDB = new EskariaDB();
        $id = $eskariaDB->insertEskaria($eskaria);

        if ($id > 0) {
            $_SESSION['saskia'] = new Saskia();
            $_SESSION['checkout_success'] = 'Eskaria ondo jaso da! Kodea: ' . $id;
            header("Location: index.php");
            exit;
        } else {
            $_SESSION['checkout_error'] = 'Errorea datu-basean gordetzean.';
            header("Location: index.php");
            exit;
        }
    }

} catch (Exception $e) {
    die("Errorea: " . $e->getMessage());
}
?>