<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value'];

    public static function get(string $key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function localized(string $baseKey, ?string $locale = null, $default = null)
    {
        $locale = $locale ?? app()->getLocale();
        $localizedKey = $baseKey . '_' . $locale;
        $val = static::get($localizedKey, null);
        if ($val !== null && $val !== '') {
            return $val;
        }
        // fallback: try base key, then en
        $base = static::get($baseKey, null);
        if ($base !== null && $base !== '') {
            return $base;
        }
        return static::get($baseKey . '_en', $default) ?? $default;
    }

    public static function set(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
