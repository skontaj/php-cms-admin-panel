<?php

// Sprečava direktan pristup fajlu
if (!defined('APP_STARTED')) {
    header("Location: /CMS/public/register");
    exit;
}
?>

<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-bold text-center text-gray-700">Register</h2>
        <form action="<?= BASE_URL ?>/register" method="POST" class="mt-4">
            <div class="mb-4">
                <label class="block text-gray-600 text-sm font-medium mb-1">Full Name</label>
                <input type="text" name="name" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-600 text-sm font-medium mb-1">Email Address</label>
                <input type="email" name="email" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-600 text-sm font-medium mb-1">Password</label>
                <input type="password" name="password" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-600 text-sm font-medium mb-1">Confirm Password</label>
                <input type="password" name="confirm_password" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                Register
            </button>
        </form>
        <p class="text-sm text-gray-500 text-center mt-4">Already have an account? <a href="routes.php?action=login" class="text-blue-500 hover:underline">Log in</a></p>
        
        <div class="mt-4">
            <?php if (!empty($errors)): ?>
                <div class="errors" style="color: red;">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>
