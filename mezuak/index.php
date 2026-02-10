<?php
session_start();


$page_title = 'Kontaktua - Mezuak';
$page_css = 'style.css';

include __DIR__ . '/../includes/header.php';
?>

<div class="katalogo-edukia">
    <h2>💬 Utzi zure mezua</h2>

    <div id="form-feedback"
        style="display:none; padding: 10px; border-radius: 4px; margin-bottom: 10px; font-weight: bold;"></div>

    <form id="mezuaForm" class="mezua-form">
        <label for="izena">Izena</label>
        <input type="text" id="izena" name="izena" required>

        <label for="emaila">Emaila</label>
        <input type="email" id="emaila" name="emaila" required>

        <label for="mezua">Mezua</label>
        <textarea id="mezua" name="mezua" rows="5" required></textarea>

        <button type="submit">Bidali Mezua</button>
    </form>
</div>

<script>
    document.getElementById('mezuaForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);
        const feedbackDiv = document.getElementById('form-feedback');

        feedbackDiv.style.display = 'none';
        feedbackDiv.textContent = '';
        feedbackDiv.className = '';

        fetch('mezua_gorde.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                feedbackDiv.style.display = 'block';
                if (data.success) {
                    feedbackDiv.textContent = data.message;
                    feedbackDiv.style.color = 'green';
                    feedbackDiv.style.background = '#e8f5e9';
                    form.reset();
                } else {
                    feedbackDiv.textContent = data.message;
                    feedbackDiv.style.color = 'red';
                    feedbackDiv.style.background = '#ffebee';
                }
            })
            .catch(error => {
                console.error('Errorea:', error);
                feedbackDiv.style.display = 'block';
                feedbackDiv.textContent = 'Errore bat gertatu da. Saiatu beranduago.';
                feedbackDiv.style.color = 'red';
                feedbackDiv.style.background = '#ffebee';
            });
    });
</script>


</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>