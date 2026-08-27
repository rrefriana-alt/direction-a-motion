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
            $newC = str_replace('â†—', '↗', $newC);
            $newC = str_replace('â†’', '→', $newC);
            $newC = str_replace('Â©', '©', $newC);
            $newC = str_replace('â”€', '─', $newC);
            $newC = str_replace('â€”', '—', $newC); // em dash
            if ($c !== $newC) {
                file_put_contents($path, $newC);
            }
        }
    }
}