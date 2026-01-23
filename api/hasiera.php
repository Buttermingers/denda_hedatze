<?php
header('Content-Type: application/json');

define('PROJECT_ROOT', dirname(__DIR__));
require_once PROJECT_ROOT . '/klaseak/com/leartik/unai/produktuak/produktuak_DB.php';

try {
    $produktuaDb = new ProduktuaDB();
    $ofertak = $produktuaDb->getOfertas();
    $berriak = $produktuaDb->getNovedades();

    $response = [
        'ofertak' => [],
        'berriak' => []
    ];

    foreach ($ofertak as $prod) {
        $response['ofertak'][] = [
            'id' => $prod->getId(),
            'izena' => $prod->getIzena(),
            'prezioa' => $prod->getPrezioa(),
            'irudia' => $prod->getIrudia(),
            'descuento' => $prod->getDescuento()
        ];
    }

    foreach ($berriak as $prod) {
        $response['berriak'][] = [
            'id' => $prod->getId(),
            'izena' => $prod->getIzena(),
            'prezioa' => $prod->getPrezioa(),
            'irudia' => $prod->getIrudia(),
            'descuento' => $prod->getDescuento()
        ];
    }

    echo json_encode($response);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
