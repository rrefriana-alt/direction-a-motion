@php
    $footerDesc = \App\Models\Setting::get('footer_description', 'PT Fugo Creative Group — a creative company delivering innovative, high-impact solutions since 2016.');
    $footerInstagram = \App\Models\Setting::get('footer_instagram', 'https://instagram.com/fugocreative');
    $footerLinkedin = \App\Models\Setting::get('footer_linkedin', 'https://id.linkedin.com/company/fugo-creativegroup');
    $footerTiktok = \App\Models\Setting::get('footer_tiktok', 'https://tiktok.com/@fugo.creative');
    $footerYoutube = \App\Models\Setting::get('footer_youtube', 'https://youtube.com/@fugocreative');
    $footerPhone = \App\Models\Setting::get('footer_phone', '+62 821 2100 0680');
@endphp

<footer class="foot">
  <div class="shell">
    <div class="foot__top">
      <div>
        <a class="brand" href="{{ url('') }}">
          <img class="brand__mark" src="{{ asset('assets/img/logo-full.webp') }}" alt="Fugo Creative">
        </a>
        <p class="muted mt-m" style="max-width:34ch;font-size:.92rem"
           data-en="{{ $footerDesc }}"
           data-id="{{ $footerDesc }}">{{ $footerDesc }}</p>
      </div>

      <div>
        <h5 data-en="Navigate" data-id="Navigasi">Navigate</h5>
        <ul>
          <li><a href="{{ url('work') }}" data-en="Work" data-id="Karya">Work</a></li>
          <li><a href="{{ url('services') }}" data-en="Services" data-id="Layanan">Services</a></li>
          <li><a href="{{ url('about') }}" data-en="About" data-id="Tentang">About</a></li>
          <li><a href="{{ url('contact') }}" data-en="Contact" data-id="Kontak">Contact</a></li>
          <li><a href="{{ url('contact') }}" data-en="Careers" data-id="Karier">Careers</a></li>
        </ul>
      </div>

      <div>
        <h5 data-en="Follow" data-id="Ikuti">Follow</h5>
        <ul>
          @if($footerInstagram)
          <li><a href="{{ $footerInstagram }}" rel="noopener">Instagram</a></li>
          @endif
          @if($footerLinkedin)
          <li><a href="{{ $footerLinkedin }}" rel="noopener">LinkedIn</a></li>
          @endif
          @if($footerTiktok)
          <li><a href="{{ $footerTiktok }}" rel="noopener">TikTok</a></li>
          @endif
          @if($footerYoutube)
          <li><a href="{{ $footerYoutube }}" rel="noopener">YouTube</a></li>
          @endif
        </ul>
      </div>

      <div>
        <h5 data-en="Offices" data-id="Kantor">Offices</h5>
        <address><strong style="color:var(--ink)">Bandung — HQ</strong><br>Jl. Permata Taman Sari Raya No.21, Arcamanik</address>
        <address><strong style="color:var(--ink)">Jakarta</strong><br>Jl. Srengseng Sawah No.16, Jagakarsa</address>
        <address><strong style="color:var(--ink)">Bali</strong><br>Jl. Tukad Melangit, Samplangan, Gianyar</address>
      </div>
    </div>

    <p class="display foot__word" aria-hidden="true">FUGO</p>

    <div class="foot__bot">
      <span>© {{ date('Y') }} PT Fugo Creative Group</span>
      <span><a href="tel:{{ str_replace(' ', '', $footerPhone) }}">{{ $footerPhone }}</a></span>
    </div>
  </div>
</footer>
