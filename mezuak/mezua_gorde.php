<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../klaseak/com/leartik/unai/mezuak/mezuak.php';
require_once __DIR__ . '/../klaseak/com/leartik/unai/mezuak/mezuaDB.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Metodo ezegokia.']);
    exit;
}

$izena = trim($_POST['izena'] ?? '');
$emaila = trim($_POST['emaila'] ?? '');
$mezuaText = trim($_POST['mezua'] ?? '');

if (empty($izena) || empty($emaila) || empty($mezuaText)) {
    echo json_encode(['success' => false, 'message' => 'Eremu guztiak bete behar dira.']);
    exit;
}

try {
    $mezuaDB = new MezuaDB();
    $mezua = new Mezua();
    $mezua->setIzena($izena);
    $mezua->setEmaila($emaila);
    $mezua->setMezua($mezuaText);
    $mezua->setErantzunda(false);

    if ($mezuaDB->gehitu($mezua)) {
        echo json_encode(['success' => true, 'message' => 'Zure mezua ondo bidali da! Eskerrik asko.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Errore bat gertatu da mezua bidaltzean.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Zerbitzari errorea: ' . $e->getMessage()]);
}
exit;
?>