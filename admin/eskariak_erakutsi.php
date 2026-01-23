<?php
require_once dirname(__DIR__) . '/klaseak/com/leartik/unai/eskariak/Eskaria.php';
require_once dirname(__DIR__) . '/klaseak/com/leartik/unai/eskariak/EskariaDB.php';
require_once dirname(__DIR__) . '/klaseak/com/leartik/unai/bezeroak/Bezeroa.php';

$eskariaDB = new EskariaDB();
$eskariak = $eskariaDB->selectEskariak();
?>

<h2>Eskarien Kudeaketa</h2>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Data</th>
            <th>Izena</th>
            <th>Emaila</th>
            <th>Eskaria (Produktuak)</th>
            <th>Ekintzak</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($eskariak as $eskaria): 
            $bezeroa = $eskaria->getBezeroa();
            $detaileakText = "";
            $totala = 0;
            foreach ($eskaria->getDetaileak() as $d) {
                $p = $d->getProduktua();
                $subtotal = $d->getGuztira();
                $totala += $subtotal;
                $detaileakText .= $d->getKopurua() . "x " . ($p->getIzena() ?? 'Produktua #' . $p->getId()) . "<br>";
            }
            $detaileakText .= "<strong>Guztira: " . number_format($totala, 2) . "€</strong>";
        ?>
            <tr>
                <td><?php echo htmlspecialchars($eskaria->getId()); ?></td>
                <td><?php echo htmlspecialchars($eskaria->getData()); ?></td>
                <td><?php echo htmlspecialchars($bezeroa->getIzena() . " " . $bezeroa->getAbizenak()); ?></td>
                <td><?php echo htmlspecialchars($bezeroa->getEmaila()); ?></td>
                <td><?php echo $detaileakText; ?></td>
                <td>
                    <a href="eskaria_aldatu/index.php?id=<?php echo $eskaria->getId(); ?>">Aldatu</a> |
                    <a href="eskaria_ezabatu/index.php?id=<?php echo $eskaria->getId(); ?>" >Ezabatu</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
