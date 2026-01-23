<?php
session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: ../login.php");
    exit;
}

require_once dirname(__DIR__, 2) . '/klaseak/com/leartik/unai/eskariak/EskariaDB.php';
require_once dirname(__DIR__, 2) . '/klaseak/com/leartik/unai/eskariak/Eskaria.php';
require_once dirname(__DIR__, 2) . '/klaseak/com/leartik/unai/bezeroak/Bezeroa.php';
require_once dirname(__DIR__, 2) . '/klaseak/com/leartik/unai/eskariak/Detailea.php';
require_once dirname(__DIR__, 2) . '/klaseak/com/leartik/unai/produktuak/produktuak.php';

$eskariaDB = new EskariaDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if ($id) {
        $eskaria = new Eskaria();
        $eskaria->setId($id);
        $eskaria->setData($_POST['data']);

        $bezeroa = new Bezeroa();
        $bezeroa->setIzena($_POST['izena']);
        $bezeroa->setAbizenak($_POST['abizenak']);
        $bezeroa->setHelbidea($_POST['helbidea']);
        $bezeroa->setHerria($_POST['herria']);
        $bezeroa->setPostaKodea($_POST['postaKodea']);
        $bezeroa->setProbintzia($_POST['probintzia']);
        $bezeroa->setEmaila($_POST['emaila']);

        $eskaria->setBezeroa($bezeroa);

        // Handle Details
        $detaileak = [];
        if (isset($_POST['detaileak']) && is_array($_POST['detaileak'])) {
            foreach ($_POST['detaileak'] as $pid => $info) {
                // If marked for Delete, skip adding it
                if (isset($info['ezabatu']) && $info['ezabatu'] == '1') {
                    continue;
                }

                $kopurua = intval($info['kopurua']);
                if ($kopurua > 0) {
                    $prod = new Produktua();
                    $prod->setId($pid); // We only need ID for setting it in DB relations usually

                    $d = new Detailea();
                    $d->setProduktua($prod);
                    $d->setKopurua($kopurua);

                    $detaileak[] = $d;
                }
            }
        }
        $eskaria->setDetaileak($detaileak);

        // We use updateEskaria (Full update) now
        if ($eskariaDB->updateEskaria($eskaria)) {
            header("Location: ../index.php");
            exit;
        } else {
            $error = "Ezin izan da eskaria eguneratu.";
        }
    }
}

// GET or Error handling
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id && isset($_POST['id']))
    $id = $_POST['id'];

if (!$id) {
    die("Ez da IDrik zehaztu.");
}

$eskaria = $eskariaDB->selectEskaria($id);

if (!$eskaria) {
    die("Ez da eskaria aurkitu.");
}

include 'eskaria_aldatu.php';
?>