<?php
$dirs = [__DIR__ . '/resources/views', __DIR__ . '/app/Http/Controllers', __DIR__ . '/routes'];
$replacements = [
    '???????' => '?', // em dash
    '????????' => '?', // en dash
    '????????' => '?', // right single quote
    '???????' => '?', // left double quote
    '??????' => '?', // right double quote
    '????' => '?',    // middle dot
    '???' => '?',
    '???' => '?',
    '???' => '?',
    '???' => '?',
    '???' => '?',
    '??' => '?'
];

foreach ($dirs as $d) {
    if (!is_dir($d)) continue;
    $iter = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($d));
    foreach ($iter as $file) {
        if ($file->isFile() && (str_ends_with($file->getFilename(), '.php'))) {
            $path = $file->getPathname();
            $c = file_get_contents($path);
            $newC = strtr($c, $replacements);
            if ($c !== $newC) {
                file_put_contents($path, $newC);
                echo "Fixed: $path\n";
            }
        }
    }
}
