<?php
require_once __DIR__ . '/lib/functions.php';
$notes = load_notes();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$note = null;
foreach ($notes as $n) {
    if ($n['id'] === $id) { $note = $n; break; }
}
if (!$note) {
    header('Location: index.php');
    exit;
}
?>
<?php include 'templates/header.php'; ?>

<div class="container">
    <h1>Editar nota</h1>

    <form action="actions.php" method="post" class="edit-note">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id" value="<?= (int)$note['id'] ?>">
        <textarea name="content" required><?= htmlspecialchars($note['content']) ?></textarea>
        <div class="row">
            <button type="submit">Guardar</button>
            <a class="button ghost" href="index.php">Cancelar</a>
        </div>
    </form>
</div>

<?php include 'templates/footer.php'; ?>
