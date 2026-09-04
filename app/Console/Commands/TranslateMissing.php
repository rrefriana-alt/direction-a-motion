<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class TranslateMissing extends Command
{
    protected $signature = 'translate:missing {--json : Output as JSON}';
    protected $description = 'List EN strings missing ID in resources/translations/map.json (permanen, tanpa provider)';

    public function handle(): int
    {
        $mapPath = resource_path('translations/map.json');
        if (!File::exists($mapPath)) {
            $this->error('Missing '.$mapPath.' — run php extract-map.php first.');
            return 1;
        }
        $map = json_decode(File::get($mapPath), true);
        if (!is_array($map)) {
            $this->error('Invalid JSON in map.json');
            return 1;
        }

        $blades = $this->collectBladeStrings();
        $works  = $this->collectWorksDataStrings();
        $allEn = array_values(array_unique(array_merge($blades, $works)));

        $missing = [];
        $emptyValue = [];
        foreach ($allEn as $en) {
            $en = trim($en);
            if ($en === '') continue;
            if (!array_key_exists($en, $map)) $missing[] = $en;
            elseif (trim((string)$map[$en]) === '') $emptyValue[] = $en;
        }
        // also keys in map with empty value that are not in blades anymore (stale)
        $staleEmpty = array_keys(array_filter($map, fn($v)=> trim((string)$v)===''));

        $totalMissing = count($missing) + count($emptyValue);

        if ($this->option('json')) {
            $this->line(json_encode(['missing'=>$missing,'empty'=>$emptyValue,'stale_empty'=>$staleEmpty,'total_map'=>count($map)], JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
            return $totalMissing > 0 ? 1 : 0;
        }

        $this->info(count($map).' entries in resources/translations/map.json');
        $this->info(count($allEn).' unique EN strings found in blades + works-data.php');

        if ($totalMissing === 0) {
            $this->info('No missing translations — semua terisi, akurat karena dari data-id human.');
            $this->line('Edit manual: resources/translations/map.json  lalu  Copy-Item resources/translations/map.json public/assets/translations.json -Force');
            return 0;
        }

        $this->warn($totalMissing.' missing/empty:');
        foreach (array_merge($missing, $emptyValue) as $s) {
            $this->line(' - '.mb_strimwidth($s,0,120,'…'));
        }
        $this->line('');
        $this->line('Cara isi: buka resources/translations/map.json, isi value ID yang akurat sesuai makna, commit git.');
        $this->line('Publish: Copy-Item resources/translations/map.json public/assets/translations.json -Force');
        $this->line('Cek akurat: POSM/BMAT/TVC/BRImo jangan diterjemahkan — keep exact.');

        return 1;
    }

    private function collectBladeStrings(): array
    {
        $out = [];
        $files = File::glob(resource_path('views/**/*.blade.php')) ?: [];
        foreach ($files as $file) {
            $html = File::get($file);
            foreach (['data-en','data-en-placeholder','data-en-alt','data-en-content','data-en-title','data-en-aria-label'] as $attr) {
                if (preg_match_all('/'.preg_quote($attr,'/').'="([^"]+)"/', $html, $m)) {
                    foreach ($m[1] as $en) {
                        if (str_contains($en, '{{') || str_contains($en, '{!!')) continue;
                        $en = html_entity_decode($en, ENT_QUOTES|ENT_HTML5, 'UTF-8');
                        $en = trim($en);
                        if ($en !== '') $out[] = $en;
                    }
                }
            }
        }
        return $out;
    }

    private function collectWorksDataStrings(): array
    {
        $out = [];
        $file = app_path('Support/works-data.php');
        if (!File::exists($file)) return $out;
        $data = @require $file;
        if (!is_array($data)) return $out;
        $walk = function($v) use (&$walk, &$out) {
            if (is_string($v) && str_contains($v, '||')) {
                [$en] = array_map('trim', explode('||', $v, 2));
                if ($en !== '') $out[] = html_entity_decode($en, ENT_QUOTES|ENT_HTML5, 'UTF-8');
            } elseif (is_array($v)) {
                foreach ($v as $item) $walk($item);
            }
        };
        $walk($data);
        return $out;
    }
}
