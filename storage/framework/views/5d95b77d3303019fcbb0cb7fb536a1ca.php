
<?php $__env->startSection('title', 'Page Section Manager'); ?>
<?php $__env->startSection('page-title', 'Page Section Manager'); ?>

<?php $__env->startSection('styles'); ?>
<style>
/* Tab Nav */
.page-tabs { display:flex; gap:.5rem; border-bottom:1px solid var(--border); margin-bottom:1.75rem; padding-bottom:0; }
.page-tab {
    display:flex; align-items:center; gap:.5rem;
    padding:.62rem 1.1rem; border-radius:10px 10px 0 0;
    font-size:.82rem; font-weight:600;
    color:var(--tx-secondary); border:1px solid transparent;
    border-bottom:none; margin-bottom:-1px; cursor:pointer;
    background:none; transition:all .2s;
    text-decoration:none;
}
.page-tab:hover { color:var(--tx-primary); background:var(--bg-card); }
.page-tab.active {
    color:var(--accent); background:var(--bg-card);
    border-color:var(--border) var(--border) var(--bg-card) var(--border);
}
.page-tab i { font-size:.9rem; }

/* Section cards */
.section-card {
    background:var(--bg-card); border:1px solid var(--border);
    border-radius:12px; padding:1.1rem 1.25rem;
    display:flex; align-items:center; gap:1.1rem;
    margin-bottom:.75rem; transition:all .2s;
    cursor:default;
}
.section-card:hover { background:var(--bg-card-hover); border-color:var(--border-hover); }
.section-thumb {
    width:72px; height:52px; border-radius:8px;
    background:rgba(255,255,255,.06); border:1px solid var(--border);
    display:flex; align-items:center; justify-content:center;
    flex-shrink:0; font-size:1.4rem; color:var(--tx-muted);
    overflow:hidden;
}
.section-info { flex:1; min-width:0; }
.section-name { font-size:.87rem; font-weight:700; color:var(--tx-primary); }
.section-desc { font-size:.74rem; color:var(--tx-muted); margin-top:.18rem; }
.section-fields { display:flex; gap:.35rem; flex-wrap:wrap; margin-top:.4rem; }
.section-field-tag {
    font-size:.64rem; padding:.15rem .5rem;
    border-radius:50rem; background:rgba(255,255,255,.05);
    border:1px solid var(--border); color:var(--tx-muted);
}

/* Drawer */
.drawer-overlay {
    position:fixed; inset:0; background:rgba(0,0,0,.65);
    z-index:2000; backdrop-filter:blur(3px);
    display:none;
}
.drawer-overlay.open { display:block; }
.drawer {
    position:fixed; top:0; right:0; bottom:0;
    width:min(540px,95vw);
    background:#0e1e38;
    border-left:1px solid var(--border);
    z-index:2001; display:flex; flex-direction:column;
    box-shadow:-8px 0 48px rgba(0,0,0,.5);
    transform:translateX(100%); transition:transform .3s cubic-bezier(.4,0,.2,1);
}
.drawer.open { transform:translateX(0); }
.drawer-header {
    display:flex; align-items:center; gap:.9rem;
    padding:1.25rem 1.5rem;
    border-bottom:1px solid var(--border);
    flex-shrink:0;
}
.drawer-icon {
    width:38px; height:38px; border-radius:10px;
    display:flex; align-items:center; justify-content:center;
    font-size:1rem; flex-shrink:0;
}
.drawer-title { font-size:.95rem; font-weight:800; color:var(--tx-primary); }
.drawer-subtitle { font-size:.72rem; color:var(--tx-muted); margin-top:.1rem; }
.drawer-close {
    margin-left:auto; width:32px; height:32px; border-radius:8px;
    background:var(--bg-card); border:1px solid var(--border);
    color:var(--tx-secondary); font-size:1rem;
    display:flex; align-items:center; justify-content:center;
    cursor:pointer; transition:all .2s;
}
.drawer-close:hover { background:var(--bg-card-hover); color:var(--tx-primary); }
.drawer-body { flex:1; overflow-y:auto; padding:1.5rem; }
.drawer-footer {
    padding:1rem 1.5rem;
    border-top:1px solid var(--border);
    display:flex; align-items:center; gap:.75rem;
    flex-shrink:0;
    background:#0e1e38;
}
.field-group { margin-bottom:1.25rem; }
.field-label {
    display:flex; align-items:center; justify-content:space-between;
    font-size:.76rem; font-weight:600; color:var(--tx-secondary);
    margin-bottom:.45rem;
}
.field-hint { font-size:.68rem; color:var(--tx-muted); }
.unsaved-indicator {
    display:none; align-items:center; gap:.35rem;
    font-size:.73rem; color:#f59e0b;
}
.unsaved-indicator.show { display:flex; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php
$activePage = request('page', 'home');
$pages = [
    'home'     => ['label'=>'Home Page',     'icon'=>'bi-house-fill',        'color'=>'rgba(61,220,151,.12)',  'tcolor'=>'#3ddc97'],
    'work'     => ['label'=>'Work Page',     'icon'=>'bi-folder2-open',      'color'=>'rgba(59,130,246,.12)',  'tcolor'=>'#3b82f6'],
    'services' => ['label'=>'Services Page', 'icon'=>'bi-layers-fill',       'color'=>'rgba(139,92,246,.12)', 'tcolor'=>'#8b5cf6'],
    'about'    => ['label'=>'About/Studio',  'icon'=>'bi-people-fill',       'color'=>'rgba(245,158,11,.12)', 'tcolor'=>'#f59e0b'],
    'contact'  => ['label'=>'Contact Page',  'icon'=>'bi-envelope-fill',     'color'=>'rgba(239,68,68,.12)',  'tcolor'=>'#ef4444'],
];
?>


<div class="page-tabs">
    <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $pg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <a href="?page=<?php echo e($key); ?>" class="page-tab <?php echo e($activePage===$key ? 'active' : ''); ?>">
        <i class="bi <?php echo e($pg['icon']); ?>"></i> <?php echo e($pg['label']); ?>

    </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>


<div style="display:flex;align-items:center;gap:.85rem;margin-bottom:1.5rem;">
    <div style="width:42px;height:42px;border-radius:11px;background:<?php echo e($pages[$activePage]['color']); ?>;color:<?php echo e($pages[$activePage]['tcolor']); ?>;display:flex;align-items:center;justify-content:center;font-size:1.1rem;">
        <i class="bi <?php echo e($pages[$activePage]['icon']); ?>"></i>
    </div>
    <div>
        <h2 style="font-size:1.1rem;font-weight:800;color:var(--tx-primary);margin:0;"><?php echo e($pages[$activePage]['label']); ?> — Section Manager</h2>
        <p style="font-size:.76rem;color:var(--tx-muted);margin:0;">Click "Edit Section" to open the editor and update content live on your website.</p>
    </div>
</div>


<?php if($activePage === 'home'): ?>

<?php
$homeSections = [
    ['id'=>'hero',        'name'=>'Hero Section',      'desc'=>'Main headline, tagline, and description text', 'icon'=>'bi-stars',           'color'=>'rgba(61,220,151,.12)', 'tcolor'=>'#3ddc97', 'fields'=>['Tagline','Title','Description']],
    ['id'=>'manifesto',   'name'=>'Manifesto',          'desc'=>'Brand manifesto subtitle and main statement', 'icon'=>'bi-chat-quote-fill', 'color'=>'rgba(59,130,246,.12)', 'tcolor'=>'#3b82f6', 'fields'=>['Subtitle','Statement']],
    ['id'=>'services_ov', 'name'=>'Services Overview',  'desc'=>'Section title above the services grid',       'icon'=>'bi-grid-1x2',        'color'=>'rgba(139,92,246,.12)', 'tcolor'=>'#8b5cf6', 'fields'=>['Section Title']],
    ['id'=>'work_ov',     'name'=>'Selected Works',     'desc'=>'Section heading for the portfolio preview',   'icon'=>'bi-collection',      'color'=>'rgba(245,158,11,.12)', 'tcolor'=>'#f59e0b', 'fields'=>['Section Title']],
    ['id'=>'process',     'name'=>'Process / How',      'desc'=>'Section heading for the process steps',       'icon'=>'bi-diagram-3-fill',  'color'=>'rgba(20,184,166,.12)', 'tcolor'=>'#14b8a6', 'fields'=>['Section Title']],
    ['id'=>'news_ov',     'name'=>'News & Insights',    'desc'=>'Section title for the news/blog preview',     'icon'=>'bi-newspaper',       'color'=>'rgba(239,68,68,.12)',  'tcolor'=>'#ef4444', 'fields'=>['Section Title']],
    ['id'=>'cta',         'name'=>'Call to Action',     'desc'=>'Bottom CTA headline, quote, and button',      'icon'=>'bi-megaphone-fill',  'color'=>'rgba(251,146,60,.12)', 'tcolor'=>'#fb923c', 'fields'=>['Headline','Quote']],
];
?>

<?php $__currentLoopData = $homeSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="section-card">
    <div class="section-thumb" style="background:<?php echo e($sec['color']); ?>;color:<?php echo e($sec['tcolor']); ?>;">
        <i class="bi <?php echo e($sec['icon']); ?>" style="font-size:1.6rem;"></i>
    </div>
    <div class="section-info">
        <div class="section-name"><?php echo e($sec['name']); ?></div>
        <div class="section-desc"><?php echo e($sec['desc']); ?></div>
        <div class="section-fields">
            <?php $__currentLoopData = $sec['fields']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <span class="section-field-tag"><?php echo e($f); ?></span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <button class="btn btn-ghost btn-sm" onclick="openDrawer('home_<?php echo e($sec['id']); ?>')" style="flex-shrink:0;">
        <i class="bi bi-pencil-fill" style="font-size:.72rem;"></i> Edit
    </button>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<?php elseif($activePage === 'work'): ?>

<?php
$workSections = [
    ['id'=>'header', 'name'=>'Page Header',        'desc'=>'Main headline and subtitle for the Work page', 'icon'=>'bi-card-heading',  'color'=>'rgba(59,130,246,.12)', 'tcolor'=>'#3b82f6', 'fields'=>['Headline','Subtitle']],
    ['id'=>'filters','name'=>'Filter Labels',      'desc'=>'Category filter button labels',                'icon'=>'bi-funnel-fill',   'color'=>'rgba(61,220,151,.12)', 'tcolor'=>'#3ddc97', 'fields'=>['All','Design','Film','Events','Merch']],
];
?>

<?php $__currentLoopData = $workSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="section-card">
    <div class="section-thumb" style="background:<?php echo e($sec['color']); ?>;color:<?php echo e($sec['tcolor']); ?>;">
        <i class="bi <?php echo e($sec['icon']); ?>" style="font-size:1.6rem;"></i>
    </div>
    <div class="section-info">
        <div class="section-name"><?php echo e($sec['name']); ?></div>
        <div class="section-desc"><?php echo e($sec['desc']); ?></div>
        <div class="section-fields">
            <?php $__currentLoopData = $sec['fields']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><span class="section-field-tag"><?php echo e($f); ?></span><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <button class="btn btn-ghost btn-sm" onclick="openDrawer('work_<?php echo e($sec['id']); ?>')" style="flex-shrink:0;">
        <i class="bi bi-pencil-fill" style="font-size:.72rem;"></i> Edit
    </button>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<?php elseif($activePage === 'services'): ?>

<?php
$servicesSections = [
    ['id'=>'header',   'name'=>'Page Header',        'desc'=>'Headline and subtitle for the Services page',  'icon'=>'bi-card-heading', 'color'=>'rgba(139,92,246,.12)', 'tcolor'=>'#8b5cf6', 'fields'=>['Headline','Subtitle']],
    ['id'=>'intro',    'name'=>'Services Intro',     'desc'=>'Intro paragraph below the page header',        'icon'=>'bi-text-paragraph','color'=>'rgba(61,220,151,.12)', 'tcolor'=>'#3ddc97', 'fields'=>['Body Text']],
];
?>

<?php $__currentLoopData = $servicesSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="section-card">
    <div class="section-thumb" style="background:<?php echo e($sec['color']); ?>;color:<?php echo e($sec['tcolor']); ?>;">
        <i class="bi <?php echo e($sec['icon']); ?>" style="font-size:1.6rem;"></i>
    </div>
    <div class="section-info">
        <div class="section-name"><?php echo e($sec['name']); ?></div>
        <div class="section-desc"><?php echo e($sec['desc']); ?></div>
        <div class="section-fields">
            <?php $__currentLoopData = $sec['fields']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><span class="section-field-tag"><?php echo e($f); ?></span><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <button class="btn btn-ghost btn-sm" onclick="openDrawer('services_<?php echo e($sec['id']); ?>')" style="flex-shrink:0;">
        <i class="bi bi-pencil-fill" style="font-size:.72rem;"></i> Edit
    </button>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<?php elseif($activePage === 'about'): ?>

<?php
$aboutSections = [
    ['id'=>'hero',    'name'=>'Hero / Intro',        'desc'=>'Opening headline and intro paragraph',             'icon'=>'bi-stars',            'color'=>'rgba(245,158,11,.12)', 'tcolor'=>'#f59e0b', 'fields'=>['Headline','Intro']],
    ['id'=>'founder', 'name'=>'Founder Section',     'desc'=>'Founder name, title, and signature quote',         'icon'=>'bi-person-circle',    'color'=>'rgba(61,220,151,.12)', 'tcolor'=>'#3ddc97', 'fields'=>['Name','Title','Quote']],
    ['id'=>'values',  'name'=>'Values / Philosophy', 'desc'=>'Section title for values and belief statements',   'icon'=>'bi-gem',              'color'=>'rgba(139,92,246,.12)', 'tcolor'=>'#8b5cf6', 'fields'=>['Section Title']],
    ['id'=>'stats',   'name'=>'Stats / Numbers',     'desc'=>'Key stats — years, brands, projects, etc.',        'icon'=>'bi-bar-chart-fill',   'color'=>'rgba(59,130,246,.12)', 'tcolor'=>'#3b82f6', 'fields'=>['Stat Labels']],
];
?>

<?php $__currentLoopData = $aboutSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="section-card">
    <div class="section-thumb" style="background:<?php echo e($sec['color']); ?>;color:<?php echo e($sec['tcolor']); ?>;">
        <i class="bi <?php echo e($sec['icon']); ?>" style="font-size:1.6rem;"></i>
    </div>
    <div class="section-info">
        <div class="section-name"><?php echo e($sec['name']); ?></div>
        <div class="section-desc"><?php echo e($sec['desc']); ?></div>
        <div class="section-fields">
            <?php $__currentLoopData = $sec['fields']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><span class="section-field-tag"><?php echo e($f); ?></span><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <button class="btn btn-ghost btn-sm" onclick="openDrawer('about_<?php echo e($sec['id']); ?>')" style="flex-shrink:0;">
        <i class="bi bi-pencil-fill" style="font-size:.72rem;"></i> Edit
    </button>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<?php elseif($activePage === 'contact'): ?>

<?php
$contactSections = [
    ['id'=>'header',  'name'=>'Page Header',     'desc'=>'Headline and opening text for the Contact page',  'icon'=>'bi-card-heading',      'color'=>'rgba(239,68,68,.12)',  'tcolor'=>'#ef4444', 'fields'=>['Headline','Subtitle']],
    ['id'=>'info',    'name'=>'Contact Info',    'desc'=>'Email, phone, and office address details',        'icon'=>'bi-geo-alt-fill',      'color'=>'rgba(61,220,151,.12)', 'tcolor'=>'#3ddc97', 'fields'=>['Email','Phone','Address (Bandung)']],
];
?>

<?php $__currentLoopData = $contactSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="section-card">
    <div class="section-thumb" style="background:<?php echo e($sec['color']); ?>;color:<?php echo e($sec['tcolor']); ?>;">
        <i class="bi <?php echo e($sec['icon']); ?>" style="font-size:1.6rem;"></i>
    </div>
    <div class="section-info">
        <div class="section-name"><?php echo e($sec['name']); ?></div>
        <div class="section-desc"><?php echo e($sec['desc']); ?></div>
        <div class="section-fields">
            <?php $__currentLoopData = $sec['fields']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><span class="section-field-tag"><?php echo e($f); ?></span><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <button class="btn btn-ghost btn-sm" onclick="openDrawer('contact_<?php echo e($sec['id']); ?>')" style="flex-shrink:0;">
        <i class="bi bi-pencil-fill" style="font-size:.72rem;"></i> Edit
    </button>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>


<div class="drawer-overlay" id="drawerOverlay" onclick="closeDrawer()"></div>


<div class="drawer" id="drawer-home_hero">
    <div class="drawer-header">
        <div class="drawer-icon" style="background:rgba(61,220,151,.12);color:#3ddc97;"><i class="bi bi-stars"></i></div>
        <div>
            <div class="drawer-title">Hero Section</div>
            <div class="drawer-subtitle">Home Page › Hero</div>
        </div>
        <button class="drawer-close" onclick="closeDrawer()"><i class="bi bi-x"></i></button>
    </div>
    <form action="<?php echo e(route('admin.content.update')); ?>" method="POST" class="d-flex flex-column h-full" style="flex:1;display:flex;flex-direction:column;">
        <?php echo csrf_field(); ?>
        <div class="drawer-body">
            <div class="field-group">
                <div class="field-label">Tagline <span class="field-hint">Small text above the headline</span></div>
                <input type="text" name="home_hero_tagline" class="form-control" value="<?php echo e(old('home_hero_tagline', $settings['home_hero_tagline'] ?? 'Creative group · Est. 2016 · Bandung / Jakarta / Bali')); ?>">
            </div>
            <div class="field-group">
                <div class="field-label">Main Title <span class="field-hint">Large hero headline</span></div>
                <textarea name="home_hero_title" class="form-control" rows="3" placeholder="e.g. Create to Elevate"><?php echo e(old('home_hero_title', $settings['home_hero_title'] ?? "Create\nto\nElevate")); ?></textarea>
            </div>
            <div class="field-group">
                <div class="field-label">Description <span class="field-hint">Short body text below the headline</span></div>
                <textarea name="home_hero_desc" class="form-control" rows="3"><?php echo e(old('home_hero_desc', $settings['home_hero_desc'] ?? 'Design · Production House · Events · Merch. An Indonesian creative group since 2016.')); ?></textarea>
            </div>
        </div>
        <div class="drawer-footer">
            <div class="unsaved-indicator" id="unsaved-home_hero"><i class="bi bi-circle-fill" style="font-size:.4rem;"></i> Unsaved changes</div>
            <button type="button" class="btn btn-ghost btn-sm" style="margin-left:auto;" onclick="closeDrawer()">Cancel</button>
            <button type="submit" class="btn btn-accent btn-sm"><i class="bi bi-check2"></i> Save Changes</button>
        </div>
    </form>
</div>


<div class="drawer" id="drawer-home_manifesto">
    <div class="drawer-header">
        <div class="drawer-icon" style="background:rgba(59,130,246,.12);color:#3b82f6;"><i class="bi bi-chat-quote-fill"></i></div>
        <div>
            <div class="drawer-title">Manifesto Section</div>
            <div class="drawer-subtitle">Home Page › Manifesto</div>
        </div>
        <button class="drawer-close" onclick="closeDrawer()"><i class="bi bi-x"></i></button>
    </div>
    <form action="<?php echo e(route('admin.content.update')); ?>" method="POST" style="flex:1;display:flex;flex-direction:column;">
        <?php echo csrf_field(); ?>
        <div class="drawer-body">
            <div class="field-group">
                <div class="field-label">Subtitle <span class="field-hint">Label above the manifesto, e.g. MANIFESTO</span></div>
                <input type="text" name="home_s1_subtitle" class="form-control" value="<?php echo e(old('home_s1_subtitle', $settings['home_s1_subtitle'] ?? 'MANIFESTO')); ?>">
            </div>
            <div class="field-group">
                <div class="field-label">Statement <span class="field-hint">Use *asterisks* to highlight words in green</span></div>
                <textarea name="home_s1_title" class="form-control" rows="5"><?php echo e(old('home_s1_title', $settings['home_s1_title'] ?? 'Every brief can be solved with *creativity, an *innovative route, and execution that actually lands.')); ?></textarea>
            </div>
        </div>
        <div class="drawer-footer">
            <button type="button" class="btn btn-ghost btn-sm" style="margin-left:auto;" onclick="closeDrawer()">Cancel</button>
            <button type="submit" class="btn btn-accent btn-sm"><i class="bi bi-check2"></i> Save Changes</button>
        </div>
    </form>
</div>


<div class="drawer" id="drawer-home_services_ov">
    <div class="drawer-header">
        <div class="drawer-icon" style="background:rgba(139,92,246,.12);color:#8b5cf6;"><i class="bi bi-grid-1x2"></i></div>
        <div><div class="drawer-title">Services Overview</div><div class="drawer-subtitle">Home Page › Services Section</div></div>
        <button class="drawer-close" onclick="closeDrawer()"><i class="bi bi-x"></i></button>
    </div>
    <form action="<?php echo e(route('admin.content.update')); ?>" method="POST" style="flex:1;display:flex;flex-direction:column;">
        <?php echo csrf_field(); ?>
        <div class="drawer-body">
            <div class="field-group">
                <div class="field-label">Section Title</div>
                <input type="text" name="home_s2_title" class="form-control" value="<?php echo e(old('home_s2_title', $settings['home_s2_title'] ?? 'We are not just thinkers. We are makers.')); ?>">
            </div>
        </div>
        <div class="drawer-footer">
            <button type="button" class="btn btn-ghost btn-sm" style="margin-left:auto;" onclick="closeDrawer()">Cancel</button>
            <button type="submit" class="btn btn-accent btn-sm"><i class="bi bi-check2"></i> Save Changes</button>
        </div>
    </form>
</div>


<div class="drawer" id="drawer-home_work_ov">
    <div class="drawer-header">
        <div class="drawer-icon" style="background:rgba(245,158,11,.12);color:#f59e0b;"><i class="bi bi-collection"></i></div>
        <div><div class="drawer-title">Selected Works</div><div class="drawer-subtitle">Home Page › Portfolio Section</div></div>
        <button class="drawer-close" onclick="closeDrawer()"><i class="bi bi-x"></i></button>
    </div>
    <form action="<?php echo e(route('admin.content.update')); ?>" method="POST" style="flex:1;display:flex;flex-direction:column;">
        <?php echo csrf_field(); ?>
        <div class="drawer-body">
            <div class="field-group">
                <div class="field-label">Section Title</div>
                <input type="text" name="home_s3_title" class="form-control" value="<?php echo e(old('home_s3_title', $settings['home_s3_title'] ?? 'Selected Works')); ?>">
            </div>
        </div>
        <div class="drawer-footer">
            <button type="button" class="btn btn-ghost btn-sm" style="margin-left:auto;" onclick="closeDrawer()">Cancel</button>
            <button type="submit" class="btn btn-accent btn-sm"><i class="bi bi-check2"></i> Save Changes</button>
        </div>
    </form>
</div>


<div class="drawer" id="drawer-home_process">
    <div class="drawer-header">
        <div class="drawer-icon" style="background:rgba(20,184,166,.12);color:#14b8a6;"><i class="bi bi-diagram-3-fill"></i></div>
        <div><div class="drawer-title">Process / How</div><div class="drawer-subtitle">Home Page › Process Steps</div></div>
        <button class="drawer-close" onclick="closeDrawer()"><i class="bi bi-x"></i></button>
    </div>
    <form action="<?php echo e(route('admin.content.update')); ?>" method="POST" style="flex:1;display:flex;flex-direction:column;">
        <?php echo csrf_field(); ?>
        <div class="drawer-body">
            <div class="field-group">
                <div class="field-label">Section Title</div>
                <input type="text" name="home_s4_title" class="form-control" value="<?php echo e(old('home_s4_title', $settings['home_s4_title'] ?? 'Trusted by industry leaders')); ?>">
            </div>
        </div>
        <div class="drawer-footer">
            <button type="button" class="btn btn-ghost btn-sm" style="margin-left:auto;" onclick="closeDrawer()">Cancel</button>
            <button type="submit" class="btn btn-accent btn-sm"><i class="bi bi-check2"></i> Save Changes</button>
        </div>
    </form>
</div>


<div class="drawer" id="drawer-home_news_ov">
    <div class="drawer-header">
        <div class="drawer-icon" style="background:rgba(239,68,68,.12);color:#ef4444;"><i class="bi bi-newspaper"></i></div>
        <div><div class="drawer-title">News & Insights</div><div class="drawer-subtitle">Home Page › News Preview Section</div></div>
        <button class="drawer-close" onclick="closeDrawer()"><i class="bi bi-x"></i></button>
    </div>
    <form action="<?php echo e(route('admin.content.update')); ?>" method="POST" style="flex:1;display:flex;flex-direction:column;">
        <?php echo csrf_field(); ?>
        <div class="drawer-body">
            <div class="field-group">
                <div class="field-label">Section Title</div>
                <input type="text" name="home_s5_title" class="form-control" value="<?php echo e(old('home_s5_title', $settings['home_s5_title'] ?? 'News & Insights')); ?>">
            </div>
        </div>
        <div class="drawer-footer">
            <button type="button" class="btn btn-ghost btn-sm" style="margin-left:auto;" onclick="closeDrawer()">Cancel</button>
            <button type="submit" class="btn btn-accent btn-sm"><i class="bi bi-check2"></i> Save Changes</button>
        </div>
    </form>
</div>


<div class="drawer" id="drawer-home_cta">
    <div class="drawer-header">
        <div class="drawer-icon" style="background:rgba(251,146,60,.12);color:#fb923c;"><i class="bi bi-megaphone-fill"></i></div>
        <div><div class="drawer-title">Call to Action</div><div class="drawer-subtitle">Home Page › Bottom CTA</div></div>
        <button class="drawer-close" onclick="closeDrawer()"><i class="bi bi-x"></i></button>
    </div>
    <form action="<?php echo e(route('admin.content.update')); ?>" method="POST" style="flex:1;display:flex;flex-direction:column;">
        <?php echo csrf_field(); ?>
        <div class="drawer-body">
            <div class="field-group">
                <div class="field-label">Headline</div>
                <input type="text" name="home_s6_title" class="form-control" value="<?php echo e(old('home_s6_title', $settings['home_s6_title'] ?? 'Ready to elevate your brand?')); ?>">
            </div>
            <div class="field-group">
                <div class="field-label">Quote <span class="field-hint">Italic quote below the headline</span></div>
                <textarea name="home_s6_quote" class="form-control" rows="3"><?php echo e(old('home_s6_quote', $settings['home_s6_quote'] ?? 'The best work happens when brave clients meet a relentless creative team.')); ?></textarea>
            </div>
        </div>
        <div class="drawer-footer">
            <button type="button" class="btn btn-ghost btn-sm" style="margin-left:auto;" onclick="closeDrawer()">Cancel</button>
            <button type="submit" class="btn btn-accent btn-sm"><i class="bi bi-check2"></i> Save Changes</button>
        </div>
    </form>
</div>


<div class="drawer" id="drawer-about_founder">
    <div class="drawer-header">
        <div class="drawer-icon" style="background:rgba(61,220,151,.12);color:#3ddc97;"><i class="bi bi-person-circle"></i></div>
        <div><div class="drawer-title">Founder Section</div><div class="drawer-subtitle">About Page › Founder</div></div>
        <button class="drawer-close" onclick="closeDrawer()"><i class="bi bi-x"></i></button>
    </div>
    <form action="<?php echo e(route('admin.content.update')); ?>" method="POST" style="flex:1;display:flex;flex-direction:column;">
        <?php echo csrf_field(); ?>
        <div class="drawer-body">
            <div class="field-group">
                <div class="field-label">Founder Name</div>
                <input type="text" name="about_founder_name" class="form-control" value="<?php echo e(old('about_founder_name', $settings['about_founder_name'] ?? 'Sona Lesmana')); ?>">
            </div>
            <div class="field-group">
                <div class="field-label">Title / Role</div>
                <input type="text" name="about_founder_title" class="form-control" value="<?php echo e(old('about_founder_title', $settings['about_founder_title'] ?? 'Founder & CEO')); ?>">
            </div>
            <div class="field-group">
                <div class="field-label">Signature Quote</div>
                <textarea name="about_founder_quote" class="form-control" rows="3"><?php echo e(old('about_founder_quote', $settings['about_founder_quote'] ?? 'Creativity without execution is just a hallucination.')); ?></textarea>
            </div>
        </div>
        <div class="drawer-footer">
            <button type="button" class="btn btn-ghost btn-sm" style="margin-left:auto;" onclick="closeDrawer()">Cancel</button>
            <button type="submit" class="btn btn-accent btn-sm"><i class="bi bi-check2"></i> Save Changes</button>
        </div>
    </form>
</div>


<div class="drawer" id="drawer-contact_info">
    <div class="drawer-header">
        <div class="drawer-icon" style="background:rgba(61,220,151,.12);color:#3ddc97;"><i class="bi bi-geo-alt-fill"></i></div>
        <div><div class="drawer-title">Contact Information</div><div class="drawer-subtitle">Contact Page › Info Details</div></div>
        <button class="drawer-close" onclick="closeDrawer()"><i class="bi bi-x"></i></button>
    </div>
    <form action="<?php echo e(route('admin.content.update')); ?>" method="POST" style="flex:1;display:flex;flex-direction:column;">
        <?php echo csrf_field(); ?>
        <div class="drawer-body">
            <div class="field-group">
                <div class="field-label">Email Address</div>
                <input type="email" name="contact_email" class="form-control" value="<?php echo e(old('contact_email', $settings['contact_email'] ?? 'hello@fugocreativegroup.com')); ?>">
            </div>
            <div class="field-group">
                <div class="field-label">Phone Number</div>
                <input type="text" name="contact_phone" class="form-control" value="<?php echo e(old('contact_phone', $settings['contact_phone'] ?? '+62 821 2100 0680')); ?>">
            </div>
            <div class="field-group">
                <div class="field-label">Office Address (Bandung)</div>
                <textarea name="contact_address_bdg" class="form-control" rows="2"><?php echo e(old('contact_address_bdg', $settings['contact_address_bdg'] ?? 'Jl. Permata Taman Sari Raya No.21, Bandung')); ?></textarea>
            </div>
            <div class="field-group">
                <div class="field-label">Instagram URL</div>
                <input type="text" name="contact_instagram" class="form-control" value="<?php echo e(old('contact_instagram', $settings['contact_instagram'] ?? '')); ?>">
            </div>
            <div class="field-group">
                <div class="field-label">LinkedIn URL</div>
                <input type="text" name="contact_linkedin" class="form-control" value="<?php echo e(old('contact_linkedin', $settings['contact_linkedin'] ?? '')); ?>">
            </div>
        </div>
        <div class="drawer-footer">
            <button type="button" class="btn btn-ghost btn-sm" style="margin-left:auto;" onclick="closeDrawer()">Cancel</button>
            <button type="submit" class="btn btn-accent btn-sm"><i class="bi bi-check2"></i> Save Changes</button>
        </div>
    </form>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
let activeDrawer = null;

function openDrawer(id) {
    closeDrawer();
    const drawer = document.getElementById('drawer-' + id);
    const overlay = document.getElementById('drawerOverlay');
    if (!drawer) return;
    overlay.classList.add('open');
    drawer.classList.add('open');
    activeDrawer = id;
    document.body.style.overflow = 'hidden';
}

function closeDrawer() {
    if (activeDrawer) {
        const drawer = document.getElementById('drawer-' + activeDrawer);
        if (drawer) drawer.classList.remove('open');
    }
    document.getElementById('drawerOverlay').classList.remove('open');
    activeDrawer = null;
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeDrawer();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Reyhan\Fugo Creative\direction-a-motion(git)\direction-a-motion\resources\views/admin/content/index.blade.php ENDPATH**/ ?>