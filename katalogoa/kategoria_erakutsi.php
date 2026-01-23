<?php

$page_title = htmlspecialchars($kategoria->getIzena()) . ' - Denda';
$page_css = 'styleKategoriaFlex.css';

include '../includes/header.php';
?>

<div class="kategoria-detail">
    <h1><?php echo htmlspecialchars($kategoria->getIzena()); ?></h1>
    <p class="kategoria-laburpena"><?php echo htmlspecialchars($kategoria->getLaburpena()); ?></p>

    <div class="kategoria-produktuak">
        <h2>Kategoria honetako produktuak</h2>
        <?php if (!empty($produktuak)): ?>
            <div class="sareko-produktuak">
                <?php foreach ($produktuak as $produktua): ?>
                    <div class="produktu-txartelak">
                        <a href="index.php?action=produktua&id=<?php echo $produktua->getId(); ?>">
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
            <p>Kategoria honek ez du produkturik momentu honetan.</p>
        <?php endif; ?>
    </div>
</div>

<?php
include '../includes/footer.php';
?>
