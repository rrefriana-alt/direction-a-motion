<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\CareerController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\UserController;
use App\Models\Project;
use App\Models\ServiceCategory;
use App\Models\Setting;
use App\Models\Message;
use App\Models\Career;
use App\Models\News;

// Make $content available to all frontend views
View::composer('*', function ($view) {
    if (!str_starts_with($view->getName(), 'admin.')) {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $content = [
            'home' => [
                'hero' => [
                    'tagline' => $settings['home_hero_tagline'] ?? 'Creative group · Est. 2016 · Bandung / Jakarta / Bali',
                    'title' => $settings['home_hero_title'] ?? "Create\nto\nElevate",
                    'description' => $settings['home_hero_desc'] ?? 'Design · Production House · Events · Merch. An Indonesian creative group since 2016.'
                ],
                'section_01' => [
                    'subtitle' => $settings['home_s1_subtitle'] ?? 'MANIFESTO',
                    'title' => $settings['home_s1_title'] ?? 'Every brief can be solved with *creativity, an *innovative route, and execution that actually lands.'
                ],
                'section_02' => ['title' => $settings['home_s2_title'] ?? 'We are not just thinkers. We are makers.'],
                'section_03' => ['title' => $settings['home_s3_title'] ?? 'Selected Works'],
                'section_04' => ['title' => $settings['home_s4_title'] ?? 'Trusted by industry leaders'],
                'section_05' => ['title' => $settings['home_s5_title'] ?? 'News & Insights'],
                'section_06' => [
                    'title' => $settings['home_s6_title'] ?? 'Ready to elevate your brand?',
                    'quote' => $settings['home_s6_quote'] ?? 'The best work happens when brave clients meet a relentless creative team.'
                ]
            ],
            'about' => [
                'founder' => [
                    'name' => $settings['about_founder_name'] ?? 'Sona Lesmana',
                    'title' => $settings['about_founder_title'] ?? 'Founder & CEO',
                    'quote' => $settings['about_founder_quote'] ?? 'Creativity without execution is just a hallucination.',
                    'photo' => $settings['about_founder_photo'] ?? ''
                ]
            ],
            'contact' => [
                'email' => $settings['contact_email'] ?? 'hello@fugocreativegroup.com',
                'phone' => $settings['contact_phone'] ?? '+62 821 2100 0680',
                'instagram' => $settings['contact_instagram'] ?? '',
                'linkedin' => $settings['contact_linkedin'] ?? '',
                'address_bdg' => $settings['contact_address_bdg'] ?? 'Jl. Permata Taman Sari Raya No.21, Bandung'
            ]
        ];
        $view->with('content', $content);
    }
});

// Frontend
Route::get('/', function () { return view('index'); })->name('home');
Route::get('/work', function () {
    $projects = Project::latest()->get();
    return view('work', compact('projects'));
})->name('work');
Route::get('/services', function () {
    $categories = ServiceCategory::with('items')->get();
    return view('services', compact('categories'));
})->name('services');
Route::get('/about', function () { return view('about'); })->name('about');
Route::get('/contact', function () { return view('contact'); })->name('contact');
Route::get('/case-study/{id}', function ($id) {
    $project = Project::findOrFail($id);
    return view('case-study', compact('project'));
})->name('case-study');

// Contact form submission
Route::post('/contact', function (Illuminate\Http\Request $request) {
    $request->validate(['name'=>'required','email'=>'required|email','subject'=>'required','message'=>'required']);
    Message::create($request->only(['name','email','subject','message']));
    return back()->with('success', 'Your message has been sent!');
})->name('contact.send');


// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard', [
            'projects_count' => Project::count(),
            'services_count' => ServiceCategory::count(),
            'messages_count' => Message::where('is_read', false)->count(),
            'careers_count' => Career::where('is_open', true)->count(),
            'news_count' => News::count(),
        ]);
    })->name('dashboard');

    // Website Text (Settings)
    Route::get('/content', [ContentController::class, 'index'])->name('content');
    Route::post('/content', [ContentController::class, 'update'])->name('content.update');

    // CRUD Resources
    Route::resource('projects', ProjectController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('careers', CareerController::class)->except(['show','create','edit']);
    Route::resource('news', NewsController::class);
    Route::resource('messages', MessageController::class)->only(['index','show','destroy']);
    Route::resource('users', UserController::class);

    // Career application extra routes
    Route::put('/career-applications/{application}', [CareerController::class, 'updateApplication'])->name('careers.update-application');
    Route::delete('/career-applications/{application}', [CareerController::class, 'destroyApplication'])->name('careers.destroy-application');
});
