<?php

// Sprečava direktan pristup fajlu
if (!defined('APP_STARTED')) {
    header("Location: /CMS/public/register");
    exit;
}
?>

<div class="max-w-xl mx-auto mt-10">

    <!-- Success Message -->
    <?php if (!empty($message)): ?>
        <div class="mb-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                <ul class="list-disc pl-5">
                    <?php foreach ($message as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>

    <!-- Error Messages -->
    <?php if (!empty($errors)): ?>
        <div class="mb-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <ul class="list-disc pl-5">
                    <?php foreach ($errors as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>

    <!-- Form -->
    <form action="<?= BASE_URL ?>/create-post" method="POST" enctype="multipart/form-data" class="p-6 bg-white shadow-md rounded-lg space-y-4">
        <h2 class="text-2xl font-semibold text-gray-700">Create New Post</h2>

        <!-- Title -->
        <div>
            <label for="title" class="block mb-1 text-gray-600">Title</label>
            <input type="text" name="title" id="title" placeholder="Post title"
                   class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                   required>
        </div>

        <!-- Content -->
        <div>
            <label for="content" class="block mb-1 text-gray-600">Content</label>
            <textarea name="content" id="content" placeholder="Post content"
                      class="w-full px-4 py-2 border rounded-md h-40 resize-none focus:outline-none focus:ring-2 focus:ring-blue-400"
                      required><?= htmlspecialchars($content ?? '') ?></textarea>
        </div>

        <!-- Image Upload -->
        <div>
            <label for="image" class="block mb-1 text-gray-600">Upload Image (optional)</label>
            <input type="file" name="image" id="image"
                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border-0
                          file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                   accept="image/*">
        </div>

        <!-- Submit -->
        <div class="text-right">
            <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                Publish Post
            </button>
        </div>
    </form>
</div>
