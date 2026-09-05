<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $category = $request->get('category', 'all');

        $projects = Project::query()
            ->when($search, fn ($q) => $q->where('title', 'like', '%'.$search.'%'))
            ->when($category !== 'all', fn ($q) => $q->where('category', $category))
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = ['all' => 'All Categories', 'design' => 'Design', 'production' => 'Production', 'event' => 'Events', 'merch' => 'Merch'];

        return view('admin.portfolio.projects.index', compact('projects', 'categories', 'search', 'category'));
    }

    public function create(string $locale)
    {
        $categories = ['design' => 'Design', 'production' => 'Production', 'event' => 'Events', 'merch' => 'Merch'];

        return view('admin.portfolio.projects.create', compact('categories', 'locale'));
    }

    public function store(Request $request, string $locale)
    {
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'client_name'     => 'nullable|string|max:255',
            'category'        => 'required|in:design,production,event,merch',
            'description'     => 'nullable|string',
            'lede'            => 'nullable|string',
            'year'            => 'nullable|string|max:10',
            'scope'           => 'nullable|string',
            'division'        => 'nullable|string',
            'bg_color'        => 'nullable|string|max:7',
            'accent_color'    => 'nullable|string|max:7',
            'tags'            => 'nullable|array',
            'tags.*'          => 'nullable|string',
            'about'           => 'nullable|array',
            'about.*'         => 'nullable|string',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:25600',
            'hero_image'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:25600',
            'logo'            => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:25600',
            'gallery_file'    => 'nullable|array',
            'gallery_file.*'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:25600',
            'gallery_existing_src' => 'nullable|array',
            'sort_order'      => 'nullable|integer',
            'homepage_order'  => 'nullable|integer',
            'is_featured'     => 'sometimes|boolean',
            'is_active'       => 'sometimes|boolean',
            'case_study'      => 'nullable|string|max:500',
        ]);
        // ponytail: file objects must not be mass-assigned to DB string columns
        unset($validated['image'], $validated['hero_image'], $validated['logo'], $validated['gallery_file'], $validated['gallery_existing_src']);

        $complex = $this->parseComplexFields($request, null, $locale);
        // ponytail: unique slug to avoid 500 on duplicate title
        $baseSlug = $validated['title'] ? Str::slug($validated['title']) : Str::random(8);
        $slug = $baseSlug ?: Str::random(8);
        $n = 1; while (Project::where('slug', $slug)->exists()) { $slug = $baseSlug . '-' . (++$n); if ($n > 100) { $slug = $baseSlug . '-' . Str::random(4); break; } }
        $project = Project::create(array_merge($validated, $complex, [
            'slug'            => $slug,
            'description'     => $validated['description'] ?? $request->input('description') ?? '',
            'sort_order'      => $validated['sort_order'] ?? (Project::max('sort_order') + 1),
            'homepage_order'  => $validated['homepage_order'] ?? 0,
            'is_featured'     => $request->has('is_featured'),
            'is_active'       => $request->has('is_active'),
            'tags'            => $complex['tags'] ?? $validated['tags'] ?? null,
            'about'           => $complex['about'] ?? $validated['about'] ?? null,
            'steps'           => $complex['steps'] ?? null,
            'stats'           => $complex['stats'] ?? null,
            'gallery'         => $complex['gallery'] ?? null,
            'docs'            => $complex['docs'] ?? null,
            'usecases'        => $complex['usecases'] ?? null,
            'credits'         => $complex['credits'] ?? null,
            'result'          => $complex['result'] ?? $validated['result'] ?? ($request->input('result_text') ?: ($validated['lede'] ?? null)),
            'case_study'      => $validated['case_study'] ?? $request->input('case_study'),
        ]));

        $this->handleUploads($request, $project);

        return redirect()->route('admin.portfolio.projects.index', ['locale' => $locale])->with('success', 'Project berhasil dibuat!');
    }

    public function edit(string $locale, Project $project)
    {
        $categories = ['design' => 'Design', 'production' => 'Production', 'event' => 'Events', 'merch' => 'Merch'];

        return view('admin.portfolio.projects.edit', compact('project', 'categories', 'locale'));
    }

    public function update(Request $request, string $locale, Project $project)
    {
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'client_name'     => 'nullable|string|max:255',
            'category'        => 'required|in:design,production,event,merch',
            'description'     => 'nullable|string',
            'lede'            => 'nullable|string',
            'year'            => 'nullable|string|max:10',
            'scope'           => 'nullable|string',
            'division'        => 'nullable|string',
            'bg_color'        => 'nullable|string|max:7',
            'accent_color'    => 'nullable|string|max:7',
            'tags'            => 'nullable|array',
            'tags.*'          => 'nullable|string',
            'about'           => 'nullable|array',
            'about.*'         => 'nullable|string',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:25600',
            'hero_image'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:25600',
            'logo'            => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:25600',
            'gallery_file'    => 'nullable|array',
            'gallery_file.*'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:25600',
            'gallery_existing_src' => 'nullable|array',
            'sort_order'      => 'nullable|integer',
            'homepage_order'  => 'nullable|integer',
            'is_featured'     => 'sometimes|boolean',
            'is_active'       => 'sometimes|boolean',
            'case_study'      => 'nullable|string|max:500',
        ]);
        unset($validated['image'], $validated['hero_image'], $validated['logo'], $validated['gallery_file'], $validated['gallery_existing_src']);

        $complex = $this->parseComplexFields($request, $project, $locale);
        $project->update(array_merge($validated, $complex, [
            'is_featured'  => $request->has('is_featured'),
            'is_active'    => $request->has('is_active'),
            // locale-aware: preserve opposite language side from DB, so use complex even if "empty-looking"
            'tags'            => array_key_exists('tags', $complex) ? $complex['tags'] : ($validated['tags'] ?? $project->tags),
            'about'           => array_key_exists('about', $complex) ? $complex['about'] : $project->about,
            'steps'           => array_key_exists('steps', $complex) ? $complex['steps'] : $project->steps,
            'stats'           => array_key_exists('stats', $complex) ? $complex['stats'] : $project->stats,
            'gallery'         => array_key_exists('gallery', $complex) ? $complex['gallery'] : $project->gallery,
            'docs'            => array_key_exists('docs', $complex) ? $complex['docs'] : $project->docs,
            'usecases'        => array_key_exists('usecases', $complex) ? $complex['usecases'] : $project->usecases,
            'credits'         => array_key_exists('credits', $complex) ? $complex['credits'] : $project->credits,
            'result'          => array_key_exists('result', $complex) ? $complex['result'] : ($request->input('result_text') ?: ($validated['lede'] ?? $project->result)),
            'description'     => $validated['description'] ?? $project->description,
            // lede is bilingual via complex; validated lede is legacy fallback
            'lede'            => array_key_exists('lede', $complex) ? $complex['lede'] : ($validated['lede'] ?? $project->lede),
            'scope'           => array_key_exists('scope', $complex) ? $complex['scope'] : $project->scope,
            'division'        => array_key_exists('division', $complex) ? $complex['division'] : $project->division,
        ]));

        $this->handleUploads($request, $project);

        return redirect()->route('admin.portfolio.projects.index', ['locale' => $locale])->with('success', 'Project berhasil diupdate!');
    }

    public function destroy(string $locale, Project $project)
    {
        $project->delete();

        return redirect()->route('admin.portfolio.projects.index', ['locale' => $locale])->with('success', 'Project berhasil dihapus!');
    }

    public function updateSortOrder(Request $request)
    {
        $request->validate(['order' => 'required|array', 'order.*' => 'integer|exists:projects,id']);

        foreach ($request->order as $index => $projectId) {
            Project::where('id', $projectId)->update(['sort_order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    protected function parseComplexFields(Request $request, ?Project $project = null, string $locale = 'en'): array
    {
        $locale = in_array($locale, ['en','id']) ? $locale : 'en';
        $combine = fn(?string $en, ?string $id): ?string => $this->combineEnId($en, $id);
        // locale-aware combine: keep empty side marker when editing single locale
        $combineLocale = function(?string $en, ?string $id) use ($combine): ?string {
            $en = trim((string)$en); $id = trim((string)$id);
            if ($en === '' && $id === '') return null;
            if ($en !== '' && $id !== '') return $en . '||' . $id;
            if ($en !== '') return $en;
            return '||' . $id; // preserve ID-only as ||ID so pair() keeps it as id side
        };
        $split = function($v): array {
            if ($v === null || $v === '') return ['en'=>'','id'=>''];
            // use Works::pair logic inline to avoid circular dep
            $s = is_array($v) ? ($v['en'] ?? $v[0] ?? '') : (string)$v;
            $s = trim((string)$s);
            if ($s === '') return ['en'=>'','id'=>''];
            // normalize double-encoded JSON quickly
            for ($k=0;$k<2;$k++) { $t=trim($s); if ($t===''||($t[0]!=='"'&&$t[0]!=='[')) break; $d=json_decode($t,true); if(json_last_error()!==0) break; if(is_string($d)){ $s=$d; continue; } break; }
            if (!str_contains($s,'||')) return ['en'=>$s,'id'=>''];
            [$en,$id]=array_map('trim', explode('||',$s,2));
            // handle ||ID case where en empty
            if ($en === '' && str_starts_with($s,'||')) return ['en'=>'','id'=>$id];
            return ['en'=>$en,'id'=>$id];
        };
        $out = [];
        $tags = $request->input('tags', []);
        if (is_array($tags) && count($tags) === 1 && is_string($tags[0]) && str_starts_with(trim($tags[0]), '[')) {
            $dec = json_decode($tags[0], true);
            if (json_last_error() === 0 && is_array($dec)) $tags = $dec;
        }
        $tags = array_values(array_filter(array_map(fn($t) => is_string($t) ? trim($t) : '', (array) $tags)));
        if (!empty($tags)) $out['tags'] = $tags;

        // bilingual scalars: locale-aware merge (preserve opposite side from DB)
        $existingScope = $split($project?->scope ?? null);
        $existingDivision = $split($project?->division ?? null);
        $existingLede = $split($project?->lede ?? null);
        $existingResult = $split($project?->result ?? null);

        if ($locale === 'en') {
            if ($request->has('scope_en') || $project === null) {
                $en = trim((string) $request->input('scope_en',''));
                $id = $existingScope['id'];
                $v = $en === '' && $id === '' ? null : $combineLocale($en ?: null, $id ?: null);
                if ($v !== null) $out['scope'] = $v; elseif ($project && $en === '' && $id === '') $out['scope'] = null;
            }
            if ($request->has('division_en') || $project === null) {
                $en = trim((string) $request->input('division_en',''));
                $id = $existingDivision['id'];
                $v = $en === '' && $id === '' ? null : $combineLocale($en ?: null, $id ?: null);
                if ($v !== null) $out['division'] = $v;
            }
            if ($request->has('lede_en') || $project === null) {
                $en = trim((string) $request->input('lede_en',''));
                $id = $existingLede['id'];
                $v = $en === '' && $id === '' ? null : $combineLocale($en ?: null, $id ?: null);
                if ($v !== null) $out['lede'] = $v; elseif ($project && $en === '' && $id === '') $out['lede'] = null;
            }
        } else {
            if ($request->has('scope_id') || $project === null) {
                $id = trim((string) $request->input('scope_id',''));
                $en = $existingScope['en'];
                $v = $en === '' && $id === '' ? null : $combineLocale($en ?: null, $id ?: null);
                if ($v !== null) $out['scope'] = $v;
            }
            if ($request->has('division_id') || $project === null) {
                $id = trim((string) $request->input('division_id',''));
                $en = $existingDivision['en'];
                $v = $en === '' && $id === '' ? null : $combineLocale($en ?: null, $id ?: null);
                if ($v !== null) $out['division'] = $v;
            }
            if ($request->has('lede_id') || $project === null) {
                $id = trim((string) $request->input('lede_id',''));
                $en = $existingLede['en'];
                $v = $en === '' && $id === '' ? null : $combineLocale($en ?: null, $id ?: null);
                if ($v !== null) $out['lede'] = $v;
            }
        }
        // result: support result_en/id and result_text fallback (non-locale)
        if ($request->has('result_en') || $request->has('result_id')) {
            if ($locale === 'en' && $request->has('result_en')) {
                $en = trim((string) $request->input('result_en',''));
                $id = $existingResult['id'];
                $v = $en === '' && $id === '' ? null : $combineLocale($en ?: null, $id ?: null);
                if ($v !== null) $out['result'] = $v; else if ($project) $out['result'] = null;
            } elseif ($locale === 'id' && $request->has('result_id')) {
                $id = trim((string) $request->input('result_id',''));
                $en = $existingResult['en'];
                $v = $en === '' && $id === '' ? null : $combineLocale($en ?: null, $id ?: null);
                if ($v !== null) $out['result'] = $v; else if ($project) $out['result'] = null;
            } else {
                // legacy both sides sent
                $v = $combine($request->input('result_en'), $request->input('result_id'));
                if ($v !== null) $out['result'] = $v;
            }
        } elseif ($request->input('result_text') !== null) {
            $out['result'] = trim((string)$request->input('result_text')) ?: null;
        } elseif ($request->has('result')) {
            $out['result'] = $request->input('result');
        }
        // if nothing set and creating, ensure not unset for scalars that were sent empty -> allow clearing

        // about: locale-aware array merge
        $existingAbout = $project?->about ?? [];
        if ($locale === 'en' && ($request->has('about_en') || $project === null)) {
            $ae = (array) $request->input('about_en', []);
            $about = [];
            $max = max(count($ae), count($existingAbout));
            if ($project === null) $max = count($ae);
            for ($i=0;$i<$max;$i++) {
                $en = trim((string)($ae[$i] ?? ''));
                $existingId = '';
                if (isset($existingAbout[$i])) {
                    $p = $split($existingAbout[$i]);
                    $existingId = $p['id'];
                    // if existing was single EN and we are merging, keep as id? Use split en/id
                    // when editing EN, preserve ID side
                }
                if ($en === '' && $existingId === '' && $project) {
                    // both empty -> skip unless it's beyond request count and was existing? For locale edit, if user removed item, ae count < existing count, we skip trailing
                    if ($i >= count($ae)) continue;
                    // if within ae but both empty, skip entry
                    continue;
                }
                if ($i >= count($ae)) continue; // removed item
                $v = $combineLocale($en ?: null, $existingId ?: null);
                if ($v !== null && $v !== '||') $about[] = $v;
                elseif ($en !== '' || $existingId !== '') $about[] = $v ?? $en;
            }
            $out['about'] = $about;
        } elseif ($locale === 'id' && ($request->has('about_id') || $project === null)) {
            $ai = (array) $request->input('about_id', []);
            $about = [];
            $max = $project ? max(count($ai), count($existingAbout)) : count($ai);
            if ($project === null) $max = count($ai);
            for ($i=0;$i<$max;$i++) {
                $id = trim((string)($ai[$i] ?? ''));
                $existingEn = '';
                if (isset($existingAbout[$i])) { $p=$split($existingAbout[$i]); $existingEn=$p['en']; }
                if ($id === '' && $existingEn === '' && $project) { if ($i >= count($ai)) continue; continue; }
                if ($i >= count($ai)) continue;
                $v = $combineLocale($existingEn ?: null, $id ?: null);
                if ($v !== null && $v !== '||') $about[] = $v;
            }
            $out['about'] = $about;
        } elseif ($request->has('about_en') || $request->has('about_id')) {
            $ae = (array) $request->input('about_en', []); $ai = (array) $request->input('about_id', []);
            $about = []; for ($i=0; $i<max(count($ae),count($ai)); $i++) {
                $v = $combine(trim($ae[$i] ?? ''), trim($ai[$i] ?? '')) ?? trim($ae[$i] ?? $ai[$i] ?? '');
                if ($v !== '') $about[] = $v;
            }
            if (!empty($about)) $out['about'] = $about; elseif ($request->has('about_en')) $out['about'] = [];
        } else {
            $about = array_values(array_filter(array_map('trim', (array) $request->input('about', []))));
            if (!empty($about)) $out['about'] = $about;
        }

        // steps: locale-aware
        $existingSteps = $project?->steps ?? [];
        $hasStepsEn = $request->has('steps') && (isset($request->input('steps')['h_en']) || isset($request->input('steps')['p_en']) || $request->has('steps.h_en'));
        // detect locale-specific steps input
        $stepsEnH = (array)($request->input('steps.h_en') ?? []);
        $stepsEnP = (array)($request->input('steps.p_en') ?? []);
        $stepsIdH = (array)($request->input('steps.h_id') ?? []);
        $stepsIdP = (array)($request->input('steps.p_id') ?? []);
        $isStepsLocale = !empty($stepsEnH) || !empty($stepsEnP) || !empty($stepsIdH) || !empty($stepsIdP) || $request->has('steps.h_en') || $request->has('steps.h_id');
        if ($locale === 'en' && ($request->has('steps.h_en') || $request->has('steps.p_en') || $project === null && $isStepsLocale)) {
            $steps=[]; $cnt = $project ? max(count($stepsEnH), count($stepsEnP), count($existingSteps)) : max(count($stepsEnH), count($stepsEnP));
            if ($project === null) $cnt = max(count($stepsEnH), count($stepsEnP));
            for($i=0;$i<$cnt;$i++){
                if ($project && $i >= count($stepsEnH) && $i >= count($stepsEnP)) {
                    // no input for this index -> removed
                    if ($i < count($existingSteps)) continue;
                }
                if ($project && $i >= max(count($stepsEnH),count($stepsEnP)) && $i < count($existingSteps)) continue;
                $hEn = trim((string)($stepsEnH[$i] ?? ''));
                $pEn = trim((string)($stepsEnP[$i] ?? ''));
                $exHId = ''; $exPId='';
                if (isset($existingSteps[$i])) { $ph=$split($existingSteps[$i]['h'] ?? ''); $pp=$split($existingSteps[$i]['p'] ?? ''); $exHId=$ph['id']; $exPId=$pp['id']; }
                // if locale en has no data for this index beyond count, skip (deleted)
                if ($i >= count($stepsEnH) && $i >= count($stepsEnP)) continue;
                $h = $combineLocale($hEn ?: null, $exHId ?: null);
                $p = $combineLocale($pEn ?: null, $exPId ?: null);
                $hVal = $h; $pVal = $p;
                // normalize null/empty
                if (($hVal===null || $hVal==='||') && ($pVal===null || $pVal==='||')) continue;
                $steps[]=['h'=>$hVal ?? '','p'=>$pVal ?? ''];
            }
            $out['steps']=$steps;
        } elseif ($locale === 'id' && ($request->has('steps.h_id') || $request->has('steps.p_id'))) {
            $steps=[]; $cnt = max(count($stepsIdH), count($stepsIdP), count($existingSteps));
            if ($project === null) $cnt = max(count($stepsIdH), count($stepsIdP));
            for($i=0;$i<$cnt;$i++){
                if ($i >= count($stepsIdH) && $i >= count($stepsIdP)) continue;
                $hId = trim((string)($stepsIdH[$i] ?? ''));
                $pId = trim((string)($stepsIdP[$i] ?? ''));
                $exHEn=''; $exPEn='';
                if(isset($existingSteps[$i])){ $ph=$split($existingSteps[$i]['h']??''); $pp=$split($existingSteps[$i]['p']??''); $exHEn=$ph['en']; $exPEn=$pp['en']; }
                $h=$combineLocale($exHEn?:null, $hId?:null);
                $p=$combineLocale($exPEn?:null, $pId?:null);
                if(($h===null||$h==='||')&&($p===null||$p==='||')) continue;
                $steps[]=['h'=>$h??'','p'=>$p??''];
            }
            $out['steps']=$steps;
        } elseif ($request->has('steps')) {
            $hEn = (array) ($request->input('steps.h_en') ?? $request->input('steps.h') ?? []);
            $hId = (array) ($request->input('steps.h_id') ?? []);
            $pEn = (array) ($request->input('steps.p_en') ?? $request->input('steps.p') ?? []);
            $pId = (array) ($request->input('steps.p_id') ?? []);
            if (empty($hEn) && empty($hId)) { $hEn=(array)$request->input('steps.h',[]); $hId=[]; }
            if (empty($pEn) && empty($pId)) { $pEn=(array)$request->input('steps.p',[]); $pId=[]; }
            $steps=[]; for($i=0;$i<max(count($hEn),count($hId),count($pEn),count($pId));$i++){
                $h=$combine(trim($hEn[$i]??''), trim($hId[$i]??'')) ?? trim($hEn[$i]??$hId[$i]??'');
                $p=$combine(trim($pEn[$i]??''), trim($pId[$i]??'')) ?? trim($pEn[$i]??$pId[$i]??'');
                if($h!==''||$p!=='') $steps[]=['h'=>$h,'p'=>$p];
            }
            if(!empty($steps)) $out['steps']=$steps; elseif($request->has('steps')) $out['steps']=[];
        } else { $sh=(array)$request->input('steps.h',[]); $sp=(array)$request->input('steps.p',[]); $steps=[]; for($i=0;$i<max(count($sh),count($sp));$i++){ $h=trim($sh[$i]??''); $p=trim($sp[$i]??''); if($h!==''||$p!=='') $steps[]=['h'=>$h,'p'=>$p]; } if(!empty($steps)) $out['steps']=$steps; }

        $sn=(array)$request->input('stats.n',[]); $ss=(array)$request->input('stats.suffix',[]); 
        $existingStats = $project?->stats ?? [];
        $slEn=(array)($request->input('stats.l_en') ?? $request->input('stats.l') ?? []); $slId=(array)($request->input('stats.l_id') ?? []);
        $isStatsLocale = $request->has('stats.l_en') || $request->has('stats.l_id');
        if ($locale === 'en' && $request->has('stats.l_en')) {
            $stats=[]; $cnt = $project ? max(count($sn),count($ss),count($slEn),count($existingStats)) : max(count($sn),count($ss),count($slEn));
            if ($project===null) $cnt = max(count($sn),count($ss),count($slEn));
            for($i=0;$i<$cnt;$i++){
                if($project && $i>=count($slEn) && $i>=count($sn) && $i>=count($ss)) continue;
                $n=trim((string)($sn[$i]?? ($existingStats[$i]['n']??'')));
                $suf=trim((string)($ss[$i]?? ($existingStats[$i]['suffix']??'')));
                $lEn=trim((string)($slEn[$i]??''));
                $exLId=''; if(isset($existingStats[$i])){ $pl=$split($existingStats[$i]['l']??''); $exLId=$pl['id']; }
                if($i>=count($slEn) && $project) continue;
                $l=$combineLocale($lEn?:null,$exLId?:null);
                if($n!==''||($l!==null&&$l!==''&&$l!=='||')) $stats[]=['n'=>$n,'suffix'=>$suf,'l'=>$l??''];
            }
            if(!empty($stats)) $out['stats']=$stats; else if($request->has('stats')) $out['stats']=null;
        } elseif ($locale === 'id' && $request->has('stats.l_id')) {
            $stats=[]; $cnt = max(count($sn),count($ss),count($slId),count($existingStats));
            if($project===null) $cnt = max(count($sn),count($ss),count($slId));
            for($i=0;$i<$cnt;$i++){
                if($i>=count($slId) && $project) continue;
                $n=trim((string)($sn[$i]?? ($existingStats[$i]['n']??'')));
                $suf=trim((string)($ss[$i]?? ($existingStats[$i]['suffix']??'')));
                $lId=trim((string)($slId[$i]??''));
                $exLEn=''; if(isset($existingStats[$i])){ $pl=$split($existingStats[$i]['l']??''); $exLEn=$pl['en']; }
                $l=$combineLocale($exLEn?:null,$lId?:null);
                if($n!==''||($l!==null&&$l!=='')) $stats[]=['n'=>$n,'suffix'=>$suf,'l'=>$l??''];
            }
            if(!empty($stats)) $out['stats']=$stats; else if($request->has('stats')) $out['stats']=null;
        } else {
            if (empty($slEn) && empty($slId)) $slEn=(array)$request->input('stats.l',[]);
            $stats=[]; for($i=0;$i<max(count($sn),count($ss),count($slEn),count($slId));$i++){ $n=trim($sn[$i]??''); $l=$combine(trim($slEn[$i]??''), trim($slId[$i]??'')) ?? trim($slEn[$i]??$slId[$i]??''); if($n!==''||$l!=='') $stats[]=['n'=>$n,'suffix'=>trim($ss[$i]??''),'l'=>$l]; }
            if(!empty($stats)) $out['stats']=$stats; else if($request->has('stats')) $out['stats']=null;
        }

        // gallery locale-aware
        $existingGallery = $project?->gallery ?? [];
        $hasGalEn = $request->has('gallery.kind_en') || $request->has('gallery.cap_en');
        $hasGalId = $request->has('gallery.kind_id') || $request->has('gallery.cap_id');
        if (($locale==='en' && $hasGalEn) || ($locale==='id' && $hasGalId)) {
            $gkEn=(array)($request->input('gallery.kind_en') ?? []); $gkId=(array)($request->input('gallery.kind_id') ?? []);
            $gcEn=(array)($request->input('gallery.cap_en') ?? []); $gcId=(array)($request->input('gallery.cap_id') ?? []);
            $gt=(array)$request->input('gallery.type',[]); $gv=(array)$request->input('gallery.video_url',[]);
            $gsrc=(array)$request->input('gallery_existing_src',[]);
            // for locale edit, only one side will be present; fill missing from DB
            $cnt = $project ? max(count($gkEn),count($gkId),count($gcEn),count($gcId),count($gt),count($gsrc),count($existingGallery)) : max(count($gkEn),count($gkId),count($gcEn),count($gcId),count($gt));
            if ($project===null) $cnt = max(count($gkEn),count($gcEn),count($gt),count($gkId),count($gcId));
            $gallery=[]; 
            for($i=0;$i<$cnt;$i++){
                // determine if this index was submitted (for locale); if not and project exists, treat as deleted
                $submitted = false;
                if ($locale==='en') $submitted = array_key_exists($i, $gkEn) || array_key_exists($i, $gcEn) || array_key_exists($i, $gt);
                else $submitted = array_key_exists($i, $gkId) || array_key_exists($i, $gcId) || array_key_exists($i, $gt);
                if ($project && !$submitted && $i < count($existingGallery)) {
                    // check if beyond submitted count -> deleted row
                    $maxSubmitted = $locale==='en' ? max(count($gkEn),count($gcEn),count($gt)) : max(count($gkId),count($gcId),count($gt));
                    if ($i >= $maxSubmitted) continue;
                }
                if ($project && !$submitted) continue;
                $t=$gt[$i] ?? ($existingGallery[$i]['type'] ?? 'art');
                $ex = $existingGallery[$i] ?? null;
                $exK = $ex ? $split($ex['kind'] ?? '') : ['en'=>'','id'=>''];
                $exC = $ex ? $split($ex['cap'] ?? '') : ['en'=>'','id'=>''];
                if ($locale==='en') {
                    $kEn = trim((string)($gkEn[$i] ?? '')); $k = $combineLocale($kEn ?: null, $exK['id'] ?: null);
                    $cEn = trim((string)($gcEn[$i] ?? '')); $c = $combineLocale($cEn ?: null, $exC['id'] ?: null);
                } else {
                    $kId = trim((string)($gkId[$i] ?? '')); $k = $combineLocale($exK['en'] ?: null, $kId ?: null);
                    $cId = trim((string)($gcId[$i] ?? '')); $c = $combineLocale($exC['en'] ?: null, $cId ?: null);
                }
                $exSrc=trim((string)($gsrc[$i] ?? ($ex['src'] ?? '')));
                $src = ($t==='image' && $exSrc!=='') ? $exSrc : null;
                $video = $t==='video_url' ? trim((string)($gv[$i] ?? ($ex['video'] ?? ''))) : null;
                // keep if any data
                $kVal = $k; $cVal = $c;
                if(($kVal===null||$kVal===''||$kVal==='||')&&($cVal===null||$cVal===''||$cVal==='||')&&$t==='art'&&$src===null&&!$video) continue;
                $item=['kind'=>$kVal ?? '','cap'=>$cVal ?? '','type'=>$t,'video'=>$video];
                if($src) $item['src']=$src;
                $gallery[]=$item;
            }
            if(!empty($gallery)) $out['gallery']=$gallery; else if($request->has('gallery')) $out['gallery']=[] ;
        } else {
            $gkEn=(array)($request->input('gallery.kind_en') ?? $request->input('gallery.kind') ?? []); $gkId=(array)($request->input('gallery.kind_id') ?? []);
            $gcEn=(array)($request->input('gallery.cap_en') ?? $request->input('gallery.cap') ?? []); $gcId=(array)($request->input('gallery.cap_id') ?? []);
            $gt=(array)$request->input('gallery.type',[]); $gv=(array)$request->input('gallery.video_url',[]);
            $gsrc=(array)$request->input('gallery_existing_src',[]);
            if(empty($gkEn)&&empty($gkId)) $gkEn=(array)$request->input('gallery.kind',[]); if(empty($gcEn)&&empty($gcId)) $gcEn=(array)$request->input('gallery.cap',[]);
            $gallery=[]; for($i=0;$i<max(count($gkEn),count($gkId),count($gcEn),count($gcId),count($gt),count($gsrc));$i++){
                $k=$combine(trim($gkEn[$i]??''), trim($gkId[$i]??'')) ?? trim($gkEn[$i]??$gkId[$i]??'');
                $c=$combine(trim($gcEn[$i]??''), trim($gcId[$i]??'')) ?? trim($gcEn[$i]??$gcId[$i]??'');
                $t=$gt[$i]??'art';
                $exSrc=trim($gsrc[$i] ?? '');
                $src = ($t==='image' && $exSrc!=='') ? $exSrc : null;
                $video = $t==='video_url' ? trim($gv[$i]??'') : null;
                if($k!==''||$c!==''||$t!=='art'||$src!==null||$video){
                    $item=['kind'=>$k,'cap'=>$c,'type'=>$t,'video'=>$video];
                    if($src) $item['src']=$src;
                    $gallery[]=$item;
                }
            }
            if(!empty($gallery)) $out['gallery']=$gallery; else if($request->has('gallery')) $out['gallery']=[] ;
        }

        $existingDocs = $project?->docs ?? [];
        $hasDocsEn = $request->has('docs.label_en') || $request->has('docs.meta_en');
        $hasDocsId = $request->has('docs.label_id') || $request->has('docs.meta_id');
        if (($locale==='en' && $hasDocsEn) || ($locale==='id' && $hasDocsId)) {
            $dlEn=(array)($request->input('docs.label_en') ?? []); $dlId=(array)($request->input('docs.label_id') ?? []);
            $dmEn=(array)($request->input('docs.meta_en') ?? []); $dmId=(array)($request->input('docs.meta_id') ?? []);
            $dh=(array)$request->input('docs.href',[]);
            $cnt = $project ? max(count($dlEn),count($dlId),count($dmEn),count($dmId),count($dh),count($existingDocs)) : max(count($dlEn),count($dmEn),count($dh));
            if($project===null) $cnt = max(count($dlEn),count($dlId),count($dmEn),count($dmId),count($dh));
            $docs=[]; for($i=0;$i<$cnt;$i++){
                $submitted = $locale==='en' ? array_key_exists($i,$dlEn) : array_key_exists($i,$dlId);
                if($project && !$submitted) { $maxS = $locale==='en'? max(count($dlEn),count($dmEn)): max(count($dlId),count($dmId)); if($i>=$maxS) continue; if(!$submitted) continue; }
                $ex = $existingDocs[$i] ?? null;
                $exL = $ex ? $split($ex['label']??'') : ['en'=>'','id'=>''];
                $exM = $ex ? $split($ex['meta']??'') : ['en'=>'','id'=>''];
                if($locale==='en'){
                    $lEn=trim((string)($dlEn[$i]??'')); $l=$combineLocale($lEn?:null,$exL['id']?:null);
                    $mEn=trim((string)($dmEn[$i]??'')); $m=$combineLocale($mEn?:null,$exM['id']?:null);
                } else {
                    $lId=trim((string)($dlId[$i]??'')); $l=$combineLocale($exL['en']?:null,$lId?:null);
                    $mId=trim((string)($dmId[$i]??'')); $m=$combineLocale($exM['en']?:null,$mId?:null);
                }
                if(($l===null||$l===''||$l==='||')) continue;
                $docs[]=['label'=>$l ?? '','meta'=>$m ?? '','href'=>trim((string)($dh[$i] ?? ($ex['href']??'')))];
            }
            if(!empty($docs)) $out['docs']=$docs; else if($request->has('docs')) $out['docs']=[] ;
        } else {
            $dlEn=(array)($request->input('docs.label_en') ?? $request->input('docs.label') ?? []); $dlId=(array)($request->input('docs.label_id') ?? []);
            $dmEn=(array)($request->input('docs.meta_en') ?? $request->input('docs.meta') ?? []); $dmId=(array)($request->input('docs.meta_id') ?? []);
            $dh=(array)$request->input('docs.href',[]);
            if(empty($dlEn)&&empty($dlId)) $dlEn=(array)$request->input('docs.label',[]); if(empty($dmEn)&&empty($dmId)) $dmEn=(array)$request->input('docs.meta',[]);
            $docs=[]; for($i=0;$i<max(count($dlEn),count($dlId));$i++){ $l=$combine(trim($dlEn[$i]??''), trim($dlId[$i]??'')) ?? trim($dlEn[$i]??$dlId[$i]??''); if($l!=='') $docs[]=['label'=>$l,'meta'=>($combine(trim($dmEn[$i]??''), trim($dmId[$i]??'')) ?? trim($dmEn[$i]??$dmId[$i]??'')), 'href'=>trim($dh[$i]??'')]; }
            if(!empty($docs)) $out['docs']=$docs; else if($request->has('docs')) $out['docs']=[] ;
        }

        $existingUses = $project?->usecases ?? [];
        $hasUsesEn = $request->has('usecases.h_en') || $request->has('usecases.p_en');
        $hasUsesId = $request->has('usecases.h_id') || $request->has('usecases.p_id');
        if (($locale==='en' && $hasUsesEn) || ($locale==='id' && $hasUsesId)) {
            $uhEn=(array)($request->input('usecases.h_en') ?? []); $uhId=(array)($request->input('usecases.h_id') ?? []);
            $upEn=(array)($request->input('usecases.p_en') ?? []); $upId=(array)($request->input('usecases.p_id') ?? []);
            $cnt = $project ? max(count($uhEn),count($uhId),count($upEn),count($upId),count($existingUses)) : max(count($uhEn),count($upEn),count($uhId),count($upId));
            if($project===null) $cnt = max(count($uhEn),count($upEn),count($uhId),count($upId));
            $uses=[]; for($i=0;$i<$cnt;$i++){
                $submitted = $locale==='en' ? (array_key_exists($i,$uhEn)||array_key_exists($i,$upEn)) : (array_key_exists($i,$uhId)||array_key_exists($i,$upId));
                if($project && !$submitted){ $maxS=$locale==='en'?max(count($uhEn),count($upEn)):max(count($uhId),count($upId)); if($i>=$maxS) continue; continue; }
                $ex=$existingUses[$i]??null;
                $exH=$ex? $split($ex['h']??''):['en'=>'','id'=>''];
                $exP=$ex? $split($ex['p']??''):['en'=>'','id'=>''];
                if($locale==='en'){
                    $hEn=trim((string)($uhEn[$i]??'')); $h=$combineLocale($hEn?:null,$exH['id']?:null);
                    $pEn=trim((string)($upEn[$i]??'')); $p=$combineLocale($pEn?:null,$exP['id']?:null);
                } else {
                    $hId=trim((string)($uhId[$i]??'')); $h=$combineLocale($exH['en']?:null,$hId?:null);
                    $pId=trim((string)($upId[$i]??'')); $p=$combineLocale($exP['en']?:null,$pId?:null);
                }
                if(($h===null||$h===''||$h==='||')) continue;
                $uses[]=['h'=>$h??'','p'=>$p??''];
            }
            if(!empty($uses)) $out['usecases']=$uses; else if($request->has('usecases')) $out['usecases']=[] ;
        } else {
            $uhEn=(array)($request->input('usecases.h_en') ?? $request->input('usecases.h') ?? []); $uhId=(array)($request->input('usecases.h_id') ?? []);
            $upEn=(array)($request->input('usecases.p_en') ?? $request->input('usecases.p') ?? []); $upId=(array)($request->input('usecases.p_id') ?? []);
            if(empty($uhEn)&&empty($uhId)) $uhEn=(array)$request->input('usecases.h',[]); if(empty($upEn)&&empty($upId)) $upEn=(array)$request->input('usecases.p',[]);
            $uses=[]; for($i=0;$i<max(count($uhEn),count($uhId));$i++){ $h=$combine(trim($uhEn[$i]??''), trim($uhId[$i]??'')) ?? trim($uhEn[$i]??$uhId[$i]??''); $p=$combine(trim($upEn[$i]??''), trim($upId[$i]??'')) ?? trim($upEn[$i]??$upId[$i]??''); if($h!=='') $uses[]=['h'=>$h,'p'=>$p]; }
            if(!empty($uses)) $out['usecases']=$uses; else if($request->has('usecases')) $out['usecases']=[] ;
        }

        $existingCredits = $project?->credits ?? [];
        $hasCredEn = $request->has('credits.role_en');
        $hasCredId = $request->has('credits.role_id');
        if (($locale==='en' && $hasCredEn) || ($locale==='id' && $hasCredId)) {
            $crEn=(array)($request->input('credits.role_en') ?? []); $crId=(array)($request->input('credits.role_id') ?? []);
            $cn=(array)$request->input('credits.name',[]);
            $cnt = $project ? max(count($crEn),count($crId),count($cn),count($existingCredits)) : max(count($crEn),count($crId),count($cn));
            if($project===null) $cnt = max(count($crEn),count($crId),count($cn));
            $creds=[]; for($i=0;$i<$cnt;$i++){
                $submitted = $locale==='en' ? array_key_exists($i,$crEn) : array_key_exists($i,$crId);
                if($project && !$submitted){ $maxS=$locale==='en'?count($crEn):count($crId); if($i>=$maxS) continue; continue; }
                $ex=$existingCredits[$i]??null;
                $exR=$ex? $split($ex['role']??''):['en'=>'','id'=>''];
                if($locale==='en'){ $rEn=trim((string)($crEn[$i]??'')); $r=$combineLocale($rEn?:null,$exR['id']?:null); }
                else { $rId=trim((string)($crId[$i]??'')); $r=$combineLocale($exR['en']?:null,$rId?:null); }
                $n=trim((string)($cn[$i]?? ($ex['name']??'')));
                if(($r===null||$r===''||$r==='||')&&$n==='') continue;
                $creds[]=['role'=>$r??'','name'=>$n];
            }
            if(!empty($creds)) $out['credits']=$creds; else if($request->has('credits')) $out['credits']=[] ;
        } else {
            $crEn=(array)($request->input('credits.role_en') ?? $request->input('credits.role') ?? []); $crId=(array)($request->input('credits.role_id') ?? []);
            $cn=(array)$request->input('credits.name',[]);
            if(empty($crEn)&&empty($crId)) $crEn=(array)$request->input('credits.role',[]);
            $creds=[]; for($i=0;$i<max(count($crEn),count($crId),count($cn));$i++){ $r=$combine(trim($crEn[$i]??''), trim($crId[$i]??'')) ?? trim($crEn[$i]??$crId[$i]??''); $n=trim($cn[$i]??''); if($r!==''||$n!=='') $creds[]=['role'=>$r,'name'=>$n]; }
            if(!empty($creds)) $out['credits']=$creds; else if($request->has('credits')) $out['credits']=[] ;
        }

        if(!isset($out['result']) && $request->input('result_text')!==null) $out['result']=trim((string)$request->input('result_text')) ?: null;
        return $out;
    }

    protected function combineEnId(?string $en, ?string $id): ?string
    {
        $en = trim((string) $en); $id = trim((string) $id);
        if ($en === '' && $id === '') return null;
        if ($en !== '' && $id !== '') return $en . '||' . $id;
        return $en !== '' ? $en : $id;
    }

    protected function handleUploads(Request $request, Project $project): void
    {
        $imgDir = public_path('img/projects/'.$project->id);
        if (! is_dir($imgDir)) {
            @mkdir($imgDir, 0775, true);
            @chmod($imgDir, 0775);
        }

        $save = function(string $field, string $basename) use ($request, $project, $imgDir) {
            if (!$request->hasFile($field)) return;
            $file = $request->file($field);
            if (!$file->isValid()) return;
            $ext = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'webp');
            // clean old variants card.* hero.* logo.*
            foreach (glob($imgDir.'/'.$basename.'.*') as $old) @unlink($old);
            // ponytail: move works for any source folder (Downloads, temp); fallback to Storage if open_basedir
            try { $file->move($imgDir, $basename.'.'.$ext); } catch (\Throwable $e) {
                $file->storeAs('projects/'.$project->id, $basename.'.'.$ext, 'public');
                @copy(storage_path('app/public/projects/'.$project->id.'/'.$basename.'.'.$ext), $imgDir.'/'.$basename.'.'.$ext);
            }
            @chmod($imgDir.'/'.$basename.'.'.$ext, 0664);
            $project->update([$field => 'projects/'.$project->id.'/'.$basename.'.'.$ext]);
        };
        $save('image','card');
        $save('hero_image','hero');
        $save('logo','logo');

        // gallery uploads: indexed by gallery position - replaces src on same card, not append
        $rawFiles = $request->file('gallery_file') ?? $request->file('gallery_files') ?? [];
        if (!empty($rawFiles)) {
            $rawFiles = is_array($rawFiles) ? $rawFiles : [$rawFiles];
            $filesAssoc = [];
            foreach ($rawFiles as $k => $f) { if ($f && $f->isValid()) $filesAssoc[$k] = $f; }
            if (!empty($filesAssoc)) {
                $galDir = $imgDir.'/gallery';
                if (! is_dir($galDir)) { @mkdir($galDir, 0775, true); @chmod($galDir,0775); }
                $project->refresh();
                $gallery = $project->gallery ?? [];
                if (empty($gallery) && !empty($filesAssoc)) {
                    foreach (array_values($filesAssoc) as $idx => $file) {
                        $ext=strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'webp');
                        $filename='gal-'.time().'-'.$idx.'-'.Str::random(4).'.'.$ext;
                        try { $file->move($galDir,$filename); } catch (\Throwable $e) {
                            $file->storeAs('projects/'.$project->id.'/gallery',$filename,'public');
                            @copy(storage_path('app/public/projects/'.$project->id.'/gallery/'.$filename), $galDir.'/'.$filename);
                        }
                        @chmod($galDir.'/'.$filename,0664);
                        $gallery[]=['kind'=>'','cap'=>'','type'=>'image','src'=>'projects/'.$project->id.'/gallery/'.$filename];
                    }
                    $project->update(['gallery'=>$gallery]);
                } else {
                    $updated = false;
                    foreach ($gallery as $idx => &$item) {
                        if (($item['type'] ?? 'art') !== 'image') continue;
                        $file = $filesAssoc[$idx] ?? null;
                        if (!$file) continue;
                        $ext=strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'webp');
                        $filename='gal-'.time().'-'.$idx.'-'.Str::random(4).'.'.$ext;
                        try { $file->move($galDir,$filename); } catch (\Throwable $e) {
                            $file->storeAs('projects/'.$project->id.'/gallery',$filename,'public');
                            @copy(storage_path('app/public/projects/'.$project->id.'/gallery/'.$filename), $galDir.'/'.$filename);
                        }
                        @chmod($galDir.'/'.$filename,0664);
                        $item['src']='projects/'.$project->id.'/gallery/'.$filename;
                        $updated = true;
                    }
                    unset($item);
                    if ($updated) $project->update(['gallery'=>$gallery]);
                }
            }
        }
    }
}
