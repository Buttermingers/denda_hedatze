<?php
require_once dirname(__DIR__) . '/klaseak/com/leartik/unai/produktuak/produktuak_DB.php';
$produktuaDB = new ProduktuaDB();
$produktuak = $produktuaDB->getProduktuak();
$page_title = 'Produktu Guztiak - Denda';
$page_css = 'styleFlexbox.css';

include '../includes/header.php';
?>

<div class="produktuak-section">
    <h2>Produktu Guztiak</h2>
    <?php if (!empty($produktuak)): ?>
        <div class="sareko-produktuak">
            <?php foreach ($produktuak as $produktua): ?>
                <div class="produktu-txartelak">
                    <a href="produktua_erakutsi.php?id=<?php echo $produktua->getId(); ?>">
                        <img src="../img/<?php echo htmlspecialchars($produktua->getIrudia()); ?>" alt="<?php echo htmlspecialchars($produktua->getIzena()); ?>">
                        <h3><?php echo htmlspecialchars($produktua->getIzena()); ?></h3>
                        <p class="prezioa"><?php echo htmlspecialchars($produktua->getPrezioa()); ?>€</p>
                        <?php if ($produktua->getDescuento() > 0): ?>
                            <p class="deskontua"><?php echo htmlspecialchars($produktua->getDescuento()); ?>% deskontua</p>
                        <?php endif; ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Ez dago produkturik momentu honetan.</p>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
