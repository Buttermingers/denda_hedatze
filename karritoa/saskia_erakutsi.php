<?php
$page_title = 'Saskia - Denda';
include '../includes/header.php';
?>

    <h2>Saskia</h2>
    <hr>
    
    <?php if (isset($_SESSION['checkout_success'])): ?>
        <p style="color: green; font-weight: bold; background: #e8f5e9; padding: 10px; border-radius: 4px;">
            <?php echo htmlspecialchars($_SESSION['checkout_success']); ?>
        </p>
        <?php unset($_SESSION['checkout_success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['checkout_error'])): ?>
        <p style="color: red; font-weight: bold; background: #ffebee; padding: 10px; border-radius: 4px;">
            <?php echo htmlspecialchars($_SESSION['checkout_error']); ?>
        </p>
        <?php unset($_SESSION['checkout_error']); ?>
    <?php endif; ?>

    <?php if ($saskia->getDetaileKopurua() > 0) { ?>
        <table cellspacing="5" cellpadding="5" border="1">
            <tr>
                <td>Produktua</td>
                <td>Prezioa</td>
                <td>Kopurua</td>
                <td>Guztira</td>
            </tr>
            <?php 
            foreach ($saskia->getDetaileak() as $detailea) { 
                $produktua = $detailea->getProduktua();
            ?>
            <tr valign="top">
                <td><?php echo $produktua->getIzena(); ?></td>
                <td><?php echo $produktua->getPrezioa(); ?> &euro;</td>
                <td>
                    <form action="kudeatu.php" method="POST" style="display:flex; align-items:center; gap:5px; margin:0;">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="id" value="<?php echo $produktua->getId(); ?>">
                        <input type="number" name="kantitatea" value="<?php echo $detailea->getKopurua(); ?>" min="0" style="width: 60px;">
                        <input type="submit" value="aktualizatu" title="Eguneratu">
                    </form>
                </td>
                <td><?php echo $detailea->getGuztira(); ?> &euro;</td>
            </tr>
            <?php } ?>
        </table>
        <br>
        <form action="kudeatu.php" method="POST">
            <input type="hidden" name="action" value="checkout">
            <h3>Eskaria Amaitu</h3>
            Izena: <input type="text" name="izena" required><br>
            Abizenak: <input type="text" name="abizenak" required><br>
            Helbidea: <input type="text" name="helbidea" required><br>
            Herria: <input type="text" name="herria" required><br>
            Posta Kodea: <input type="number" name="postaKodea" required><br>
            Probintzia: <input type="text" name="probintzia" required><br>
            Emaila: <input type="email" name="emaila" required><br><br>
            <input type="submit" value="Eskaria Bidali">
        </form>
    <?php } else { ?>
        <?php if (!isset($_SESSION['checkout_success'])): ?> 
            <p>Saskia hutsik dago</p>
        <?php endif; ?>
    <?php } ?>

<?php include '../includes/footer.php'; ?>