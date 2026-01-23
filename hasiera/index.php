<?php
define('PROJECT_ROOT', dirname(__DIR__));

$page_title = 'Denda - Hasiera';
$page_css = 'styleFlexbox.css';

require_once '../includes/header.php';

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
$apiPath = dirname($scriptDir) . '/api/hasiera.php';
$apiUrl = $protocol . $host . $apiPath;

$jsonData = @file_get_contents($apiUrl);
$ofertak = [];
$berriak = [];

if ($jsonData !== false) {
    $data = json_decode($jsonData, true);
    if (isset($data['ofertak'])) {
        $ofertak = $data['ofertak'];
    }
    if (isset($data['berriak'])) {
        $berriak = $data['berriak'];
    }
}
?>

<section class="katalogo-atalak">
    <div class="katalogo-edukia">
        <h2>⭐ Azken Eskaintzak</h2>
        <div class="sareko-produktuak" id="ofertak-container">
            <?php if (empty($ofertak)): ?>
                <p>Ez dago produkturik momentu honetan.</p>
            <?php else: ?>
                <?php foreach ($ofertak as $prod): ?>
                    <div class="produktu-txartelak">
                        <a href="../katalogoa/produktua_erakutsi.php?id=<?php echo $prod['id']; ?>">
                            <img src="../img/<?php echo htmlspecialchars($prod['irudia']); ?>"
                                alt="<?php echo htmlspecialchars($prod['izena']); ?>">
                            <h3><?php echo htmlspecialchars($prod['izena']); ?></h3>
                            <p class="prezioa"><?php echo number_format($prod['prezioa'], 2); ?>€</p>
                            <?php if ($prod['descuento'] > 0): ?>
                                <p class="deskontua"><?php echo htmlspecialchars($prod['descuento']); ?>% deskontua</p>
                            <?php endif; ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="katalogo-edukia">
        <h2>🆕 Produktu Berriak</h2>
        <div class="sareko-produktuak" id="berriak-container">
            <?php if (empty($berriak)): ?>
                <p>Ez dago produkturik momentu honetan.</p>
            <?php else: ?>
                <?php foreach ($berriak as $prod): ?>
                    <div class="produktu-txartelak">
                        <a href="../katalogoa/produktua_erakutsi.php?id=<?php echo $prod['id']; ?>">
                            <img src="../img/<?php echo htmlspecialchars($prod['irudia']); ?>"
                                alt="<?php echo htmlspecialchars($prod['izena']); ?>">
                            <h3><?php echo htmlspecialchars($prod['izena']); ?></h3>
                            <p class="prezioa"><?php echo number_format($prod['prezioa'], 2); ?>€</p>
                            <?php if ($prod['descuento'] > 0): ?>
                                <p class="deskontua"><?php echo htmlspecialchars($prod['descuento']); ?>% deskontua</p>
                            <?php endif; ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>