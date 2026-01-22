<nav>
    <ul>
        <?php foreach ($nav_items as $item): ?>
            <li><?= htmlspecialchars($item) ?></li>
        <?php endforeach; ?>
    </ul>
</nav>