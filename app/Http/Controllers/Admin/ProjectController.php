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

        return redirect()->route('admin.portfolio.projects.index')->with('success', 'Project berhasil dibuat!');
    }

    public function edit(Project $project)
    {
        $categories = ['design' => 'Design', 'production' => 'Production', 'event' => 'Events', 'merch' => 'Merch'];

        return view('admin.portfolio.projects.edit', compact('project', 'categories'));
    }

    public function update(Request $request, Project $project)
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

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.portfolio.projects.index')->with('success', 'Project berhasil dihapus!');
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
        $out = [];
        // tags: JS sends JSON string in tags[0] or plain tags[]
        $tags = $request->input('tags', []);
        if (is_array($tags) && count($tags) === 1 && is_string($tags[0]) && str_starts_with(trim($tags[0]), '[')) {
            $dec = json_decode($tags[0], true);
            if (json_last_error() === 0 && is_array($dec)) $tags = $dec;
        }
        $tags = array_values(array_filter(array_map(fn($t) => is_string($t) ? trim($t) : '', (array) $tags)));
        if (!empty($tags)) $out['tags'] = $tags;

        $about = array_values(array_filter(array_map('trim', (array) $request->input('about', []))));
        if (!empty($about)) $out['about'] = $about;

        $sh = (array) $request->input('steps.h', []); $sp = (array) $request->input('steps.p', []);
        $steps = []; for ($i=0; $i<max(count($sh),count($sp)); $i++) { $h=trim($sh[$i]??''); $p=trim($sp[$i]??''); if($h!==''||$p!=='') $steps[]=['h'=>$h,'p'=>$p]; }
        if (!empty($steps)) $out['steps']=$steps;

        $sn=(array)$request->input('stats.n',[]); $ss=(array)$request->input('stats.suffix',[]); $sl=(array)$request->input('stats.l',[]);
        $stats=[]; for($i=0;$i<max(count($sn),count($ss),count($sl));$i++){ $n=trim($sn[$i]??''); $l=trim($sl[$i]??''); if($n!==''||$l!=='') $stats[]=['n'=>$n,'suffix'=>trim($ss[$i]??''),'l'=>$l]; }
        if(!empty($stats)) $out['stats']=$stats; else if($request->has('stats')) $out['stats']=null;

        $gk=(array)$request->input('gallery.kind',[]); $gc=(array)$request->input('gallery.cap',[]); $gt=(array)$request->input('gallery.type',[]); $gv=(array)$request->input('gallery.video_url',[]);
        $gallery=[]; for($i=0;$i<max(count($gk),count($gc),count($gt));$i++){ $k=trim($gk[$i]??''); $c=trim($gc[$i]??''); $t=$gt[$i]??'art'; if($k!==''||$c!==''||$t!=='art') $gallery[]=['kind'=>$k,'cap'=>$c,'type'=>$t,'video'=>$t==='video_url'?trim($gv[$i]??''):null]; }
        // keep existing src if editing and no new gallery data
        if(!empty($gallery)) $out['gallery']=$gallery; else if($request->has('gallery')) $out['gallery']=[] ;

        $dl=(array)$request->input('docs.label',[]); $dm=(array)$request->input('docs.meta',[]); $dh=(array)$request->input('docs.href',[]);
        $docs=[]; for($i=0;$i<max(count($dl),count($dm),count($dh));$i++){ $l=trim($dl[$i]??''); if($l!=='') $docs[]=['label'=>$l,'meta'=>trim($dm[$i]??''),'href'=>trim($dh[$i]??'')]; }
        if(!empty($docs)) $out['docs']=$docs; else if($request->has('docs')) $out['docs']=[] ;

        $uh=(array)$request->input('usecases.h',[]); $up=(array)$request->input('usecases.p',[]);
        $uses=[]; for($i=0;$i<max(count($uh),count($up));$i++){ $h=trim($uh[$i]??''); if($h!=='') $uses[]=['h'=>$h,'p'=>trim($up[$i]??'')]; }
        if(!empty($uses)) $out['usecases']=$uses; else if($request->has('usecases')) $out['usecases']=[] ;

        $cr=(array)$request->input('credits.role',[]); $cn=(array)$request->input('credits.name',[]);
        $creds=[]; for($i=0;$i<max(count($cr),count($cn));$i++){ $r=trim($cr[$i]??''); $n=trim($cn[$i]??''); if($r!==''||$n!=='') $creds[]=['role'=>$r,'name'=>$n]; }
        if(!empty($creds)) $out['credits']=$creds; else if($request->has('credits')) $out['credits']=[] ;

        if($request->input('result_text')!==null) $out['result']=trim((string)$request->input('result_text')) ?: null;
        return $out;
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
