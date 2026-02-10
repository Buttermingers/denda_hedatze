<?php

$page_title = 'Katalogoa - Denda';
$page_css = 'style.css';

include '../includes/header.php';
?>

<div class="katalogoa-main">
    <h1>Produktu Guztiak</h1>

    <div class="search-bar-container">
        <input type="text" id="search-input" placeholder="Bilatu produktua..." list="products-suggestions">
        <datalist id="products-suggestions">
            <?php foreach ($produktuak as $produktua): ?>
                <option value="<?php echo htmlspecialchars($produktua->getIzena()); ?>">
                <?php endforeach; ?>
        </datalist>
    </div>

    <div id="produktuak-container" class="sareko-produktuak">
        <?php if (!empty($produktuak)): ?>
            <?php foreach ($produktuak as $produktua): ?>
                <div class="produktu-txartelak">
                    <a href="index.php?action=produktua&id=<?php echo $produktua->getId(); ?>">
                        <img src="../img/<?php echo htmlspecialchars($produktua->getIrudia()); ?>"
                            alt="<?php echo htmlspecialchars($produktua->getIzena()); ?>">
                        <h3>
                            <?php echo htmlspecialchars($produktua->getIzena()); ?>
                        </h3>
                        <p class="prezioa">
                            <?php echo htmlspecialchars($produktua->getPrezioa()); ?>€
                        </p>
                        <?php if ($produktua->getDescuento() > 0): ?>
                            <p class="deskontua">
                                <?php echo htmlspecialchars($produktua->getDescuento()); ?>% deskontua
                            </p>
                        <?php endif; ?>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Ez dago produkturik.</p>
        <?php endif; ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search-input');
        const productsContainer = document.getElementById('produktuak-container');

        searchInput.addEventListener('input', function () {
            const query = this.value;
            console.log('Searching for:', query);

            fetch('produktuak_bilatu.php?q=' + encodeURIComponent(query))
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Results:', data);
                    productsContainer.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach(product => {
                            const productCard = document.createElement('div');
                            productCard.className = 'produktu-txartelak';

                            let discountHtml = '';
                            if (product.descuento > 0) {
                                discountHtml = `<p class="deskontua">${escapeHtml(product.descuento)}% deskontua</p>`;
                            }

                            productCard.innerHTML = `
                            <a href="index.php?action=produktua&id=${product.id}">
                                <img src="../img/${escapeHtml(product.irudia)}" alt="${escapeHtml(product.izena)}">
                                <h3>${escapeHtml(product.izena)}</h3>
                                <p class="prezioa">${escapeHtml(product.prezioa)}€</p>
                                ${discountHtml}
                            </a>
                        `;
                            productsContainer.appendChild(productCard);
                        });
                    } else {
                        productsContainer.innerHTML = '<p>Ez dago emaitzik.</p>';
                    }
                })
                .catch(error => console.error('Errorea:', error));
        });

        function escapeHtml(text) {
            if (text == null) return '';
            return String(text)
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }
    });
</script>

<?php
include '../includes/footer.php';
?>