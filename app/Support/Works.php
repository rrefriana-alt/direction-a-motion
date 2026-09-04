<?php

namespace App\Support;

use App\Models\Project;
use Throwable;

class Works
{
    // ponytail: handle both "en||id" string and Project cast arrays
    public static function pair($s): array
    {
        if (is_array($s)) {
            // gallery/stat label stored as ['en'=>..,'id'=>..] or [0=>'en',1=>'id']
            if (isset($s['en']) || isset($s['id'])) return ['en' => (string) ($s['en'] ?? ''), 'id' => isset($s['id']) && $s['id'] !== '' ? (string) $s['id'] : null];
            if (isset($s[0])) $s = (string) $s[0];
            else return ['en' => '', 'id' => null];
        }
        if ($s === null) $s = '';
        $s = (string) $s;
        if (! str_contains($s, '||')) {
            return ['en' => $s, 'id' => null];
        }
        [$en, $id] = array_map('trim', explode('||', $s, 2));

        return ['en' => $en, 'id' => $id !== '' ? $id : null];
    }

    public static function text($s): string
    {
        if ($s === null) return '';
        return self::pair($s)['en'];
    }

    public static function attrs($s): string
    {
        if ($s === null || $s === '') return '';
        $p = self::pair($s);
        if ($p['id'] === null) {
            // auto-translate EN -> ID, cached forever
            $p['id'] = TranslationService::translate($p['en'], 'id');
        }

        return ' data-en="'.e($p['en']).'" data-id="'.e($p['id']).'"';
    }

    public static function all(): array
    {
        $items = self::fromDatabase();

        foreach ($items as $i => &$item) {
            $item['n'] = str_pad((string) ((int) $i + 1), 3, '0', STR_PAD_LEFT);
        }

        return $items;
    }

    public static function homepage(): array
    {
        $all = self::all();

        $featured = [];
        foreach ($all as $item) {
            if (!empty($item['is_featured'])) {
                $featured[] = $item;
            }
        }

        usort($featured, fn ($a, $b) => ($a['homepage_order'] ?? 0) <=> ($b['homepage_order'] ?? 0));

        foreach ($featured as $i => &$item) {
            $item['n'] = str_pad((string) ((int) $i + 1), 3, '0', STR_PAD_LEFT);
        }

        return $featured;
    }

    public static function bySlug(string $slug): ?array
    {
        $project = Project::where('slug', $slug)->first();
        if (! $project) {
            return null;
        }

        return self::mapProject($project);
    }

    protected static function curated(): array
    {
        return require __DIR__.'/works-data.php';
    }

    protected static function fromDatabase(): array
    {
        try {
            $rows = Project::where('is_active', true)->orderBy('sort_order')->get();
        } catch (Throwable $e) {
            return [];
        }

        return $rows->map(fn (Project $p) => self::mapProject($p))->all();
    }

    protected static function mapProject(Project $p): array
    {
        $year = $p->year ?: ($p->created_at?->format('Y') ?: '2024');
        $division = $p->division ?: ($p->category ? ucfirst($p->category) : null);

        return array_filter([
            'slug'            => $p->slug ?: 'p'.$p->id.'-'.\Illuminate\Support\Str::slug($p->title),
            'title'           => $p->title,
            'client'          => $p->client_name ?: 'Fugo Creative',
            'logo'            => $p->logo,
            'category'        => $p->category ?: 'Design',
            'division'        => $division,
            'year'            => $year,
            'scope'           => $p->scope,
            'bg'              => $p->bg_color ?: '#101722',
            'accent'          => $p->accent_color ?: '#3ddc97',
            'tags'            => $p->tags,
            'lede'            => $p->lede ?: $p->description,
            'about'           => $p->about,
            'steps'           => $p->steps,
            'stats'           => $p->stats,
            'result'          => $p->result,
            'gallery'         => $p->gallery,
            'docs'            => $p->docs,
            'usecases'        => $p->usecases,
            'credits'         => $p->credits,
            'case_study'      => $p->case_study,
            'hero_image'      => $p->hero_image ?: $p->image,
            'is_featured'     => $p->is_featured ?? false,
            'homepage_order'  => $p->homepage_order ?? 0,
        ]);
    }

    public static function img(?string $path): string
    {
        if (!$path) return '';
        $p = ltrim($path, '/');
        if (str_starts_with($p, 'http://') || str_starts_with($p, 'https://')) return $p;
        if (str_starts_with($p, 'img/') || str_starts_with($p, 'assets/')) return asset($p);
        return asset('img/' . $p);
    }

    public static function imageUrl(?string $path): string
    {
        return self::img($path);
    }

    public static function art(array $w, int $variant = 0, string $uid = ''): string
    {
        $bg = $w['bg'] ?? '#101722';
        $ac = $w['accent'] ?? '#3ddc97';
        $id = 'a'.substr(md5(($w['slug'] ?? 'x').$variant.$uid), 0, 7);
        $v = $variant % 5;

        $open = '<svg viewBox="0 0 1200 675" preserveAspectRatio="xMidYMid slice" style="width:100%;height:100%" aria-hidden="true">'
            .'<defs><linearGradient id="'.$id.'" x1="0" y1="0" x2="1" y2="1">'
            .'<stop offset="0" stop-color="'.$bg.'"/><stop offset="1" stop-color="#07080a"/></linearGradient></defs>'
            .'<rect width="1200" height="675" fill="url(#'.$id.')"/>';

        $body = match ($v) {
            0 => '<circle cx="930" cy="150" r="300" fill="'.$ac.'" opacity=".16"/>'
                .'<path d="M0 520 C 300 380, 620 600, 1200 340" stroke="'.$ac.'" stroke-width="2.5" fill="none" opacity=".65"/>'
                .'<path d="M0 580 C 320 450, 640 660, 1200 410" stroke="#c8f24e" stroke-width="1.5" fill="none" opacity=".35"/>'
                .'<rect x="90" y="150" width="240" height="12" rx="6" fill="#f4f5f2" opacity=".5"/>'
                .'<rect x="90" y="192" width="140" height="12" rx="6" fill="'.$ac.'" opacity=".8"/>',

            1 => '<g opacity=".85">'
                .'<rect x="80" y="120" width="300" height="180" rx="14" fill="#0b1017" stroke="'.$ac.'" stroke-opacity=".5"/>'
                .'<rect x="410" y="120" width="300" height="180" rx="14" fill="#0b1017" stroke="'.$ac.'" stroke-opacity=".28"/>'
                .'<rect x="740" y="120" width="300" height="180" rx="14" fill="#0b1017" stroke="'.$ac.'" stroke-opacity=".16"/>'
                .'</g>'
                .'<rect x="80" y="380" width="960" height="4" fill="'.$ac.'" opacity=".55"/>'
                .'<g fill="#f4f5f2" opacity=".22">'
                .'<rect x="80" y="430" width="60" height="60" rx="8"/><rect x="160" y="430" width="60" height="60" rx="8"/>'
                .'<rect x="240" y="430" width="60" height="60" rx="8"/><rect x="320" y="430" width="60" height="60" rx="8"/>'
                .'</g>'
                .'<circle cx="960" cy="500" r="120" fill="'.$ac.'" opacity=".2"/>',

            2 => '<g fill="none" stroke-width="1.6">'
                .'<circle cx="600" cy="337" r="290" stroke="'.$ac.'" stroke-opacity=".35" stroke-dasharray="7 12"/>'
                .'<circle cx="600" cy="337" r="210" stroke="#c8f24e" stroke-opacity=".28"/>'
                .'<circle cx="600" cy="337" r="130" stroke="'.$ac.'" stroke-opacity=".55"/>'
                .'</g>'
                .'<circle cx="600" cy="337" r="48" fill="'.$ac.'" opacity=".85"/>'
                .'<rect x="80" y="580" width="180" height="10" rx="5" fill="#f4f5f2" opacity=".35"/>',

            3 => '<g opacity=".5" stroke="'.$ac.'" stroke-width="2">'
                .'<path d="M-40 675 L 380 0"/><path d="M120 675 L 540 0"/><path d="M280 675 L 700 0"/>'
                .'<path d="M440 675 L 860 0"/><path d="M600 675 L 1020 0"/>'
                .'</g>'
                .'<rect x="620" y="180" width="440" height="300" rx="20" fill="#0b1017" stroke="#c8f24e" stroke-opacity=".45"/>'
                .'<rect x="668" y="238" width="180" height="14" rx="7" fill="#f4f5f2" opacity=".55"/>'
                .'<rect x="668" y="278" width="110" height="14" rx="7" fill="'.$ac.'" opacity=".85"/>'
                .'<rect x="668" y="380" width="300" height="6" rx="3" fill="#f4f5f2" opacity=".18"/>',

            default => '<circle cx="240" cy="180" r="200" fill="'.$ac.'" opacity=".14"/>'
                .'<text x="80" y="470" fill="'.$ac.'" font-family="monospace" font-size="180" opacity=".9"'
                .' letter-spacing="10">'.e(mb_strtoupper(mb_substr($w['client'] ?? 'F', 0, 2))).'</text>'
                .'<rect x="86" y="510" width="420" height="6" rx="3" fill="#c8f24e" opacity=".7"/>'
                .'<g fill="#f4f5f2" opacity=".2">'
                .'<rect x="700" y="200" width="380" height="14" rx="7"/><rect x="700" y="240" width="300" height="14" rx="7"/>'
                .'<rect x="700" y="280" width="340" height="14" rx="7"/><rect x="700" y="320" width="220" height="14" rx="7"/>'
                .'</g>',
        };

        return $open.$body.'</svg>';
    }
}
