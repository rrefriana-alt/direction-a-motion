<?php
    $footerDesc = \App\Models\Setting::get('footer_description', 'PT Fugo Creative Group — a creative company delivering innovative, high-impact solutions since 2016.');
    $footerInstagram = \App\Models\Setting::get('footer_instagram', 'https://instagram.com/fugocreative');
    $footerLinkedin = \App\Models\Setting::get('footer_linkedin', 'https://id.linkedin.com/company/fugo-creativegroup');
    $footerTiktok = \App\Models\Setting::get('footer_tiktok', 'https://tiktok.com/@fugo.creative');
    $footerYoutube = \App\Models\Setting::get('footer_youtube', 'https://youtube.com/@fugocreative');
    $footerPhone = \App\Models\Setting::get('footer_phone', '+62 821 2100 0680');
?>

<footer class="foot">
  <div class="shell">
    <div class="foot__top">
      <div>
        <a class="brand" href="<?php echo e(url('')); ?>">
          <svg class="brand__mark" viewBox="0 0 32 32" aria-hidden="true">
            <path d="M11 6h14l-3.4 5.6H7.6zM7.6 14h12l-3.4 5.6H4.2zM4.2 22h10l-3.4 5.6H.8z" fill="#3ddc97"/>
          </svg>
          <span class="brand__txt">Fugo<span>Creative</span></span>
        </a>
        <p class="muted mt-m" style="max-width:34ch;font-size:.92rem"
           data-en="<?php echo e($footerDesc); ?>"
           data-id="<?php echo e($footerDesc); ?>"><?php echo e($footerDesc); ?></p>
      </div>

      <div>
        <h5 data-en="Navigate" data-id="Navigasi">Navigate</h5>
        <ul>
          <li><a href="<?php echo e(url('work')); ?>" data-en="Work" data-id="Karya">Work</a></li>
          <li><a href="<?php echo e(url('services')); ?>" data-en="Services" data-id="Layanan">Services</a></li>
          <li><a href="<?php echo e(url('about')); ?>" data-en="About" data-id="Tentang">About</a></li>
          <li><a href="<?php echo e(url('contact')); ?>" data-en="Contact" data-id="Kontak">Contact</a></li>
          <li><a href="<?php echo e(url('contact')); ?>" data-en="Careers" data-id="Karier">Careers</a></li>
        </ul>
      </div>

      <div>
        <h5 data-en="Follow" data-id="Ikuti">Follow</h5>
        <ul>
          <?php if($footerInstagram): ?>
          <li><a href="<?php echo e($footerInstagram); ?>" rel="noopener">Instagram</a></li>
          <?php endif; ?>
          <?php if($footerLinkedin): ?>
          <li><a href="<?php echo e($footerLinkedin); ?>" rel="noopener">LinkedIn</a></li>
          <?php endif; ?>
          <?php if($footerTiktok): ?>
          <li><a href="<?php echo e($footerTiktok); ?>" rel="noopener">TikTok</a></li>
          <?php endif; ?>
          <?php if($footerYoutube): ?>
          <li><a href="<?php echo e($footerYoutube); ?>" rel="noopener">YouTube</a></li>
          <?php endif; ?>
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
      <span>© <?php echo e(date('Y')); ?> PT Fugo Creative Group</span>
      <span data-en="Concept redesign — Direction A &quot;Signal&quot;" data-id="Konsep redesain — Direction A &quot;Signal&quot;">Concept redesign — Direction A "Signal"</span>
      <span><a href="tel:<?php echo e(str_replace(' ', '', $footerPhone)); ?>"><?php echo e($footerPhone); ?></a></span>
    </div>
  </div>
</footer>
<?php /**PATH D:\Reyhan\Fugo Creative\direction-a-motion(git)\direction-a-motion\resources\views/partials/footer.blade.php ENDPATH**/ ?>