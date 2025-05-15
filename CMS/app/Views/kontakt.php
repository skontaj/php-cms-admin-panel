<h1><?= $title ?></h1>

<?php if (!empty($error)): ?>
    <p style="color: red;"><?= $error ?></p>
<?php endif; ?>

<form action="/kontakt" method="POST">
    <div>
        <label for="ime">Ime:</label>
        <input type="text" name="ime" id="ime" required>
    </div>

    <div>
        <label for="poruka">Poruka:</label>
        <textarea name="poruka" id="poruka" required></textarea>
    </div>

    <div>
        <button type="submit">Pošalji</button>
    </div>
</form>
