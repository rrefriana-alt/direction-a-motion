<?php
$c = file_get_contents(__DIR__ . '/test_final.html');
preg_match_all('/[^\x00-\x7F]+/', $c, $matches);
foreach (array_unique($matches[0]) as $m) {
    echo bin2hex($m) . " : " . $m . "\n";
}
