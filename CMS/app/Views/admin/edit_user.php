<?php

// Sprečava direktan pristup fajlu
if (!defined('APP_STARTED')) {
    header("Location: /CMS/public/register");
    exit;
}
?>

<h2 class="text-2xl font-bold mb-4">Uredi korisnika</h2>

<div class="bg-white shadow-md rounded p-4 mb-6">
    <p><strong>Ime:</strong> <?= htmlspecialchars($user['name']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>

    <form method="POST" action="<?= BASE_URL ?>/admin/user/<?= $user['id'] ?>/update" class="mt-4">
        <label for="role" class="block mb-1 font-medium">Uloga:</label>
        <select name="role" id="role" class="border rounded p-2 w-full">
            <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
        </select>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 mt-3 rounded hover:bg-blue-700">Sačuvaj</button>
    </form>

    <form method="POST" action="<?= BASE_URL ?>/admin/user/<?= $user['id'] ?>/delete" onsubmit="return confirm('Da li ste sigurni da želite obrisati korisnika?')" class="mt-4">
        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Obriši korisnika</button>
    </form>
</div>

<?php if (!empty($user['posts'])): ?>
    <h3 class="text-xl font-semibold mb-2">Postovi korisnika:</h3>
    <ul class="space-y-2">
        <?php foreach ($user['posts'] as $post): ?>
            <li class="border p-3 rounded shadow-sm flex justify-between items-center">
                <div>
                    <strong><?= htmlspecialchars($post['title']) ?></strong>
                    <p class="text-sm text-gray-600"><?= htmlspecialchars($post['created_at']) ?></p>
                </div>
                <form method="POST" action="<?= BASE_URL ?>/admin/post/<?= $post['id'] ?>/delete" onsubmit="return confirm('Obrisati ovaj post?')">
                    <button class="text-red-600 hover:underline">Obriši</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p class="text-gray-500">Korisnik nema postova.</p>
<?php endif; ?>
