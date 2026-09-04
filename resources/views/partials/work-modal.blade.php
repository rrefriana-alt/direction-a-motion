@php use App\Support\Works as W; @endphp

<div class="wm" id="wm-{{ $w['slug'] }}" data-slug="{{ $w['slug'] }}" role="dialog" aria-modal="true"
     aria-labelledby="wm-{{ $w['slug'] }}-title" hidden>
  <div class="wm__scrim" data-wm-close></div>

  <div class="wm__panel" role="document">
    <button class="wm__close" type="button" data-wm-close aria-label="Close"
            data-en="Close" data-id="Tutup"><span aria-hidden="true">&#10005;</span></button>

    <div class="wm__scroll" data-lenis-prevent tabindex="-1">

      <header class="wm__hero">
        <div class="wm__art">
          @if (! empty($w['hero_image']))
            <img src="{{ W::img($w['hero_image']) }}" alt="{{ W::text($w['title']) }}" loading="lazy">
          @else
            {!! W::art($w, 0, 'hero') !!}
          @endif
        </div>
        <div class="wm__heroin">
          <p class="crumb">
            <span>{{ $w['n'] }}</span> <span>/</span>
            <span{!! W::attrs($w['category']) !!}>{{ W::text($w['category']) }}</span>
            <span>/</span> <span>{{ $w['year'] }}</span>
          </p>
          <h2 class="wm__title" id="wm-{{ $w['slug'] }}-title"{!! W::attrs($w['title']) !!}>{{ W::text($w['title']) }}</h2>
          @if (! empty($w['lede']))
            <p class="wm__lede"{!! W::attrs($w['lede']) !!}>{{ W::text($w['lede']) }}</p>
          @endif
        </div>
      </header>

      <div class="wm__in">

        <div class="wm__facts">
          <div>
            <p class="mono faint" data-en="Client" data-id="Klien">Client</p>
            <p class="wm__fact">{{ W::text($w['client']) }}</p>
          </div>
          @if (! empty($w['scope']))
            <div>
              <p class="mono faint" data-en="Scope" data-id="Lingkup">Scope</p>
              <p class="wm__fact"{!! W::attrs($w['scope']) !!}>{{ W::text($w['scope']) }}</p>
            </div>
          @endif
          <div>
            <p class="mono faint" data-en="Year" data-id="Tahun">Year</p>
            <p class="wm__fact">{{ $w['year'] }}</p>
          </div>
          @if (! empty($w['division']))
            <div>
              <p class="mono faint" data-en="Division" data-id="Divisi">Division</p>
              <p class="wm__fact"{!! W::attrs($w['division']) !!}>{{ W::text($w['division']) }}</p>
            </div>
          @endif
          @if (! empty($w['logo']))
            <div class="wm__logo"><img src="{{ W::img($w['logo']) }}" alt="{{ W::text($w['client']) }}" loading="lazy"></div>
          @endif
        </div>

        @if (! empty($w['tags']))
          <div class="card__tags wm__tags">
            @foreach ($w['tags'] as $tag)
              <span class="tag"{!! W::attrs($tag) !!}>{{ W::text($tag) }}</span>
            @endforeach
          </div>
        @endif

        @if (! empty($w['about']))
          <section class="wm__sec">
            <p class="eyebrow" data-en="What it is" data-id="Apa ini">What it is</p>
            <div class="wm__prose">
              @foreach ((array) $w['about'] as $para)
                <p{!! W::attrs($para) !!}>{{ W::text($para) }}</p>
              @endforeach
            </div>
          </section>
        @endif

        @if (! empty($w['steps']))
          <section class="wm__sec">
            <p class="eyebrow" data-en="What we did" data-id="Yang kami lakukan">What we did</p>
            <div class="steps">
              @foreach ($w['steps'] as $i => $step)
                <div class="step">
                  <span class="step__n">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                  <div class="step__b">
                    <h3{!! W::attrs($step['h']) !!}>{{ W::text($step['h']) }}</h3>
                    <p{!! W::attrs($step['p']) !!}>{{ W::text($step['p']) }}</p>
                  </div>
                </div>
              @endforeach
            </div>
          </section>
        @endif

        @if (! empty($w['stats']))
          <section class="wm__sec">
            <p class="eyebrow" data-en="Outcome" data-id="Hasil">Outcome</p>
            <div class="stats wm__stats">
              @foreach ($w['stats'] as $stat)
                <div class="stat">
                  <p class="stat__n"><span data-wm-count="{{ $stat['n'] }}">{{ $stat['n'] }}</span>@if(!empty($stat['suffix']))<sup>{{ $stat['suffix'] }}</sup>@endif</p>
                  <p class="stat__l"{!! W::attrs($stat['l']) !!}>{{ W::text($stat['l']) }}</p>
                </div>
              @endforeach
            </div>
          </section>
        @endif
        @if (! empty($w['result']))
          <section class="wm__sec">
            <p class="eyebrow" data-en="Outcome" data-id="Hasil">Outcome</p>
            <div class="wm__prose"><p{!! W::attrs($w['result']) !!}>{{ W::text($w['result']) }}</p></div>
          </section>
        @endif

        @if (! empty($w['gallery']))
          <section class="wm__sec">
            <p class="eyebrow" data-en="Gallery" data-id="Galeri">Gallery</p>
            <p class="wm__hint mono faint" data-en="Click any frame to enlarge" data-id="Klik frame mana pun untuk memperbesar">Click any frame to enlarge</p>
            <div class="wm__gal">
              @foreach ($w['gallery'] as $i => $item)
                @php $isVideo = ! empty($item['video']); @endphp
                <button class="wm__tile @if($i === 0) is-wide @endif" type="button" data-wm-lb
                        data-cursor="{{ $isVideo ? 'Play' : 'Expand' }}">
                  <span class="wm__tilemedia">
                    @if (! empty($item['src']))
                      <img src="{{ asset($item['src']) }}" alt="{{ W::text($item['cap']) }}" loading="lazy">
                    @elseif (is_string($item['video'] ?? null))
                      <video src="{{ asset($item['video']) }}" @if(!empty($item['poster'])) poster="{{ asset($item['poster']) }}" @endif muted playsinline preload="none"></video>
                    @else
                      {!! W::art($w, $i + 1, 'gal') !!}
                    @endif
                    @if ($isVideo)
                      <span class="wm__play" aria-hidden="true">&#9654;</span>
                    @endif
                  </span>
                  <span class="wm__tilecap">
                    <span class="mono faint"{!! W::attrs($item['kind']) !!}>{{ W::text($item['kind']) }}</span>
                    <span{!! W::attrs($item['cap']) !!}>{{ W::text($item['cap']) }}</span>
                  </span>
                </button>
              @endforeach
            </div>
          </section>
        @endif

        @if (! empty($w['docs']))
          <section class="wm__sec">
            <p class="eyebrow" data-en="Documentation" data-id="Dokumentasi">Documentation</p>
            <ul class="wm__docs">
              @foreach ($w['docs'] as $doc)
                <li class="wm__doc">
                  @if (! empty($doc['href']))
                    <a href="{{ $doc['href'] }}" target="_blank" rel="noopener">
                      <span{!! W::attrs($doc['label']) !!}>{{ W::text($doc['label']) }}</span>
                      <span class="mono faint"{!! W::attrs($doc['meta'] ?? '') !!}>{{ W::text($doc['meta'] ?? '') }}</span>
                      <span class="wm__docico" aria-hidden="true">&#8595;</span>
                    </a>
                  @else
                    <span{!! W::attrs($doc['label']) !!}>{{ W::text($doc['label']) }}</span>
                    <span class="mono faint"{!! W::attrs($doc['meta'] ?? '') !!}>{{ W::text($doc['meta'] ?? '') }}</span>
                    <span class="mono wm__onreq" data-en="On request" data-id="Atas permintaan">On request</span>
                  @endif
                </li>
              @endforeach
            </ul>
          </section>
        @endif

        @if (! empty($w['usecases']))
          <section class="wm__sec">
            <p class="eyebrow" data-en="Where it is used" data-id="Di mana dipakai">Where it is used</p>
            <div class="wm__uses">
              @foreach ($w['usecases'] as $use)
                <div class="wm__use">
                  <h4{!! W::attrs($use['h']) !!}>{{ W::text($use['h']) }}</h4>
                  <p{!! W::attrs($use['p']) !!}>{{ W::text($use['p']) }}</p>
                </div>
              @endforeach
            </div>
          </section>
        @endif

        @if (! empty($w['credits']))
          <section class="wm__sec">
            <p class="eyebrow" data-en="Credits" data-id="Kredit">Credits</p>
            <ul class="wm__credits">
              @foreach ($w['credits'] as $credit)
                <li>
                  <span class="mono faint"{!! W::attrs($credit['role']) !!}>{{ W::text($credit['role']) }}</span>
                  <span>{{ W::text($credit['name']) }}</span>
                </li>
              @endforeach
            </ul>
          </section>
        @endif

        <footer class="wm__foot">
          <div class="wm__nav">
            @if ($prev)
              <button class="tlink" type="button" data-wm-go="{{ $prev }}"
                      data-en="&#8592; Previous project" data-id="&#8592; Proyek sebelumnya">&#8592; Previous project</button>
            @endif
            @if ($next)
              <button class="tlink green" type="button" data-wm-go="{{ $next }}"
                      data-en="Next project &#8594;" data-id="Proyek berikutnya &#8594;">Next project &#8594;</button>
            @endif
          </div>
          <div class="wm__cta">
            @if (! empty($w['case_study']))
              <a class="btn btn--ghost btn--sm" href="{{ url($w['case_study']) }}"
                 data-en="Read the full case study" data-id="Baca studi kasus lengkap">Read the full case study</a>
            @endif
            <a class="btn btn--green btn--sm" href="{{ url('contact') }}" data-cursor="Go">
              <span data-en="Start a project like this" data-id="Mulai proyek seperti ini">Start a project like this</span>
              <span class="ico" aria-hidden="true">&#8599;</span>
            </a>
          </div>
        </footer>

      </div>
    </div>
  </div>
</div>
