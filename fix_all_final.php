<?php
$files = ['work.blade.php', 'services.blade.php', 'about.blade.php', 'contact.blade.php', 'case-study.blade.php', '404.blade.php'];
foreach ($files as $file) {
    $backup = 'd:\Reyhan\Fugo Creative\direction-a-motion-laravel-backup\resources\views\\' . $file;
    $dest = __DIR__ . '/resources/views/' . $file;
    if (file_exists($backup)) {
        copy($backup, $dest);
        $c = file_get_contents($dest);
        $replacements = [
            'â€”' => '—', 'â€“' => '–', 'â€™' => '’', 'â€œ' => '“', 'â€' => '”', 'Â·' => '·', 'â†—' => '↗', 'â†’' => '→', 'Â©' => '©', 'â”€' => '─'
        ];
        foreach ($replacements as $bad => $good) {
            $c = str_replace($bad, $good, $c);
        }
        $c = str_replace("] ? '", "] ?? '", $c);
        $c = str_replace("] ? \"", "] ?? \"", $c);
        file_put_contents($dest, $c);
    }
}