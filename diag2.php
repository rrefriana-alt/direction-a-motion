<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$p = App\Models\Project::first();
if ($p) {
    echo "id:".$p->id." title:".$p->title.PHP_EOL;
    $raw = $p->getAttributes()['gallery'] ?? 'null';
    echo "gallery raw: ".$raw.PHP_EOL;
    $dec = json_decode($raw ?? '[]', true);
    var_dump($dec);
    echo "hero_image: ".$p->hero_image.PHP_EOL;
    echo "image: ".$p->image.PHP_EOL;
    echo "logo: ".$p->logo.PHP_EOL;
} else {
    echo "no project\n";
}

echo "\n--- ALL projects gallery sample ---\n";
foreach (App\Models\Project::take(2)->get() as $pr) {
    echo "Project ".$pr->id.": ".substr($pr->getAttributes()['gallery'] ?? '', 0, 400)."\n---\n";
}
