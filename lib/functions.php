<?php
define('DATA_FILE', __DIR__ . '/../data/notes.json');

function load_notes(): array {
    if (!file_exists(DATA_FILE)) {
        @mkdir(dirname(DATA_FILE), 0777, true);
        file_put_contents(DATA_FILE, json_encode([]));
    }
    $raw = @file_get_contents(DATA_FILE);
    if ($raw === false) return [];
    $data = json_decode($raw, true);
    if (!is_array($data)) return [];
    return $data;
}

function save_notes(array $notes): bool {
    $dir = dirname(DATA_FILE);
    if (!is_dir($dir)) @mkdir($dir, 0777, true);
    $tmp = DATA_FILE . '.tmp';
    $fp = fopen($tmp, 'w');
    if (!$fp) return false;
    // exclusive lock while writing
    if (!flock($fp, LOCK_EX)) {
        fclose($fp);
        return false;
    }
    $ok = fwrite($fp, json_encode(array_values($notes), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    fflush($fp);
    flock($fp, LOCK_UN);
    fclose($fp);
    if ($ok === false) return false;
    return rename($tmp, DATA_FILE);
}

function format_date($ts) {
    $dt = DateTime::createFromFormat('U', (int)$ts);
    if ($dt === false) return '';
    return $dt->format('Y-m-d H:i');
}
