<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\CareerController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\CapabilitiesController;
use App\Http\Controllers\Admin\ClientLogosController;
use App\Http\Controllers\Admin\MarqueeController;

// ==================== FRONTEND ====================
Route::get('/', function () {
    $capabilities = \App\Models\Capability::where('is_active', true)->orderBy('sort_order')->get();
    $works = \App\Support\Works::homepage();
    $categories = \App\Models\ServiceCategory::with('details.items')->take(5)->get();
    $clientLogos = \App\Models\ClientLogo::where('is_active', true)->orderBy('sort_order')->get();
    $marqueeItems = \App\Models\MarqueeItem::where('is_active', true)->orderBy('sort_order')->get();
    $stats = \App\Models\Stat::where('is_active', true)->orderBy('sort_order')->get();
    $sectors = \App\Models\Sector::with('items')->where('is_active', true)->orderBy('sort_order')->get();
    $processSteps = \App\Models\ProcessStep::where('is_active', true)->orderBy('sort_order')->get();
    $processEyebrow = \App\Models\Setting::get('home_process_eyebrow_en', '05 � How we work');
    $processTitleEn = \App\Models\Setting::get('home_process_title_en', 'A short line<br>to remarkable');
    $processTitleId = \App\Models\Setting::get('home_process_title_id', 'Garis pendek<br>menuju luar biasa');

    // Section settings
    $heroTagline = \App\Models\Setting::get('home_hero_tagline', '65+ brands trusted us');
    $heroDescription = \App\Models\Setting::get('home_hero_description', 'Design � Production House � Events � Merch. An Indonesian creative group since 2016.');
    $manifestoSubtitle = \App\Models\Setting::get('home_manifesto_subtitle', 'MANIFESTO');
    $manifestoTitle = \App\Models\Setting::get('home_manifesto_title', 'Every brief can be solved with *creativity, an *innovative route, and execution that actually lands.');
    $founderQuote = \App\Models\Setting::get('home_founder_quote', 'Creativity without execution is just a hallucination.');
    $founderName = \App\Models\Setting::get('home_founder_name', 'Sona Lesmana');
    $founderTitle = \App\Models\Setting::get('home_founder_title', 'Founder & CEO');
    $ctaEyebrow = \App\Models\Setting::get('home_cta_eyebrow', 'Available for Q4 2026 projects');
    $ctaTitle = \App\Models\Setting::get('home_cta_title', "Let's build<br>something");

    return view('index', compact(
        'capabilities', 'works', 'categories', 'clientLogos', 'marqueeItems', 'stats', 'sectors',
        'processSteps', 'processEyebrow', 'processTitleEn', 'processTitleId',
        'heroTagline', 'heroDescription', 'manifestoSubtitle', 'manifestoTitle',
        'founderQuote', 'founderName', 'founderTitle', 'ctaEyebrow', 'ctaTitle'
    ));
})->name('home');

Route::get('/work', function () {
    $works = \App\Support\Works::all();
    $workTitle = \App\Models\Setting::get('work_page_title', 'Selected work');
    $workLede = \App\Models\Setting::get('work_page_lede', 'Ten projects that show the range: a national TVC, a dealer system used in 200+ locations, a three-day expo, and 12,000 kits shipped on time.');
    return view('work', compact('works', 'workTitle', 'workLede'));
})->name('work');

Route::get('/services', function () {
    $categories = \App\Models\ServiceCategory::where('is_active', true)
        ->with(['details' => function ($q) {
            $q->where('is_active', true)->orderBy('sort_order');
            $q->with(['items' => function ($q2) {
                $q2->where('is_active', true)->orderBy('sort_order');
            }]);
        }])
        ->orderBy('sort_order')
        ->get();
    $engagements = \App\Models\EngagementModel::where('is_active', true)->orderBy('sort_order')->get();
    return view('services', compact('categories', 'engagements'));
})->name('services');

Route::get('/about', function () {
    $timelines = \App\Models\Timeline::where('is_active', true)->orderBy('sort_order')->get();
    $ceoProfile = \App\Models\CeoProfile::first();
    $statistics = \App\Models\Stat::where('is_active', true)->orderBy('sort_order')->get();
    $content = [
        'about' => [
            'founder' => [
                'quote'  => $ceoProfile->quote ?? \App\Models\Setting::get('about_founder_quote', 'Creativity without execution is just a hallucination.'),
                'name'   => $ceoProfile->name ?? \App\Models\Setting::get('about_founder_name', 'Sona Lesmana'),
                'title'  => $ceoProfile->position ?? \App\Models\Setting::get('about_founder_title', 'Founder & CEO'),
                'image'  => $ceoProfile->photo ?? \App\Models\Setting::get('about_founder_image', ''),
            ],
        ],
    ];
    return view('about', compact('content', 'timelines', 'ceoProfile', 'statistics'));
})->name('about');
Route::get('/contact', function () {
    $contactPhone = \App\Models\Setting::get('contact_phone', '+62 821 2100 0680');
    $contactEmail = \App\Models\Setting::get('contact_email', 'hello@fugocreativegroup.com');
    $contactHeadline = \App\Models\Setting::get('contact_page_headline', 'Tell us what you need to land');
    $contactSubtitle = \App\Models\Setting::get('contact_page_subtitle', 'A short brief is enough to start. We reply within one working day with questions, a route and a rough number � before any meeting.');
    $contactAddressBdg = \App\Models\Setting::get('contact_address_bdg', 'Jl. Permata Taman Sari Raya No.21, Arcamanik, Bandung');
    $contactAddressJkt = \App\Models\Setting::get('contact_address_jkt', 'Jl. Srengseng Sawah No.16, Jagakarsa, Jakarta Selatan');
    $contactAddressBali = \App\Models\Setting::get('contact_address_bali', 'Jl. Tukad Melangit, Samplangan, Gianyar, Bali');
    return view('contact', compact('contactPhone', 'contactEmail', 'contactHeadline', 'contactSubtitle', 'contactAddressBdg', 'contactAddressJkt', 'contactAddressBali'));
})->name('contact');

Route::get('/case-study', fn() => view('case-study'))->name('case-study.static');
Route::get('/case-study/project/{id}', function ($id) {
    $project = \App\Models\Project::findOrFail($id);
    return view('case-study', compact('project'));
})->name('case-study');

Route::post('/contact', function (Illuminate\Http\Request $request) {
    $request->validate(['name' => 'required', 'email' => 'required|email', 'message' => 'required']);
    \App\Models\Message::create($request->only(['name', 'email', 'message']) + ['subject' => 'Contact Form']);
    return back()->with('success', 'Your message has been sent!');
})->name('contact.send');

// ==================== AUTH ====================
Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

// ==================== ADMIN ====================
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ==================== HOME MODULE ====================
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Hero
    Route::get('/home/hero', [HomeController::class, 'heroEdit'])->name('home.hero.edit');
    Route::put('/home/hero', [HomeController::class, 'heroUpdate'])->name('home.hero.update');

    // Manifesto
    Route::get('/home/manifesto', [HomeController::class, 'manifestoEdit'])->name('home.manifesto.edit');
    Route::put('/home/manifesto', [HomeController::class, 'manifestoUpdate'])->name('home.manifesto.update');

    // Statistics
    Route::get('/home/stats', [HomeController::class, 'statsIndex'])->name('home.stats.index');
    Route::get('/home/stats/create', [HomeController::class, 'statsCreate'])->name('home.stats.create');
    Route::post('/home/stats', [HomeController::class, 'statsStore'])->name('home.stats.store');
    Route::get('/home/stats/{id}/edit', [HomeController::class, 'statsEdit'])->name('home.stats.edit');
    Route::put('/home/stats/{id}', [HomeController::class, 'statsUpdate'])->name('home.stats.update');
    Route::delete('/home/stats/{id}', [HomeController::class, 'statsDestroy'])->name('home.stats.destroy');

    // Sectors
    Route::get('/home/sectors', [HomeController::class, 'sectorsIndex'])->name('home.sectors.index');
    Route::get('/home/sectors/create', [HomeController::class, 'sectorsCreate'])->name('home.sectors.create');
    Route::post('/home/sectors', [HomeController::class, 'sectorsStore'])->name('home.sectors.store');
    Route::get('/home/sectors/{id}/edit', [HomeController::class, 'sectorsEdit'])->name('home.sectors.edit');
    Route::put('/home/sectors/{id}', [HomeController::class, 'sectorsUpdate'])->name('home.sectors.update');
    Route::delete('/home/sectors/{id}', [HomeController::class, 'sectorsDestroy'])->name('home.sectors.destroy');

    // Process Header
    Route::get('/home/process-header', [HomeController::class, 'processHeaderEdit'])->name('home.process-header.edit');
    Route::put('/home/process-header', [HomeController::class, 'processHeaderUpdate'])->name('home.process-header.update');

    // Process
    Route::get('/home/process', [HomeController::class, 'processIndex'])->name('home.process.index');
    Route::get('/home/process/create', [HomeController::class, 'processCreate'])->name('home.process.create');
    Route::post('/home/process', [HomeController::class, 'processStore'])->name('home.process.store');
    Route::get('/home/process/{id}/edit', [HomeController::class, 'processEdit'])->name('home.process.edit');
    Route::put('/home/process/{id}', [HomeController::class, 'processUpdate'])->name('home.process.update');
    Route::delete('/home/process/{id}', [HomeController::class, 'processDestroy'])->name('home.process.destroy');

    // Founder Quote
    Route::get('/home/founder', [HomeController::class, 'founderEdit'])->name('home.founder.edit');
    Route::put('/home/founder', [HomeController::class, 'founderUpdate'])->name('home.founder.update');

    // CTA
    Route::get('/home/cta', [HomeController::class, 'ctaEdit'])->name('home.cta.edit');
    Route::put('/home/cta', [HomeController::class, 'ctaUpdate'])->name('home.cta.update');

    // Services Page Header
    Route::get('/home/services-page', [HomeController::class, 'servicesPageEdit'])->name('home.services-page.edit');
    Route::put('/home/services-page', [HomeController::class, 'servicesPageUpdate'])->name('home.services-page.update');

    // Footer
    Route::get('/home/footer', [HomeController::class, 'footerEdit'])->name('home.footer.edit');
    Route::put('/home/footer', [HomeController::class, 'footerUpdate'])->name('home.footer.update');

    // Contact Page Settings (under home for convenience)
    Route::get('/home/contact-page', [HomeController::class, 'contactPageEdit'])->name('contact.settings.edit');
    Route::put('/home/contact-page', [HomeController::class, 'contactPageUpdate'])->name('contact.settings.update');

    // Capabilities (02-Capabilities section)
    Route::get('/home/capabilities', [CapabilitiesController::class, 'index'])->name('home.capabilities.index');
    Route::get('/home/capabilities/create', [CapabilitiesController::class, 'create'])->name('home.capabilities.create');
    Route::post('/home/capabilities', [CapabilitiesController::class, 'store'])->name('home.capabilities.store');
    Route::get('/home/capabilities/{capability}/edit', [CapabilitiesController::class, 'edit'])->name('home.capabilities.edit');
    Route::put('/home/capabilities/{capability}', [CapabilitiesController::class, 'update'])->name('home.capabilities.update');
    Route::delete('/home/capabilities/{capability}', [CapabilitiesController::class, 'destroy'])->name('home.capabilities.destroy');

    // Capabilities Header (title + description)
    Route::get('/home/capabilities-header', [HomeController::class, 'capabilitiesHeaderEdit'])->name('home.capabilities-header.edit');
    Route::put('/home/capabilities-header', [HomeController::class, 'capabilitiesHeaderUpdate'])->name('home.capabilities-header.update');

    // Client Logos (ticker carousel)
    Route::get('/home/clients', [ClientLogosController::class, 'index'])->name('home.clients.index');
    Route::get('/home/clients/create', [ClientLogosController::class, 'create'])->name('home.clients.create');
    Route::post('/home/clients', [ClientLogosController::class, 'store'])->name('home.clients.store');
    Route::get('/home/clients/{clientLogo}/edit', [ClientLogosController::class, 'edit'])->name('home.clients.edit');
    Route::put('/home/clients/{clientLogo}', [ClientLogosController::class, 'update'])->name('home.clients.update');
    Route::delete('/home/clients/{clientLogo}', [ClientLogosController::class, 'destroy'])->name('home.clients.destroy');

    // Carousel Management
    Route::get('/home/clients/carousel', [ClientLogosController::class, 'carousel'])->name('home.clients.carousel');
    Route::post('/home/clients/carousel', [ClientLogosController::class, 'carouselUpdate'])->name('home.clients.carousel.update');

    // Big Marquee
    Route::get('/home/marquee', [MarqueeController::class, 'index'])->name('home.marquee.index');
    Route::get('/home/marquee/create', [MarqueeController::class, 'create'])->name('home.marquee.create');
    Route::post('/home/marquee', [MarqueeController::class, 'store'])->name('home.marquee.store');
    Route::get('/home/marquee/{marqueeItem}/edit', [MarqueeController::class, 'edit'])->name('home.marquee.edit');
    Route::put('/home/marquee/{marqueeItem}', [MarqueeController::class, 'update'])->name('home.marquee.update');
    Route::delete('/home/marquee/{marqueeItem}', [MarqueeController::class, 'destroy'])->name('home.marquee.destroy');

    // ==================== PORTFOLIO MODULE ====================
    Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
    Route::get('/portfolio/view-all', [PortfolioController::class, 'viewAll'])->name('portfolio.view-all');
    Route::post('/portfolio/view-all/update', [PortfolioController::class, 'updateViewAll'])->name('portfolio.view-all.update');

    // Portfolio Projects
    Route::get('/portfolio/projects', [ProjectController::class, 'index'])->name('portfolio.projects.index');
    Route::get('/portfolio/projects/create', [ProjectController::class, 'create'])->name('portfolio.projects.create');
    Route::post('/portfolio/projects', [ProjectController::class, 'store'])->name('portfolio.projects.store');
    Route::get('/portfolio/projects/{project}/edit', [ProjectController::class, 'edit'])->name('portfolio.projects.edit');
    Route::put('/portfolio/projects/{project}', [ProjectController::class, 'update'])->name('portfolio.projects.update');
    Route::delete('/portfolio/projects/{project}', [ProjectController::class, 'destroy'])->name('portfolio.projects.destroy');
    Route::post('/portfolio/projects/update-sort', [ProjectController::class, 'updateSortOrder'])->name('portfolio.projects.update-sort');

    // Work Page Settings
    Route::get('/work-settings', [\App\Http\Controllers\Admin\WorkSettingsController::class, 'edit'])->name('work-settings.edit');
    Route::put('/work-settings', [\App\Http\Controllers\Admin\WorkSettingsController::class, 'update'])->name('work-settings.update');

    // ==================== ABOUT MODULE ====================
    Route::prefix('about')->name('about.')->group(function() {
        Route::get('/', [AboutController::class, 'index'])->name('index');
        Route::get('/settings', [AboutController::class, 'aboutHeaderEdit'])->name('settings.edit');
        Route::put('/settings', [AboutController::class, 'aboutHeaderUpdate'])->name('settings.update');
        Route::get('/ceo-profile', [AboutController::class, 'ceoProfile'])->name('ceo-profile');
        Route::put('/ceo-profile', [AboutController::class, 'updateCeoProfile'])->name('ceo-profile.update');
        Route::get('/timeline', [AboutController::class, 'timelineIndex'])->name('timeline.index');
        Route::get('/timeline/create', [AboutController::class, 'timelineCreate'])->name('timeline.create');
        Route::post('/timeline', [AboutController::class, 'timelineStore'])->name('timeline.store');
        Route::get('/timeline/{timeline}/edit', [AboutController::class, 'timelineEdit'])->name('timeline.edit');
        Route::put('/timeline/{timeline}', [AboutController::class, 'timelineUpdate'])->name('timeline.update');
        Route::delete('/timeline/{timeline}', [AboutController::class, 'timelineDestroy'])->name('timeline.destroy');

        // ==================== STATISTICS MODULE ====================
        Route::get('/statistics', [AboutController::class, 'statisticsIndex'])->name('statistics.index');
        Route::get('/statistics/create', [AboutController::class, 'statisticsCreate'])->name('statistics.create');
        Route::post('/statistics', [AboutController::class, 'statisticsStore'])->name('statistics.store');
        Route::get('/statistics/{stat}/edit', [AboutController::class, 'statisticsEdit'])->name('statistics.edit');
        Route::put('/statistics/{stat}', [AboutController::class, 'statisticsUpdate'])->name('statistics.update');
        Route::delete('/statistics/{stat}', [AboutController::class, 'statisticsDestroy'])->name('statistics.destroy');
        Route::post('/statistics/reorder', [AboutController::class, 'statisticsReorder'])->name('statistics.reorder');
        Route::post('/statistics/{stat}/toggle', [AboutController::class, 'statisticsToggle'])->name('statistics.toggle');

        // ==================== SECTORS MODULE ====================
        Route::get('/sectors', [AboutController::class, 'sectorIndex'])->name('sectors.index');
        Route::get('/sectors/create', [AboutController::class, 'sectorCreate'])->name('sectors.create');
        Route::post('/sectors', [AboutController::class, 'sectorStore'])->name('sectors.store');
        Route::get('/sectors/{sector}/edit', [AboutController::class, 'sectorEdit'])->name('sectors.edit');
        Route::put('/sectors/{sector}', [AboutController::class, 'sectorUpdate'])->name('sectors.update');
        Route::delete('/sectors/{sector}', [AboutController::class, 'sectorDestroy'])->name('sectors.destroy');
        Route::post('/sectors/reorder', [AboutController::class, 'sectorReorder'])->name('sectors.reorder');
        Route::post('/sectors/{sector}/toggle', [AboutController::class, 'sectorToggle'])->name('sectors.toggle');
    });

    // ==================== SERVICES MODULE ====================
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/crud', [ServiceController::class, 'crud'])->name('services.crud');
    Route::post('/services/categories', [ServiceController::class, 'storeCategory'])->name('services.categories.store');
    Route::put('/services/categories/{id}', [ServiceController::class, 'updateCategory'])->name('services.categories.update');
    Route::delete('/services/categories/{id}', [ServiceController::class, 'destroyCategory'])->name('services.categories.destroy');
    Route::post('/services/details', [ServiceController::class, 'storeDetail'])->name('services.details.store');
    Route::put('/services/details/{id}', [ServiceController::class, 'updateDetail'])->name('services.details.update');
    Route::delete('/services/details/{id}', [ServiceController::class, 'destroyDetail'])->name('services.details.destroy');
    Route::post('/services/items', [ServiceController::class, 'storeItem'])->name('services.items.store');
    Route::put('/services/items/{id}', [ServiceController::class, 'updateItem'])->name('services.items.update');
    Route::delete('/services/items/{id}', [ServiceController::class, 'destroyItem'])->name('services.items.destroy');
    // Reorder & Move
    Route::post('/services/details/{id}/reorder', [ServiceController::class, 'reorderDetail'])->name('services.details.reorder');
    Route::post('/services/items/{id}/reorder', [ServiceController::class, 'reorderItem'])->name('services.items.reorder');
    Route::post('/services/items/{id}/move', [ServiceController::class, 'moveItem'])->name('services.items.move');

    // Engagement Models
    Route::get('/services/engagement', [ServiceController::class, 'engagementIndex'])->name('services.engagement.index');
    Route::get('/services/engagement/create', [ServiceController::class, 'engagementCreate'])->name('services.engagement.create');
    Route::post('/services/engagement', [ServiceController::class, 'engagementStore'])->name('services.engagement.store');
    Route::get('/services/engagement/{id}/edit', [ServiceController::class, 'engagementEdit'])->name('services.engagement.edit');
    Route::put('/services/engagement/{id}', [ServiceController::class, 'engagementUpdate'])->name('services.engagement.update');
    Route::delete('/services/engagement/{id}', [ServiceController::class, 'engagementDestroy'])->name('services.engagement.destroy');
    Route::post('/services/engagement/{id}/toggle-active', [ServiceController::class, 'engagementToggleActive'])->name('services.engagement.toggle');

    // ==================== NEWS MODULE ====================
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/news/list', [NewsController::class, 'list'])->name('news.list');
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/news', [NewsController::class, 'store'])->name('news.store');
    Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');
    Route::get('/news/{id}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::put('/news/{id}', [NewsController::class, 'update'])->name('news.update');
    Route::delete('/news/{id}', [NewsController::class, 'destroy'])->name('news.destroy');

    // ==================== CAREER MODULE ====================
    Route::get('/career', [CareerController::class, 'index'])->name('career.index');

    // Applications
    Route::get('/career/applications', [CareerController::class, 'applicationsIndex'])->name('career.applications.index');
    Route::get('/career/applications/export', [CareerController::class, 'exportApplications'])->name('career.applications.export');
    Route::get('/career/applications/{id}/edit', [CareerController::class, 'editApplication'])->name('career.applications.edit');
    Route::post('/career/applications/{id}/status', [CareerController::class, 'updateApplicationStatus'])->name('career.applications.update-status');
    Route::get('/career/applications/{id}/download-resume', [CareerController::class, 'downloadResume'])->name('career.applications.download-resume');
    Route::get('/career/applications/{id}/download-portfolio', [CareerController::class, 'downloadPortfolio'])->name('career.applications.download-portfolio');

    // Positions
    Route::get('/career/positions', [CareerController::class, 'positionsIndex'])->name('career.positions.index');
    Route::get('/career/positions/create', [CareerController::class, 'positionsCreate'])->name('career.positions.create');
    Route::post('/career/positions', [CareerController::class, 'positionsStore'])->name('career.positions.store');
    Route::get('/career/positions/{id}/edit', [CareerController::class, 'positionsEdit'])->name('career.positions.edit');
    Route::post('/career/positions/{id}', [CareerController::class, 'positionsUpdate'])->name('career.positions.update');
    Route::delete('/career/positions/{id}', [CareerController::class, 'positionsDestroy'])->name('career.positions.destroy');
    Route::post('/career/positions/{id}/toggle-active', [CareerController::class, 'positionsToggleActive'])->name('career.positions.toggle-active');
    Route::post('/career/positions/{id}/toggle-open', [CareerController::class, 'positionsToggleOpen'])->name('career.positions.toggle-open');
    Route::post('/career/positions/update-sort', [CareerController::class, 'positionsUpdateSort'])->name('career.positions.update-sort');

    // Hero & Benefits
    Route::get('/career/hero-benefits', [CareerController::class, 'heroBenefitsIndex'])->name('career.hero-benefits.index');
    Route::get('/career/hero-benefits/hero', [CareerController::class, 'heroEdit'])->name('career.hero-benefits.hero.edit');
    Route::put('/career/hero-benefits/hero', [CareerController::class, 'heroUpdate'])->name('career.hero-benefits.hero.update');
    Route::get('/career/hero-benefits/benefits/create', [CareerController::class, 'benefitsCreate'])->name('career.hero-benefits.benefits.create');
    Route::post('/career/hero-benefits/benefits', [CareerController::class, 'benefitsStore'])->name('career.hero-benefits.benefits.store');
    Route::get('/career/hero-benefits/benefits/{id}/edit', [CareerController::class, 'benefitsEdit'])->name('career.hero-benefits.benefits.edit');
    Route::put('/career/hero-benefits/benefits/{id}', [CareerController::class, 'benefitsUpdate'])->name('career.hero-benefits.benefits.update');
    Route::delete('/career/hero-benefits/benefits/{id}', [CareerController::class, 'benefitsDestroy'])->name('career.hero-benefits.benefits.destroy');
    Route::post('/career/hero-benefits/benefits/{id}/toggle-active', [CareerController::class, 'benefitsToggleActive'])->name('career.hero-benefits.benefits.toggle-active');
    Route::post('/career/hero-benefits/benefits/update-sort', [CareerController::class, 'benefitsUpdateSort'])->name('career.hero-benefits.benefits.update-sort');

    // ==================== CONTACT MODULE ====================
    Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
    Route::put('/contact/{id}', [ContactController::class, 'update'])->name('contact.update');
    Route::delete('/contact/{id}', [ContactController::class, 'destroy'])->name('contact.destroy');
    Route::post('/contact/{id}/toggle-active', [ContactController::class, 'toggleActive'])->name('contact.toggle-active');

    // Contact Messages Inbox
    Route::get('/contact/messages', [ContactController::class, 'messagesIndex'])->name('contact.messages.index');
    Route::delete('/contact/messages/{message}', [ContactController::class, 'messageDestroy'])->name('contact.messages.destroy');
    Route::post('/contact/messages/{message}/toggle-read', [ContactController::class, 'messageToggleRead'])->name('contact.messages.toggle-read');

    // ==================== ACCOUNT MODULE ====================
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::post('/account', [AccountController::class, 'store'])->name('account.store');
    Route::put('/account/{id}', [AccountController::class, 'update'])->name('account.update');
    Route::delete('/account/{id}', [AccountController::class, 'destroy'])->name('account.destroy');
});
