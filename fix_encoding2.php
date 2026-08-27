<?php
$dirs = [__DIR__ . '/resources/views', __DIR__ . '/app/Http/Controllers', __DIR__ . '/routes'];
$replacements = [
    'Ã¢â‚¬â€' => '—',
    'Ã¢â‚¬âœ' => '–',
    'Ã¢â‚¬â„¢' => '’',
    'Ã¢â‚¬Å“' => '“',
    'Ã¢â‚¬?' => '”',
    'Ã‚Â·' => '·',
    'â€”' => '—',
    'â€“' => '–',
    'â€™' => '’',
    'â€œ' => '“',
    'â€?' => '”',
    'Â·' => '·'
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
            }
        }
    }
}