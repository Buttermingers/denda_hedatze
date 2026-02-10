<?php


$page_title = htmlspecialchars($produktua->getIzena()) . ' - Denda';
$page_css = 'style.css';

include '../includes/header.php';
?>

<div class="produktu-xehetasunak">
    <div class="produktu-goiburua">
        <h1><?php echo htmlspecialchars($produktua->getIzena()); ?></h1>
    </div>

    <div class="produktu-edukia">
        <div class="produktu-irudia">
            <img src="../img/<?php echo htmlspecialchars($produktua->getIrudia()); ?>"
                alt="<?php echo htmlspecialchars($produktua->getIzena()); ?>">
        </div>

        <div class="produktu-informazioa">
            <div class="info-atalak">
                <strong>Deskribapena</strong>
                <p><?php echo htmlspecialchars($produktua->getDeskribapena()); ?></p>
            </div>

            <div class="info-atalak">
                <strong>Prezioa</strong>
                <p class="prezioa"><?php echo htmlspecialchars($produktua->getPrezioa()); ?>€</p>
            </div>

            <?php if ($produktua->getOfertas()): ?>
                <div class="deskontua-atalak">
                    <strong>⭐ Eskaintza berezia!</strong>
                    <p><?php echo htmlspecialchars($produktua->getDescuento()); ?>% deskontua</p>
                </div>
            <?php endif; ?>

            <div class="info-atalak">
                <?php if (isset($_SESSION['cart_message'])): ?>
                    <div
                        style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px; border-radius: 5px; border: 1px solid #c3e6cb;">
                        <?php
                        echo htmlspecialchars($_SESSION['cart_message']);
                        unset($_SESSION['cart_message']);
                        ?>
                    </div>
                <?php endif; ?>

                <form action="../karritoa/kudeatu.php" method="POST">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="id" value="<?php echo $produktua->getId(); ?>">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <input type="number" name="kantitatea" value="1" min="1" style="width: 60px; padding: 5px;">
                        <button type="submit" class="add-to-cart-btn">🛒 Etxeratu Karritora</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include '../includes/footer.php';
?>