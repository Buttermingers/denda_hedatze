<?php
require_once dirname(__DIR__) . '/klaseak/com/leartik/unai/kategoriak/kategoriak.php';
require_once dirname(__DIR__) . '/klaseak/com/leartik/unai/kategoriak/kategoriak_DB.php';

$kategoriaDB = new KategoriaDB();
$kategoriak = $kategoriaDB->getKategoriak();
?>

<h2>Kategorien Kudeaketa</h2>
<p><a href="kategoria_berria/index.php">Kategoria berria gehitu</a></p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Izena</th>
                <th>Laburpena</th>
                <th>Ekintzak</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($kategoriak as $kategoria): ?>
                <tr>
                    <td><?php echo htmlspecialchars($kategoria->getId()); ?></td>
                    <td><?php echo htmlspecialchars($kategoria->getIzena()); ?></td>
                    <td><?php echo htmlspecialchars($kategoria->getLaburpena()); ?></td>
                    <td>
                        <a href="kategoria_aldatu/index.php?id=<?php echo $kategoria->getId(); ?>">Aldatu</a> |
                        <a href="kategoria_ezabatu/index.php?id=<?php echo $kategoria->getId(); ?>">Ezabatu</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
