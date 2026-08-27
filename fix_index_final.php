<?php
$path = __DIR__ . '/resources/views/index.blade.php';
$c = file_get_contents($path);

// Fix the single UTF-8 decoded garbled characters that exist in the backup
$replacements = [
    'â€”' => '—', // em dash
    'â€“' => '–', // en dash
    'â€™' => '’', // right single quote
    'â€œ' => '“', // left double quote
    'â€' => '”', // right double quote (only if standalone)
    'Â·' => '·', // middle dot
    'â†—' => '↗', // up right arrow
    'â†’' => '→', // right arrow
    'Â©' => '©', // copyright
    'â”€' => '─', // box drawing line
];

// Apply replacements
foreach ($replacements as $bad => $good) {
    $c = str_replace($bad, $good, $c);
}

// Fix PHP null coalesce syntax if broken (though in the original backup it might be correct)
$c = str_replace("] ? '", "] ?? '", $c);
$c = str_replace("] ? \"", "] ?? \"", $c);

file_put_contents($path, $c);