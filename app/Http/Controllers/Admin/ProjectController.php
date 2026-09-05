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

    public function create()
    {
        $categories = ['design' => 'Design', 'production' => 'Production', 'event' => 'Events', 'merch' => 'Merch'];

        return view('admin.portfolio.projects.create', compact('categories'));
    }

    public function store(Request $request)
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
            'sort_order'      => 'nullable|integer',
            'homepage_order'  => 'nullable|integer',
            'is_featured'     => 'sometimes|boolean',
            'is_active'       => 'sometimes|boolean',
        ]);

        $complex = $this->parseComplexFields($request);
        $project = Project::create(array_merge($validated, $complex, [
            'slug'            => $validated['title'] ? Str::slug($validated['title']) : Str::random(8),
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
        ]));

        $this->handleUploads($request, $project);

        return redirect()->route('admin.portfolio.projects.index', ['locale' => $request->route('locale') ?? 'en'])->with('success', 'Project berhasil dibuat!');
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
            'sort_order'      => 'nullable|integer',
            'homepage_order'  => 'nullable|integer',
            'is_featured'     => 'sometimes|boolean',
            'is_active'       => 'sometimes|boolean',
        ]);

        $complex = $this->parseComplexFields($request);
        $project->update(array_merge($validated, $complex, [
            'is_featured'  => $request->has('is_featured'),
            'is_active'    => $request->has('is_active'),
            'tags'            => $complex['tags'] ?? $validated['tags'] ?? $project->tags,
            'about'           => $complex['about'] ?? $validated['about'] ?? $project->about,
            'steps'           => $complex['steps'] ?? $project->steps,
            'stats'           => $complex['stats'] ?? $project->stats,
            'gallery'         => $complex['gallery'] ?? $project->gallery,
            'docs'            => $complex['docs'] ?? $project->docs,
            'usecases'        => $complex['usecases'] ?? $project->usecases,
            'credits'         => $complex['credits'] ?? $project->credits,
            'result'          => $complex['result'] ?? ($request->input('result_text') ?: ($validated['lede'] ?? $project->result)),
            'description'     => $validated['description'] ?? $project->description,
            'lede'            => $validated['lede'] ?? $project->lede,
        ]));

        $this->handleUploads($request, $project);

        return redirect()->route('admin.portfolio.projects.index')->with('success', 'Project berhasil diupdate!');
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

    protected function parseComplexFields(Request $request): array
    {
        $combine = fn(?string $en, ?string $id): ?string => $this->combineEnId($en, $id);
        $out = [];
        $tags = $request->input('tags', []);
        if (is_array($tags) && count($tags) === 1 && is_string($tags[0]) && str_starts_with(trim($tags[0]), '[')) {
            $dec = json_decode($tags[0], true);
            if (json_last_error() === 0 && is_array($dec)) $tags = $dec;
        }
        $tags = array_values(array_filter(array_map(fn($t) => is_string($t) ? trim($t) : '', (array) $tags)));
        if (!empty($tags)) $out['tags'] = $tags;

        // bilingual fields: auto-combine EN+ID -> "EN||ID" storage, no manual || needed
        $out['scope'] = $combine($request->input('scope_en'), $request->input('scope_id')) ?? $request->input('scope');
        $out['division'] = $combine($request->input('division_en'), $request->input('division_id')) ?? $request->input('division');
        $out['lede'] = $combine($request->input('lede_en'), $request->input('lede_id')) ?? $request->input('lede');
        $out['result'] = $combine($request->input('result_en'), $request->input('result_id')) ?? ($request->input('result_text') !== null ? trim((string)$request->input('result_text')) ?: null : $request->input('result'));
        // fallback to unmerged if both new empty (edit without new inputs -> preserve old)
        foreach (['scope','division','lede','result'] as $k) if (!isset($out[$k]) || $out[$k] === '') unset($out[$k]);

        // about: support about_en[]+about_id[] -> ["EN||ID", ...]
        if ($request->has('about_en') || $request->has('about_id')) {
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

        // steps: support h_en/h_id p_en/p_id -> [{h:"EN||ID",p:"EN||ID"},...]
        if ($request->has('steps')) {
            $hEn = (array) ($request->input('steps.h_en') ?? $request->input('steps.h') ?? []);
            $hId = (array) ($request->input('steps.h_id') ?? []);
            $pEn = (array) ($request->input('steps.p_en') ?? $request->input('steps.p') ?? []);
            $pId = (array) ($request->input('steps.p_id') ?? []);
            // fallback to old single arrays if new not sent
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
        $slEn=(array)($request->input('stats.l_en') ?? $request->input('stats.l') ?? []); $slId=(array)($request->input('stats.l_id') ?? []);
        if (empty($slEn) && empty($slId)) $slEn=(array)$request->input('stats.l',[]);
        $stats=[]; for($i=0;$i<max(count($sn),count($ss),count($slEn),count($slId));$i++){ $n=trim($sn[$i]??''); $l=$combine(trim($slEn[$i]??''), trim($slId[$i]??'')) ?? trim($slEn[$i]??$slId[$i]??''); if($n!==''||$l!=='') $stats[]=['n'=>$n,'suffix'=>trim($ss[$i]??''),'l'=>$l]; }
        if(!empty($stats)) $out['stats']=$stats; else if($request->has('stats')) $out['stats']=null;

        $gkEn=(array)($request->input('gallery.kind_en') ?? $request->input('gallery.kind') ?? []); $gkId=(array)($request->input('gallery.kind_id') ?? []);
        $gcEn=(array)($request->input('gallery.cap_en') ?? $request->input('gallery.cap') ?? []); $gcId=(array)($request->input('gallery.cap_id') ?? []);
        $gt=(array)$request->input('gallery.type',[]); $gv=(array)$request->input('gallery.video_url',[]);
        if(empty($gkEn)&&empty($gkId)) $gkEn=(array)$request->input('gallery.kind',[]); if(empty($gcEn)&&empty($gcId)) $gcEn=(array)$request->input('gallery.cap',[]);
        $gallery=[]; for($i=0;$i<max(count($gkEn),count($gkId),count($gcEn),count($gcId),count($gt));$i++){
            $k=$combine(trim($gkEn[$i]??''), trim($gkId[$i]??'')) ?? trim($gkEn[$i]??$gkId[$i]??'');
            $c=$combine(trim($gcEn[$i]??''), trim($gcId[$i]??'')) ?? trim($gcEn[$i]??$gcId[$i]??'');
            $t=$gt[$i]??'art'; if($k!==''||$c!==''||$t!=='art') $gallery[]=['kind'=>$k,'cap'=>$c,'type'=>$t,'video'=>$t==='video_url'?trim($gv[$i]??''):null];
        }
        if(!empty($gallery)) $out['gallery']=$gallery; else if($request->has('gallery')) $out['gallery']=[] ;

        $dlEn=(array)($request->input('docs.label_en') ?? $request->input('docs.label') ?? []); $dlId=(array)($request->input('docs.label_id') ?? []);
        $dmEn=(array)($request->input('docs.meta_en') ?? $request->input('docs.meta') ?? []); $dmId=(array)($request->input('docs.meta_id') ?? []);
        $dh=(array)$request->input('docs.href',[]);
        if(empty($dlEn)&&empty($dlId)) $dlEn=(array)$request->input('docs.label',[]); if(empty($dmEn)&&empty($dmId)) $dmEn=(array)$request->input('docs.meta',[]);
        $docs=[]; for($i=0;$i<max(count($dlEn),count($dlId));$i++){ $l=$combine(trim($dlEn[$i]??''), trim($dlId[$i]??'')) ?? trim($dlEn[$i]??$dlId[$i]??''); if($l!=='') $docs[]=['label'=>$l,'meta'=>($combine(trim($dmEn[$i]??''), trim($dmId[$i]??'')) ?? trim($dmEn[$i]??$dmId[$i]??'')), 'href'=>trim($dh[$i]??'')]; }
        if(!empty($docs)) $out['docs']=$docs; else if($request->has('docs')) $out['docs']=[] ;

        $uhEn=(array)($request->input('usecases.h_en') ?? $request->input('usecases.h') ?? []); $uhId=(array)($request->input('usecases.h_id') ?? []);
        $upEn=(array)($request->input('usecases.p_en') ?? $request->input('usecases.p') ?? []); $upId=(array)($request->input('usecases.p_id') ?? []);
        if(empty($uhEn)&&empty($uhId)) $uhEn=(array)$request->input('usecases.h',[]); if(empty($upEn)&&empty($upId)) $upEn=(array)$request->input('usecases.p',[]);
        $uses=[]; for($i=0;$i<max(count($uhEn),count($uhId));$i++){ $h=$combine(trim($uhEn[$i]??''), trim($uhId[$i]??'')) ?? trim($uhEn[$i]??$uhId[$i]??''); $p=$combine(trim($upEn[$i]??''), trim($upId[$i]??'')) ?? trim($upEn[$i]??$upId[$i]??''); if($h!=='') $uses[]=['h'=>$h,'p'=>$p]; }
        if(!empty($uses)) $out['usecases']=$uses; else if($request->has('usecases')) $out['usecases']=[] ;

        $crEn=(array)($request->input('credits.role_en') ?? $request->input('credits.role') ?? []); $crId=(array)($request->input('credits.role_id') ?? []);
        $cn=(array)$request->input('credits.name',[]);
        if(empty($crEn)&&empty($crId)) $crEn=(array)$request->input('credits.role',[]);
        $creds=[]; for($i=0;$i<max(count($crEn),count($crId),count($cn));$i++){ $r=$combine(trim($crEn[$i]??''), trim($crId[$i]??'')) ?? trim($crEn[$i]??$crId[$i]??''); $n=trim($cn[$i]??''); if($r!==''||$n!=='') $creds[]=['role'=>$r,'name'=>$n]; }
        if(!empty($creds)) $out['credits']=$creds; else if($request->has('credits')) $out['credits']=[] ;

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

        // gallery uploads: name gallery_file[] in form
        $files = $request->file('gallery_file') ?? $request->file('gallery_files') ?? [];
        if (!empty($files)) {
            $files = is_array($files) ? $files : [$files];
            $files = array_filter($files, fn($f)=> $f && $f->isValid());
            if (!empty($files)) {
                $galDir = $imgDir.'/gallery';
                if (! is_dir($galDir)) { @mkdir($galDir, 0775, true); @chmod($galDir,0775); }
                $gallery = $project->gallery ?? [];
                foreach ($files as $idx=>$file) {
                    $ext=strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'webp');
                    $filename='gal-'.time().'-'.$idx.'.'.$ext;
                    try { $file->move($galDir,$filename); } catch (\Throwable $e) {
                        $file->storeAs('projects/'.$project->id.'/gallery',$filename,'public');
                        @copy(storage_path('app/public/projects/'.$project->id.'/gallery/'.$filename), $galDir.'/'.$filename);
                    }
                    @chmod($galDir.'/'.$filename,0664);
                    // append new gallery item with src
                    $gallery[]=['kind'=>'','cap'=>'','src'=>'projects/'.$project->id.'/gallery/'.$filename];
                }
                $project->update(['gallery'=>$gallery]);
            }
        }
    }
}
