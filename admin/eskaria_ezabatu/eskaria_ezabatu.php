<?php
if (!isset($eskaria)) {
    echo "<p>Eskariaren datuak ez dira aurkitu.</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="eu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eskaria Ezabatu - Denda</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f8f9fb;
            color: #222;
            margin: 0;
            padding: 20px
        }

        h1 {
            color: #222
        }

        a {
            color: #007bff
        }

        .error {
            color: #900
        }
    </style>
</head>

<body>
    <h1>Eskaria Ezabatu</h1>
    <p class="error">Ziur zaude eskaria hau ezabatu nahi duzula?</p>

    <?php $bezeroa = $eskaria->getBezeroa(); ?>
    <h2><?php echo htmlspecialchars($bezeroa->getIzena() . ' ' . $bezeroa->getAbizenak()); ?></h2>

    <p><strong>Eskariaren Edukia:</strong></p>
    <ul>
        <?php
        $totala = 0;
        foreach ($eskaria->getDetaileak() as $d) {
            $p = $d->getProduktua();
            $totala += $d->getGuztira();
            echo "<li>" . $d->getKopurua() . "x " . htmlspecialchars($p->getIzena() ?? 'Produktua #' . $p->getId()) . "</li>";
        }
        ?>
    </ul>
    <p><strong>Guztira: <?php echo number_format($totala, 2); ?> €</strong></p>

    <form action="index.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($eskaria->getId()); ?>">
        <input type="submit" value="Bai, Ezabatu">
    </form>
    <br>
    <p><a href="../index.php">Ez, Utzi</a></p>
</body>

</html>