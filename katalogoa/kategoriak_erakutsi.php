<?php

$page_title = 'Kategoriak - Denda';
$page_css = 'style.css';

include '../includes/header.php';
?>

<div class="kategoriak-section">
    <h2>Produktuen Kategoriak</h2>
    <?php if (!empty($kategoriak)): ?>
        <ul class="kategoriak-list">
            <?php foreach ($kategoriak as $kategoria): ?>
                <li class="kategoria-item">
                    <a href="index.php?action=kategoria&id=<?php echo $kategoria->getId(); ?>">
                        <div>
                            <h3 class="kategoria-izena"><?php echo htmlspecialchars($kategoria->getIzena()); ?></h3>
                            <p><?php echo htmlspecialchars($kategoria->getLaburpena()); ?></p>
                        </div>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Ez dago kategoriarik momentu honetan.</p>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>