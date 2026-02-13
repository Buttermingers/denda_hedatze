<?php
$page_title = 'Denda - Albisteak';
$page_css = 'style.css';

require_once '../includes/header.php';
?>

<section class="katalogo-atalak">
    <div class="katalogo-edukia">
        <h2>📰 Albisteak</h2>
        <div id="albisteak-container">
            <p>Albisteak kargatzen...</p>
        </div>
    </div>
</section>

<script>
    fetch('http://localhost/Vue/vue-project_api/api/albisteak.php')
        .then(res => res.json())
        .then(albisteak => {
            const div = document.getElementById('albisteak-container');
            if (albisteak.length === 0) {
                div.innerHTML = '<p>Ez dago albisteik momentu honetan.</p>';
                return;
            }
            div.innerHTML = '';
            albisteak.forEach(a => {
                div.innerHTML += `
                    <div class="albistea-item">
                        <h3>${a.izenburua}</h3>
                        <p>${a.xehetasunak}</p>
                        <small>Egilea: ${a.autorea}</small>
                    </div>
                `;
            });
        })
        .catch(error => {
            const div = document.getElementById('albisteak-container');
            div.innerHTML = '<p class="alert alert-error">Errorea albisteak kargatzean. Saiatu berriro geroago.</p>';
            console.error('Errorea:', error);
        });
</script>

<?php include '../includes/footer.php'; ?>