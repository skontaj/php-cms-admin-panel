<h1 class="text-3xl font-bold mb-8 text-center text-gray-800"><?= htmlspecialchars($title) ?></h1>

<div class="max-w-xl mx-auto space-y-8">
    <?php if (!empty($posts) && is_array($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <?php if (!empty($post['image'])): ?>
                    <img src="<?= htmlspecialchars($post['image']) ?>" alt="Post image" class="w-full h-64 object-cover">
                <?php endif; ?>

                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">
                        <?= htmlspecialchars($post['title']) ?>
                    </h2>

                    <p class="text-gray-600 text-sm mb-4">
                        <?= nl2br(htmlspecialchars(mb_strimwidth($post['content'], 0, 300, "..."))) ?>
                    </p>

                    <div class="flex justify-between items-center">
                        <a href="<?= BASE_URL ?>/post/<?= $post['id'] ?>" class="text-blue-600 font-medium hover:underline">
                            Pročitaj više
                        </a>
                        <span class="text-sm text-gray-400">Autor: <?= htmlspecialchars($post['author_name']) ?></span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="bg-yellow-100 border border-yellow-300 text-yellow-800 px-4 py-3 rounded">
            Trenutno nema dostupnih postova.
        </div>
    <?php endif; ?>
</div>

