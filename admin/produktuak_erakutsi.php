<?php
require_once dirname(__DIR__) . '/klaseak/com/leartik/unai/produktuak/produktuak.php';
require_once dirname(__DIR__) . '/klaseak/com/leartik/unai/produktuak/produktuak_DB.php';

$produktuaDB = new ProduktuaDB();
$produktuak = $produktuaDB->getProduktuak();
?>

<h2>Produktuen Kudeaketa</h2>
<p><a href="produktu_berria/index.php">Produktu berria gehitu</a></p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Izena</th>
                <th>Deskribapena</th>
                <th>Prezioa</th>
                <th>Irudia</th>
                <th>Kategoria ID</th>
                <th>Ofertan</th>
                <th>Berria</th>
                <th>Deskontua (%)</th>
                <th>Ekintzak</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produktuak as $produktua): ?>
                <tr>
                    <td><?php echo htmlspecialchars($produktua->getId()); ?></td>
                    <td><?php echo htmlspecialchars($produktua->getIzena()); ?></td>
                    <td><?php echo htmlspecialchars($produktua->getDeskribapena()); ?></td>
                    <td><?php echo htmlspecialchars($produktua->getPrezioa()); ?></td>
                    <td><?php echo htmlspecialchars($produktua->getIrudia()); ?></td>
                    <td><?php echo htmlspecialchars($produktua->getKategoriaId()); ?></td>
                    <td><?php echo $produktua->getOfertas() ? 'Bai' : 'Ez'; ?></td>
                    <td><?php echo $produktua->getNovedades() ? 'Bai' : 'Ez'; ?></td>
                    <td><?php echo htmlspecialchars($produktua->getDescuento()); ?></td>
                    <td>
                        <a href="produktu_aldatu/index.php?id=<?php echo $produktua->getId(); ?>">Aldatu</a> |
                        <a href="produktu_ezabatu/index.php?id=<?php echo $produktua->getId(); ?>">Ezabatu</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
