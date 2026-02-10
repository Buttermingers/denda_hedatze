<?php
$page_title = 'Saskia - Denda';
include '../includes/header.php';
?>

<div class="saskia-container">
    <div class="saskia-header">
        <h2>Zure Saskia</h2>
    </div>

    <?php if (isset($_SESSION['checkout_success'])): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($_SESSION['checkout_success']); ?>
        </div>
        <?php unset($_SESSION['checkout_success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['checkout_error'])): ?>
        <div class="alert alert-error">
            <?php echo htmlspecialchars($_SESSION['checkout_error']); ?>
        </div>
        <?php unset($_SESSION['checkout_error']); ?>
    <?php endif; ?>

    <?php if (!empty($saskia) && $saskia->getDetaileKopurua() > 0): ?>
        <div class="saskia-grid">
            <div class="saskia-items">
                <table class="saskia-table">
                    <thead>
                        <tr>
                            <th>Produktua</th>
                            <th>Prezioa</th>
                            <th>Kopurua</th>
                            <th>Guztira</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($saskia->getDetaileak() as $detailea):
                            $produktua = $detailea->getProduktua();
                            ?>
                            <tr>
                                <td class="product-name">
                                    <span><?php echo htmlspecialchars($produktua->getIzena()); ?></span>
                                </td>
                                <td class="product-price"><?php echo number_format($produktua->getPrezioa(), 2); ?> €</td>
                                <td class="product-quantity">
                                    <form action="../karritoa/kudeatu.php" method="POST" class="quantity-form">
                                        <input type="hidden" name="action" value="update">
                                        <input type="hidden" name="id" value="<?php echo $produktua->getId(); ?>">
                                        <input type="number" name="kantitatea" value="<?php echo $detailea->getKopurua(); ?>"
                                            min="1" class="qty-input">
                                        <button type="submit" class="btn-update" title="Eguneratu">↻</button>
                                    </form>
                                </td>
                                <td class="product-total"><?php echo number_format($detailea->getGuztira(), 2); ?> €</td>
                                <td class="product-remove">
                                    <form action="../karritoa/kudeatu.php" method="POST" class="remove-form">
                                        <input type="hidden" name="action" value="remove">
                                        <!-- Assumes there is a remove action, if not, update logic later -->
                                        <input type="hidden" name="id" value="<?php echo $produktua->getId(); ?>">
                                        <button type="submit" class="btn-remove" title="Ezabatu">×</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="saskia-summary">
                <h3>Eskariaren Laburpena</h3>
                <div class="summary-row total">
                    <span>Guztira:</span>
                    <span><?php echo number_format($saskia->getGuztira(), 2); ?> €</span>
                </div>

                <form action="../karritoa/kudeatu.php" method="POST" class="checkout-form">
                    <input type="hidden" name="action" value="checkout">
                    <h4>Bidalketa Datuak</h4>

                    <div class="form-group">
                        <label>Izena</label>
                        <input type="text" name="izena" required placeholder="Zure izena">
                    </div>

                    <div class="form-group">
                        <label>Abizenak</label>
                        <input type="text" name="abizenak" required placeholder="Zure abizenak">
                    </div>

                    <div class="form-group">
                        <label>Helbidea</label>
                        <input type="text" name="helbidea" required placeholder="Adib: Kale Nagusia 12, 3B">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Herria</label>
                            <input type="text" name="herria" required>
                        </div>
                        <div class="form-group">
                            <label>P.K.</label>
                            <input type="text" name="postaKodea" required pattern="[0-9]{5}" title="5 digituko posta kodea">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Probintzia</label>
                        <input type="text" name="probintzia" required>
                    </div>

                    <div class="form-group">
                        <label>Emaila</label>
                        <input type="email" name="emaila" required placeholder="adibidea@email.com">
                    </div>

                    <button type="submit" class="btn-checkout">Eskaria Bidali</button>
                </form>
            </div>
        </div>
    <?php else: ?>
        <div class="empty-cart">
            <p>Saskia hutsik dago</p>
            <a href="../katalogoa/index.php" class="btn-continue">Jarraitu Erosten</a>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>