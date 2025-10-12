<?php
require_once __DIR__ . '/lib/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$action = isset($_POST['action']) ? $_POST['action'] : '';
$notes = load_notes();

switch ($action) {
    case 'add':
        $content = trim((string)($_POST['content'] ?? ''));
        if ($content !== '') {
            $note = [
                'id' => time() . rand(100,999),
                'content' => $content,
                'created_at' => time(),
            ];
            // Newest first: unshift
            array_unshift($notes, $note);
            save_notes($notes);
        }
        break;

    case 'edit':
        $id = isset($_POST['id']) ? (string)$_POST['id'] : '';
        $content = trim((string)($_POST['content'] ?? ''));
        foreach ($notes as &$n) {
            if ((string)$n['id'] === (string)$id) {
                $n['content'] = $content;
                // keep created_at same
                break;
            }
        }
        unset($n);
        save_notes($notes);
        break;

    case 'delete':
        $id = isset($_POST['id']) ? (string)$_POST['id'] : '';
        $notes = array_values(array_filter($notes, function($n) use ($id) {
            return (string)$n['id'] !== (string)$id;
        }));
        save_notes($notes);
        break;

    case 'up':
        $id = isset($_POST['id']) ? (string)$_POST['id'] : '';
        $found = null;
        foreach ($notes as $k => $n) {
            if ((string)$n['id'] === (string)$id) {
                $found = $n;
                unset($notes[$k]);
                break;
            }
        }
        if ($found) {
            array_unshift($notes, $found);
            // reindex
            $notes = array_values($notes);
            save_notes($notes);
        }
        break;
}

header('Location: index.php');
exit;
