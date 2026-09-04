<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Support\Works;
use App\Models\Setting;

echo "Works::all count: ";
try {
    $works = Works::all();
    echo count($works)."\n";
    if (count($works) > 0) {
        echo "First work keys: ".implode(',', array_keys($works))."\n";
        $first = $works[0] ?? null;
        if ($first) {
            echo "first n: ".$first['n']." slug: ".$first['slug']."\n";
            echo "first gallery keys: ";
            if (isset($first['gallery'])) {
                var_dump(array_keys($first['gallery']));
                var_dump($first['gallery'][0] ?? 'no0');
            }
        }
        // test loop logic for modal
        foreach ($works as $i => $w) {
            $prev = $works[($i - 1 + count($works)) % count($works)]["slug"] ?? 'ERR';
            $next = $works[($i + 1) % count($works)]["slug"] ?? 'ERR';
            echo "i=$i prev=$prev next=$next\n";
            if ($i>2) break;
        }
        // test gallery loop
        $w = $works[0];
        if (!empty($w['gallery'])) {
            foreach ($w['gallery'] as $i => $item) {
                echo "gallery i=$i type=".gettype($i)." art test: ";
                try {
                    $out = Works::art($w, $i + 1, 'gal');
                    echo "ok len ".strlen($out)."\n";
                } catch (Throwable $e) {
                    echo "FAIL ".$e->getMessage()."\n";
                }
            }
        }
    } else {
        echo "No works, testing empty case\n";
    }
} catch (Throwable $e) {
    echo "ERROR: ".$e->getMessage()."\n";
    echo $e->getTraceAsString()."\n";
}

echo "\nTest Setting localized:\n";
echo Setting::localized('home_capabilities_title', 'id', "Five studios,<br>one standard") . "\n";
echo Setting::localized('home_capabilities_title', 'en', "Five studios,<br>one standard") . "\n";

echo "\nTest view render en/work:\n";
try {
    $html = view('en.work', ['works'=>Works::all(), 'latestPosts'=>\App\Models\News::published()->orderByDesc('published_date')->take(1)->get(), 'workTitle'=>'Test', 'workLede'=>'Lede', 'locale'=>'en'])->render();
    echo "render ok len ".strlen($html)."\n";
} catch (Throwable $e) {
    echo "RENDER FAIL: ".$e->getMessage()."\n";
    echo $e->getTraceAsString()."\n";
}

echo "\nTest view render id/work:\n";
try {
    $html = view('id.work', ['works'=>Works::all(), 'latestPosts'=>\App\Models\News::published()->orderByDesc('published_date')->take(1)->get(), 'workTitle'=>'Test', 'workLede'=>'Lede', 'locale'=>'id'])->render();
    echo "render ok len ".strlen($html)."\n";
} catch (Throwable $e) {
    echo "RENDER FAIL ID: ".$e->getMessage()."\n";
    echo $e->getTraceAsString()."\n";
}
