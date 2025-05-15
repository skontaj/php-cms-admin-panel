<?php
if (!defined('APP_STARTED')) {
    // Redirekcija ako neko pokušava direktno otvoriti fajl
    header("Location: /CMS/public/login");
    exit;
}
?>

<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-bold text-center text-gray-700">Login</h2>
        <form action="<?= BASE_URL ?>/login" method="POST" class="mt-4">
            <div class="mb-4">
                <label class="block text-gray-600 text-sm font-medium mb-1">Email Address</label>
                <input type="email" name="email" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-600 text-sm font-medium mb-1">Password</label>
                <input type="password" name="password" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-4 flex items-center">
                <input type="checkbox" name="remember" class="mr-2">
                <label class="text-gray-600 text-sm">Remember Me</label>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                Login
            </button>
        </form>
        <p class="text-sm text-gray-500 text-center mt-2">
            Don't have an account? <a href="routes.php?action=register" class="text-blue-500 hover:underline">Register now</a>
        </p>

        <div class="mt-4">
        <?php if (!empty($message)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            <?php foreach ($message as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
            </div>
        <?php endif; ?>
        </div>

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
