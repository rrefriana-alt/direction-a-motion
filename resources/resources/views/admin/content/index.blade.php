@extends('admin.layout')
@section('title', 'Website Settings')
@section('page-title', 'Website Content Settings')

@section('content')

<form action="{{ route('admin.content.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div x-data="{ tab: 'home' }">
        <!-- Tabs -->
        <ul class="nav nav-pills mb-4">
            <li class="nav-item">
                <button type="button" class="nav-link" :class="{ 'active': tab === 'home' }" @click="tab = 'home'">Home Page</button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link" :class="{ 'active': tab === 'about' }" @click="tab = 'about'">About / Studio</button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link" :class="{ 'active': tab === 'contact' }" @click="tab = 'contact'">Contact</button>
            </li>
        </ul>

        <!-- Home Tab -->
        <div x-show="tab === 'home'">
            <div class="card card-modern mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-primary mb-3">Hero Section</h5>
                    <div class="mb-3">
                        <label class="form-label form-label-modern">Tagline</label>
                        <input type="text" name="home_hero_tagline" class="form-control form-control-modern" value="{{ old('home_hero_tagline', $settings['home_hero_tagline'] ?? 'Creative group · Est. 2016 · Bandung / Jakarta / Bali') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label form-label-modern">Title (Use new lines for breaks)</label>
                        <textarea name="home_hero_title" class="form-control form-control-modern" rows="3">{{ old('home_hero_title', $settings['home_hero_title'] ?? "Create\nto\nElevate") }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label form-label-modern">Description</label>
                        <textarea name="home_hero_desc" class="form-control form-control-modern" rows="2">{{ old('home_hero_desc', $settings['home_hero_desc'] ?? 'Design · Production House · Events · Merch. An Indonesian creative group since 2016.') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Section 1 -->
            <div class="card card-modern mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-primary mb-3">Section 1: Manifesto</h5>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label form-label-modern">Subtitle</label>
                            <input type="text" name="home_s1_subtitle" class="form-control form-control-modern" value="{{ old('home_s1_subtitle', $settings['home_s1_subtitle'] ?? 'MANIFESTO') }}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label form-label-modern">Title (Use * for italic/highlight)</label>
                            <textarea name="home_s1_title" class="form-control form-control-modern" rows="2">{{ old('home_s1_title', $settings['home_s1_title'] ?? 'Every brief can be solved with *creativity, an *innovative route, and execution that actually lands.') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2 -->
            <div class="card card-modern mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-primary mb-3">Section 2: About Intro</h5>
                    <div class="mb-3">
                        <label class="form-label form-label-modern">Title</label>
                        <input type="text" name="home_s2_title" class="form-control form-control-modern" value="{{ old('home_s2_title', $settings['home_s2_title'] ?? 'We are not just thinkers. We are makers.') }}">
                    </div>
                </div>
            </div>

            <!-- Section 3 -->
            <div class="card card-modern mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-primary mb-3">Section 3: Selected Works</h5>
                    <div class="mb-3">
                        <label class="form-label form-label-modern">Title</label>
                        <input type="text" name="home_s3_title" class="form-control form-control-modern" value="{{ old('home_s3_title', $settings['home_s3_title'] ?? 'Selected Works') }}">
                    </div>
                </div>
            </div>

            <!-- Section 4 -->
            <div class="card card-modern mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-primary mb-3">Section 4: Clients</h5>
                    <div class="mb-3">
                        <label class="form-label form-label-modern">Title</label>
                        <input type="text" name="home_s4_title" class="form-control form-control-modern" value="{{ old('home_s4_title', $settings['home_s4_title'] ?? 'Trusted by industry leaders') }}">
                    </div>
                </div>
            </div>

            <!-- Section 5 -->
            <div class="card card-modern mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-primary mb-3">Section 5: News</h5>
                    <div class="mb-3">
                        <label class="form-label form-label-modern">Title</label>
                        <input type="text" name="home_s5_title" class="form-control form-control-modern" value="{{ old('home_s5_title', $settings['home_s5_title'] ?? 'News & Insights') }}">
                    </div>
                </div>
            </div>

            <!-- Section 6 -->
            <div class="card card-modern mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-primary mb-3">Section 6: Call to Action</h5>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label form-label-modern">Title</label>
                            <input type="text" name="home_s6_title" class="form-control form-control-modern" value="{{ old('home_s6_title', $settings['home_s6_title'] ?? 'Ready to elevate your brand?') }}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label form-label-modern">Quote / Description</label>
                            <textarea name="home_s6_quote" class="form-control form-control-modern" rows="2">{{ old('home_s6_quote', $settings['home_s6_quote'] ?? 'The best work happens when brave clients meet a relentless creative team.') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- About Tab -->
        <div x-show="tab === 'about'" style="display: none;">
            <div class="card card-modern mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-primary mb-3">Founder Information</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label form-label-modern">Name</label>
                            <input type="text" name="about_founder_name" class="form-control form-control-modern" value="{{ old('about_founder_name', $settings['about_founder_name'] ?? 'Sona Lesmana') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label form-label-modern">Title</label>
                            <input type="text" name="about_founder_title" class="form-control form-control-modern" value="{{ old('about_founder_title', $settings['about_founder_title'] ?? 'Founder & CEO') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label form-label-modern">Quote</label>
                        <textarea name="about_founder_quote" class="form-control form-control-modern" rows="3">{{ old('about_founder_quote', $settings['about_founder_quote'] ?? 'Creativity without execution is just a hallucination.') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label form-label-modern">Photo (Upload new to replace)</label>
                        <input type="file" name="about_founder_photo" class="form-control form-control-modern" accept="image/*">
                        @if(!empty($settings['about_founder_photo']))
                            <div class="mt-2">
                                <img src="{{ asset($settings['about_founder_photo']) }}" alt="Founder Photo" class="img-thumbnail" style="max-height: 100px;">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Tab -->
        <div x-show="tab === 'contact'" style="display: none;">
            <div class="card card-modern mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-primary mb-3">Contact Information</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label form-label-modern">Email</label>
                            <input type="email" name="contact_email" class="form-control form-control-modern" value="{{ old('contact_email', $settings['contact_email'] ?? 'hello@fugocreativegroup.com') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label form-label-modern">Phone</label>
                            <input type="text" name="contact_phone" class="form-control form-control-modern" value="{{ old('contact_phone', $settings['contact_phone'] ?? '+62 821 2100 0680') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label form-label-modern">Instagram (Full URL)</label>
                            <input type="url" name="contact_instagram" class="form-control form-control-modern" value="{{ old('contact_instagram', $settings['contact_instagram'] ?? '') }}" placeholder="https://instagram.com/...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label form-label-modern">LinkedIn (Full URL)</label>
                            <input type="url" name="contact_linkedin" class="form-control form-control-modern" value="{{ old('contact_linkedin', $settings['contact_linkedin'] ?? '') }}" placeholder="https://linkedin.com/in/...">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label form-label-modern">Address (Bandung)</label>
                        <textarea name="contact_address_bdg" class="form-control form-control-modern" rows="3">{{ old('contact_address_bdg', $settings['contact_address_bdg'] ?? 'Jl. Permata Taman Sari Raya No.21, Bandung') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-4 mb-5 text-end">
            <button type="submit" class="btn btn-accent px-5 py-2 fw-bold" style="font-size:1.1rem;"><i class="bi bi-save me-2"></i> Save Settings</button>
        </div>
    </div>
</form>
@endsection
