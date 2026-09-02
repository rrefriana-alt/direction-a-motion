<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\JsonCmsService;

class FrontendController extends Controller
{
    protected $cms;

    public function __construct(JsonCmsService $cms)
    {
        $this->cms = $cms;
    }

    public function index()
    {
        $content = $this->cms->getAll();
        return view('index', compact('content'));
    }

    public function about()
    {
        $content = $this->cms->getAll();
        return view('about', compact('content'));
    }

    public function work()
    {
        $content = $this->cms->getAll();
        return view('work', compact('content'));
    }

    public function services()
    {
        $content = $this->cms->getAll();
        return view('services', compact('content'));
    }

    public function contact()
    {
        $content = $this->cms->getAll();
        return view('contact', compact('content'));
    }

    public function caseStudy($slug = null)
    {
        $content = $this->cms->getAll();
        
        // Find specific project if slug is provided
        $project = null;
        if ($slug) {
            $projects = $this->cms->get('projects', []);
            foreach ($projects as $p) {
                if (isset($p['slug']) && $p['slug'] === $slug) {
                    $project = $p;
                    break;
                }
            }
        }
        
        return view('case-study', compact('content', 'project'));
    }
}
