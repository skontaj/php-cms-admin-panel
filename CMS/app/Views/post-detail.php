<article class="max-w-xl mx-auto p-6 bg-white shadow rounded-lg mt-8">
    <h1 class="text-3xl font-bold mb-2"><?= htmlspecialchars($post['title']) ?></h1>
    <p class="text-gray-600 mb-4">By <?= htmlspecialchars($post['author_name']) ?> | <?= date('d.m.Y', strtotime($post['created_at'])) ?></p>

    <?php if (!empty($post['image'])): ?>
        <img src="<?= htmlspecialchars($post['image']) ?>" alt="Post Image" class="w-full h-auto mb-4 rounded">
    <?php endif; ?>

    <div class="text-gray-800 leading-relaxed">
        <?= nl2br(htmlspecialchars($post['content'])) ?>
    </div>
</article>
