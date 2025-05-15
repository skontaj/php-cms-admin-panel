<?php

// Sprečava direktan pristup fajlu
if (!defined('APP_STARTED')) {
    header("Location: /CMS/public/register");
    exit;
}
?>

<div class="max-w-3xl mx-auto space-y-8">

<h1 class="text-2xl font-bold mb-4">Users</h1>

<table class="w-full table-auto border-collapse shadow-md">
    <thead>
        <tr class="bg-gray-200 text-gray-700">
            <th class="px-4 py-2 border">ID</th>
            <th class="px-4 py-2 border">Name</th>
            <th class="px-4 py-2 border">Email</th>
            <th class="px-4 py-2 border">Role</th>
            <th class="px-4 py-2 border">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr class="hover:bg-gray-100">
            <td class="px-4 py-2 border"><?= htmlspecialchars($user['id']) ?></td>
            <td class="px-4 py-2 border"><?= htmlspecialchars($user['name']) ?></td>
            <td class="px-4 py-2 border"><?= htmlspecialchars($user['email']) ?></td>
            <td class="px-4 py-2 border"><?= htmlspecialchars($user['role']) ?></td>
            <td class="px-4 py-2 border text-center">
                <a href="/CMS/public/admin/user/<?= $user['id'] ?>/edit" 
                   class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                   View / Edit
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
