<?php

namespace App\Support;

use App\Models\Project;
use Throwable;

/**
 * Source of truth for the /work list and its case-study modals.
 *
 * Copy is written in the bilingual shorthand the rest of the site uses:
 *   "English copy||Salinan Bahasa Indonesia"
 * A string without "||" is treated as language-neutral (names, numbers, dates).
 *
 * NOTE: the narrative copy, metrics and document lists below are placeholders
 * carried over from the concept build — swap them for the real numbers before
 * this goes to a client-facing domain.
 */
class Works
{
    /* ---------------------------------------------------------------- i18n */

    /** Split the "en||id" shorthand into a language map. */
    public static function pair($s): array
    {
        $s = (string) $s;
        if (! str_contains($s, '||')) {
            return ['en' => $s, 'id' => null];
        }
        [$en, $id] = array_map('trim', explode('||', $s, 2));

        return ['en' => $en, 'id' => $id !== '' ? $id : null];
    }

    /** Default (English) text for server-rendered output. */
    public static function text($s): string
    {
        return self::pair($s)['en'];
    }

    /** data-en / data-id attributes so motion.js's I18N can swap the copy. */
    public static function attrs($s): string
    {
        $p = self::pair($s);
        if ($p['id'] === null) {
            return '';
        }

        return ' data-en="'.e($p['en']).'" data-id="'.e($p['id']).'"';
    }

    /* ---------------------------------------------------------------- data */

    /** Every work item: the curated set first, then anything added in admin. */
    public static function all(): array
    {
        $items = array_merge(self::curated(), self::fromDatabase());

        foreach ($items as $i => &$item) {
            $item['n'] = str_pad((string) ($i + 1), 3, '0', STR_PAD_LEFT);
        }

        return $items;
    }

    /** The hand-written set — see works-data.php. */
    protected static function curated(): array
    {
        return require __DIR__.'/works-data.php';
    }

    /** Projects entered through /admin/projects, mapped into the same shape. */
    protected static function fromDatabase(): array
    {
        try {
            $rows = Project::latest()->get();
        } catch (Throwable $e) {
            return [];   // no database on this environment — the curated set still renders
        }

        return $rows->map(fn (Project $p) => array_filter([
            'slug' => 'p'.$p->id.'-'.\Illuminate\Support\Str::slug($p->title),
            'title' => $p->title,
            'client' => $p->client ?: 'Fugo Creative',
            'category' => $p->category ?: 'Design',
            'year' => (string) ($p->year ?: $p->created_at?->format('Y')),
            'division' => $p->category ?: null,
            'bg' => '#101722',
            'accent' => '#3ddc97',
            'hero_image' => $p->hero_image ?: null,
            'lede' => $p->challenge ?: null,
            'about' => $p->solution ?: null,
            'result' => $p->result ?: null,
        ]))->all();
    }

    /* ------------------------------------------------------------ artwork  */

    /**
     * Deterministic placeholder artwork. Every project gets its own palette and
     * every tile within a project a different composition, so the gallery reads
     * as a gallery until real photography and film stills are dropped in.
     */
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
