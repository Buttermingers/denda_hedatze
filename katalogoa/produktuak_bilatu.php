<?php
require_once dirname(__DIR__) . '/klaseak/com/leartik/unai/produktuak/produktuak_DB.php';

$term = isset($_GET['q']) ? $_GET['q'] : '';

$produktuaDB = new ProduktuaDB();

if (!empty($term)) {
    $produktuak = $produktuaDB->searchProduktuak($term);
} else {
    $produktuak = $produktuaDB->getProduktuak();
}

$response = [];
foreach ($produktuak as $produktua) {
    $response[] = $produktua->toArray();
}

header('Content-Type: application/json');
echo json_encode($response);
?>