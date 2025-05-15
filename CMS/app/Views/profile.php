<?php
// Sprečava direktan pristup fajlu
if (!defined('APP_STARTED')) {
    header("Location: ../routes.php?action=profile");
}
?>

<div class="flex justify-center items-center min-h-screen">
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md mt-6">
        <h2 class="text-2xl font-bold mb-4 text-center">Profile</h2>

        <?php if (!empty($message)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            <?php foreach ($message as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <ul class="list-disc pl-5">
                    <?php foreach ($errors as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Form to edit email -->
        <form method="POST" action="<?= BASE_URL ?>/update-email" class="mb-6">
            <h3 class="text-lg font-semibold mb-4">Edit Email</h3>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">New email address:</label>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($_SESSION['user']['email'] ?? '') ?>" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4">
            <button type="submit"
                class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-700">
                Save Email
            </button>
        </form>

        <hr class="my-6">

        <!-- Form to edit password -->
        <form method="POST" action="<?= BASE_URL ?>/update-password" class="mb-6">
            <h3 class="text-lg font-semibold mb-4">Change Password</h3>
            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Current password:</label>
            <input type="password" name="current_password" id="current_password" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4">

            <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">New password:</label>
            <input type="password" name="new_password" id="new_password" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4">

            <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">Confirm new password:</label>
            <input type="password" name="confirm_password" id="confirm_password" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4">

            <button type="submit"
                class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-700">
                Change Password
            </button>
        </form>

        <div class="mt-6 p-4">
            <form method="POST" action="<?= BASE_URL ?>/delete-account" 
                onsubmit="return confirm('Are you sure you want to delete your account? This action is irreversible.');" 
                class="flex justify-center items-center">
                <button type="submit" 
                    class="bg-red-500 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded">
                    Delete Account
                </button>
            </form>
        </div>

    </div>
</div>
