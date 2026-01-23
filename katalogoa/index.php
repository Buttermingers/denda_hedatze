<?php
$action = isset($_GET['action']) ? $_GET['action'] : 'kategoriak';

require_once dirname(__DIR__) . '/klaseak/com/leartik/unai/kategoriak/kategoriak_DB.php';
require_once dirname(__DIR__) . '/klaseak/com/leartik/unai/produktuak/produktuak_DB.php';
require_once dirname(__DIR__) . '/klaseak/com/leartik/unai/kategoriak/kategoriak.php';
require_once dirname(__DIR__) . '/klaseak/com/leartik/unai/produktuak/produktuak.php';

switch ($action) {
    case 'kategoriak':
        $kategoriaDB = new KategoriaDB();
        $kategoriak = $kategoriaDB->getKategoriak();
        include 'kategoriak_erakutsi.php';
        break;

    case 'kategoria':
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $kategoria_id = (int) $_GET['id'];
            $kategoriaDB = new KategoriaDB();
            $kategoria = $kategoriaDB->getKategoriaById($kategoria_id);

            if ($kategoria) {
                $produktuaDB = new ProduktuaDB();
                $produktuak = $produktuaDB->getProduktuakByKategoria($kategoria_id);
                include 'kategoria_erakutsi.php';
            } else {
                include 'kategoria_id_baliogabea.php';
            }
        } else {
            include 'kategoria_id_baliogabea.php';
        }
        break;

    case 'produktua':
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $produktua_id = (int) $_GET['id'];
            $produktuaDB = new ProduktuaDB();
            $produktua = $produktuaDB->getProduktuaById($produktua_id);

            if ($produktua) {
                include 'produktua_erakutsi.php';
            } else {
                include 'produktua_id_baliogabea.php';
            }
        } else {
            include 'produktua_id_baliogabea.php';
        }
        break;

    default:
        $kategoriaDB = new KategoriaDB();
        $kategoriak = $kategoriaDB->getKategoriak();
        include 'kategoriak_erakutsi.php';
        break;
}
?>
