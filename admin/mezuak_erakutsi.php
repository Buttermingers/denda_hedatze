<?php
require_once __DIR__ . '/../klaseak/com/leartik/unai/mezuak/mezuak.php';
require_once __DIR__ . '/../klaseak/com/leartik/unai/mezuak/mezuaDB.php';

$mezuaDB = new MezuaDB();
$mezuak = $mezuaDB->getMezuak();
?>

<h2>Mezuen Kudeaketa</h2>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Izena</th>
            <th>Emaila</th>
            <th>Mezua</th>
            <th>Erantzunda</th>
            <th>Ekintzak</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($mezuak as $mezua): ?>
            <tr>
                <td><?php echo htmlspecialchars($mezua->getId()); ?></td>
                <td><?php echo htmlspecialchars($mezua->getIzena()); ?></td>
                <td><?php echo htmlspecialchars($mezua->getEmaila()); ?></td>
                <td><?php echo nl2br(htmlspecialchars($mezua->getMezua())); ?></td>
                <td><?php echo $mezua->getErantzunda() ? 'Bai' : 'Ez'; ?></td>
                <td>
                    <a href="mezua_aldatu/index.php?id=<?php echo $mezua->getId(); ?>">Aldatu</a> |
                    <a href="mezua_ezabatu/index.php?id=<?php echo $mezua->getId(); ?>" >Ezabatu</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
