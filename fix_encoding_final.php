<?php
$files = glob(__DIR__ . '/resources/views/*.blade.php');
$replacements = [
    "\xC3\xA2\xE2\x82\xAC\xE2\x80\x9D" => "\xE2\x80\x94", // em dash
    "\xC3\xA2\xE2\x82\xAC\xE2\x80\x9C" => "\xE2\x80\x93", // en dash
    "\xC3\xA2\xE2\x82\xAC\xE2\x84\xA2" => "\xE2\x80\x99", // right single quote
    "\xC3\xA2\xE2\x82\xAC\xC5\x93"     => "\xE2\x80\x9C", // left double quote
    "\xC3\xA2\xE2\x82\xAC\xC2\x9D"     => "\xE2\x80\x9D", // right double quote
    "\xC3\x82\xC2\xB7"                  => "\xC2\xB7",      // middle dot
    "\xC3\xA2\xE2\x80\xA0\xE2\x80\x94" => "\xE2\x86\x97",  // up-right arrow
    "\xC3\xA2\xE2\x80\xA0\xE2\x80\x99" => "\xE2\x86\x92",  // right arrow
    "\xC3\x82\xC2\xA9"                  => "\xC2\xA9",      // copyright
    "\xC3\xA2\xE2\x80\x9D\xE2\x82\xAC" => "\xE2\x94\x80",  // box drawing line
    "\xC3\xA2\xE2\x82\xAC\xC2\xA2"     => "\xE2\x80\xA2",  // bullet
];
foreach ($files as $file) {
    $c = file_get_contents($file);
    $original = $c;
    foreach ($replacements as $bad => $good) {
        $c = str_replace($bad, $good, $c);
    }
    if ($c !== $original) {
        file_put_contents($file, $c);
        echo "Fixed: " . basename($file) . "\n";
    }
}
echo "Done.\n";