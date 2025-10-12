<?php
require_once __DIR__ . '/lib/functions.php';
$notes = load_notes();
?>
<?php include 'templates/header.php'; ?>

<div class="container">
    <h1>Notas</h1>

    <form action="actions.php" method="post" class="new-note">
        <input type="hidden" name="action" value="add">
        <textarea name="content" placeholder="Escribe una nueva nota..." required></textarea>
        <div class="row">
            <button type="submit">Añadir nota</button>
        </div>
    </form>

    <?php if (empty($notes)): ?>
        <p class="empty">No hay notas todavía.</p>
    <?php else: ?>
        <ul class="notes">
            <?php foreach ($notes as $note): ?>
                <li class="note">
                    <div class="meta">
                        <span class="date"><?= htmlspecialchars(format_date($note['created_at'])) ?></span>
                        <div class="actions">
                            <form action="actions.php" method="post" class="inline">
                                <input type="hidden" name="action" value="up">
                                <input type="hidden" name="id" value="<?= (int)$note['id'] ?>">
                                <button type="submit" title="Subir al inicio">↑</button>
                            </form>

                            <a class="edit" href="edit.php?id=<?= (int)$note['id'] ?>" title="Editar">✎</a>

                            <form action="actions.php" method="post" class="inline" onsubmit="return confirm('¿Eliminar esta nota?');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= (int)$note['id'] ?>">
                                <button type="submit" title="Papelera">🗑️</button>
                            </form>
                        </div>
                    </div>

                    <div class="content"><?= nl2br(htmlspecialchars($note['content'])) ?></div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<?php include 'templates/footer.php'; ?>
