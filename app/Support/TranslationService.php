<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class TranslationService
{
    const CACHE_PREFIX = 'tr:';
    const MAP_PATH = 'translations/map.json';

    protected static ?array $map = null;

    protected static function loadMap(): array
    {
        if (self::$map !== null) {
            return self::$map;
        }
        $path = resource_path(self::MAP_PATH);
        if (!File::exists($path)) {
            return self::$map = [];
        }
        $json = File::get($path);
        $data = json_decode($json, true);
        if (!is_array($data)) {
            return self::$map = [];
        }
        return self::$map = $data;
    }

    public static function translate(string $text, string $target = 'id'): string
    {
        $text = trim($text);
        if ($text === '' || $target === 'en') {
            return $text;
        }
        $key = self::CACHE_PREFIX . md5($text.'|'.$target);
        if (Cache::has($key)) {
            return Cache::get($key);
        }
        $map = self::loadMap();
        // exact match
        if (isset($map[$text]) && trim((string)$map[$text]) !== '') {
            $id = (string) $map[$text];
            Cache::forever($key, $id);
            return $id;
        }
        // ponytail: file commit git; upgrade ke DB translations table saat butuh edit tanpa deploy
        // fallback tampil EN (tidak blank), biar string baru tetap kebaca sampai translator isi manual
        return $text;
    }

    public static function translatePair(string $en, ?string $id = null): string
    {
        if ($id !== null && trim($id) !== '') {
            return $id;
        }
        return self::translate($en, 'id');
    }

    public static function all(): array
    {
        return self::loadMap();
    }
}
