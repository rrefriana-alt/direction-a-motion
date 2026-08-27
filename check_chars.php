<?php
$c = file_get_contents(__DIR__ . '/resources/views/index.blade.php');
preg_match_all('/[^\x00-\x7F]+/', $c, $matches);
foreach (array_unique($matches[0]) as $m) {
    echo bin2hex($m) . " : " . $m . "\n";
}
