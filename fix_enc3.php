<?php
$dirs = [__DIR__ . '/resources/views', __DIR__ . '/routes'];
foreach ($dirs as $d) {
    if (!is_dir($d)) continue;
    $iter = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($d));
    foreach ($iter as $file) {
        if ($file->isFile() && (str_ends_with($file->getFilename(), '.php'))) {
            $path = $file->getPathname();
            $c = file_get_contents($path);
            $newC = $c;
            $newC = str_replace(['â€”', 'Ã¢â‚¬â€'], '—', $newC);
            $newC = str_replace(['â€“', 'Ã¢â‚¬âœ'], '–', $newC);
            $newC = str_replace(['â€™', 'Ã¢â‚¬â„¢'], '’', $newC);
            $newC = str_replace(['â€œ', 'Ã¢â‚¬Å“'], '“', $newC);
            $newC = str_replace(['â€', 'Ã¢â‚¬?'], '”', $newC);
            $newC = str_replace(['Â·', 'Ã‚Â·'], '·', $newC);
            if ($c !== $newC) {
                file_put_contents($path, $newC);
            }
        }
    }
}