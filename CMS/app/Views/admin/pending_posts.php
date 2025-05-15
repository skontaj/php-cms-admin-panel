<h1 class="text-3xl font-bold mb-6 text-gray-800">Pending Posts</h1>

<table class="w-full table-auto border-collapse bg-white shadow-md rounded-lg overflow-hidden">
    <thead>
        <tr class="bg-gray-100 text-left text-gray-700 text-sm uppercase">
            <th class="px-6 py-3">Title</th>
            <th class="px-6 py-3">Content</th>
            <th class="px-6 py-3">Image</th>
            <th class="px-6 py-3">Author</th>
            <th class="px-6 py-3 text-center">Actions</th>
        </tr>
    </thead>
    <tbody class="text-gray-700">
        <?php foreach ($posts as $post): ?>
            <tr class="border-b hover:bg-gray-50 h-32">
                <td class="px-6 py-4 font-semibold"><?= htmlspecialchars($post['title']) ?></td>

                <!-- Scrollable content -->
                <td class="px-6 py-4">
                    <div class="max-h-32 overflow-y-auto text-sm pr-2">
                        <?= nl2br(htmlspecialchars($post['content'])) ?>
                    </div>
                </td>


                <!-- Scrollable image (if needed) -->
                <td class="px-6 py-4">
                    <?php if (!empty($post['image'])): ?>
                        <div class="h-24 w-24 overflow-hidden rounded shadow">
                            <img src="<?= htmlspecialchars($post['image']) ?>" alt="Post Image" class="h-full w-full object-cover">
                        </div>
                    <?php else: ?>
                        <span class="text-gray-400 italic">No image</span>
                    <?php endif; ?>
                </td>

                <td class="px-6 py-4"><?= htmlspecialchars($post['user_id']) ?></td>

                <!-- Buttons -->
                <td class="px-6 py-4 text-center">
                    <div class="flex items-center justify-center gap-2">
                        <form method="POST" action="<?= BASE_URL ?>/admin/posts/approve/<?= $post['id'] ?>">
                            <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded text-sm">
                                Approve
                            </button>
                        </form>
                        <form method="POST" action="<?= BASE_URL ?>/admin/posts/delete/<?= $post['id'] ?>" onsubmit="return confirm('Are you sure you want to delete this post?')">
                            <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-1 rounded text-sm">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Pagination -->
<?php if ($totalPages > 1): ?>
    <div class="mt-6 flex flex-col sm:flex-row justify-between items-center text-sm text-gray-700">
        <span class="mb-2 sm:mb-0">Page <?= $page ?> of <?= $totalPages ?></span>
        <div class="flex space-x-1">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>" class="px-3 py-1 border rounded hover:bg-gray-100">&laquo; Prev</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>"
                   class="px-3 py-1 border rounded <?= $i == $page ? 'bg-blue-600 text-white' : 'hover:bg-gray-100' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1 ?>" class="px-3 py-1 border rounded hover:bg-gray-100">Next &raquo;</a>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
