<?php
$file = 'resources/views/index.blade.php';
$content = file_get_contents($file);

// Replace svc__index
$oldIndex = '/<ul class="svc__index" aria-hidden="true">.*?<\/ul>/s';
$newIndex = '<ul class="svc__index" aria-hidden="true">
          @if(isset($categories) && count($categories) > 0)
              @foreach($categories as $index => $cat)
              <li class="svc__idx {{ $index === 0 ? \'on\' : \'\' }}"><span class="n">{{ str_pad($index + 1, 2, \'0\', STR_PAD_LEFT) }}</span><span class="t">{{ $cat->name }}</span></li>
              @endforeach
          @endif
        </ul>';
$content = preg_replace($oldIndex, $newIndex, $content);

// Replace svc__panels
$oldPanels = '/<div class="svc__panels">.*?<\/div>\s*<\/div>\s*<\/div>\s*<\/section>/s';

$svgs = [
    // Design
    '<svg viewBox="0 0 400 240" preserveAspectRatio="xMidYMid slice" style="width:100%;height:100%">
              <defs><linearGradient id="ga1" x1="0" y1="0" x2="1" y2="1">
                <stop offset="0" stop-color="#3ddc97" stop-opacity=".9"/><stop offset="1" stop-color="#c8f24e" stop-opacity=".25"/></linearGradient></defs>
              <rect width="400" height="240" fill="#0d0f13"/>
              <g stroke="#23272f"><path d="M0 60h400M0 120h400M0 180h400M100 0v240M200 0v240M300 0v240"/></g>
              <circle cx="140" cy="120" r="66" fill="url(#ga1)"/>
              <rect x="196" y="54" width="132" height="132" rx="10" fill="none" stroke="#3ddc97" stroke-width="1.5"/>
              <path d="M196 186 328 54" stroke="#c8f24e" stroke-width="1.5"/>
            </svg>',
    // Film
    '<svg viewBox="0 0 400 240" preserveAspectRatio="xMidYMid slice" style="width:100%;height:100%">
              <rect width="400" height="240" fill="#0d0f13"/>
              <g fill="#23272f"><rect x="0" y="16" width="400" height="14"/><rect x="0" y="210" width="400" height="14"/></g>
              <g fill="#07080a"><rect x="14" y="19" width="20" height="8" rx="2"/><rect x="54" y="19" width="20" height="8" rx="2"/><rect x="94" y="19" width="20" height="8" rx="2"/><rect x="134" y="19" width="20" height="8" rx="2"/><rect x="174" y="19" width="20" height="8" rx="2"/><rect x="214" y="19" width="20" height="8" rx="2"/><rect x="254" y="19" width="20" height="8" rx="2"/><rect x="294" y="19" width="20" height="8" rx="2"/><rect x="334" y="19" width="20" height="8" rx="2"/>
                <rect x="14" y="213" width="20" height="8" rx="2"/><rect x="54" y="213" width="20" height="8" rx="2"/><rect x="94" y="213" width="20" height="8" rx="2"/><rect x="134" y="213" width="20" height="8" rx="2"/><rect x="174" y="213" width="20" height="8" rx="2"/><rect x="214" y="213" width="20" height="8" rx="2"/><rect x="254" y="213" width="20" height="8" rx="2"/><rect x="294" y="213" width="20" height="8" rx="2"/><rect x="334" y="213" width="20" height="8" rx="2"/></g>
              <rect x="40" y="52" width="150" height="136" rx="8" fill="#14171d" stroke="#23272f"/>
              <rect x="210" y="52" width="150" height="136" rx="8" fill="#14171d" stroke="#23272f"/>
              <circle cx="115" cy="120" r="26" fill="none" stroke="#3ddc97" stroke-width="2"/>
              <path d="M107 108l22 12-22 12z" fill="#3ddc97"/>
              <path d="M226 160c30-56 60-56 90 0" stroke="#c8f24e" stroke-width="2" fill="none"/>
            </svg>',
    // Events
    '<svg viewBox="0 0 400 240" preserveAspectRatio="xMidYMid slice" style="width:100%;height:100%">
              <defs><radialGradient id="gb1" cx=".5" cy="0" r="1">
                <stop offset="0" stop-color="#3ddc97" stop-opacity=".55"/><stop offset="1" stop-color="#3ddc97" stop-opacity="0"/></radialGradient></defs>
              <rect width="400" height="240" fill="#0d0f13"/>
              <path d="M120 0 40 240h120L200 0z" fill="url(#gb1)"/>
              <path d="M280 0 200 240h120L360 0z" fill="url(#gb1)" opacity=".6"/>
              <rect x="60" y="180" width="280" height="8" rx="4" fill="#23272f"/>
              <g fill="#3ddc97"><circle cx="110" cy="200" r="5"/><circle cx="150" cy="206" r="5"/><circle cx="190" cy="198" r="5"/><circle cx="230" cy="207" r="5"/><circle cx="270" cy="199" r="5"/></g>
              <rect x="150" y="60" width="100" height="60" rx="6" fill="none" stroke="#c8f24e" stroke-width="1.5"/>
            </svg>',
    // Merch
    '<svg viewBox="0 0 400 240" preserveAspectRatio="xMidYMid slice" style="width:100%;height:100%">
              <rect width="400" height="240" fill="#0d0f13"/>
              <g stroke="#23272f" fill="none">
                <rect x="30" y="50" width="100" height="140" rx="10"/>
                <rect x="150" y="50" width="100" height="140" rx="10"/>
                <rect x="270" y="50" width="100" height="140" rx="10"/>
              </g>
              <path d="M60 90h40v70H60z" fill="#3ddc97" opacity=".85"/>
              <circle cx="200" cy="120" r="34" fill="none" stroke="#c8f24e" stroke-width="2"/>
              <path d="M186 120h28M200 106v28" stroke="#c8f24e" stroke-width="2"/>
              <path d="M300 100h40v20h-40zM300 130h40v30h-40z" fill="#23272f"/>
              <rect x="300" y="100" width="40" height="20" fill="#3ddc97" opacity=".5"/>
            </svg>',
    // AI Agent
    '<svg viewBox="0 0 400 240" preserveAspectRatio="xMidYMid slice" style="width:100%;height:100%">
              <rect width="400" height="240" fill="#0d0f13"/>
              <g stroke="#23272f"><path d="M0 60h400M0 180h400M100 0v240M300 0v240"/></g>
              <!-- orthogonal agent graph, echoing the hero\'s routing -->
              <g stroke="#3ddc97" stroke-width="1.5" fill="none">
                <path d="M60 120h60v-60h80"/>
                <path d="M60 120h60v60h80"/>
                <path d="M280 60h40v60h20"/>
                <path d="M280 180h40v-60"/>
              </g>
              <rect x="150" y="96" width="100" height="48" rx="6" fill="#14171d" stroke="#c8f24e" stroke-width="1.5"/>
              <g fill="#c8f24e"><rect x="170" y="116" width="8" height="8"/><rect x="196" y="116" width="8" height="8"/><rect x="222" y="116" width="8" height="8"/></g>
              <g fill="#3ddc97"><rect x="54" y="114" width="12" height="12"/><rect x="274" y="54" width="12" height="12"/><rect x="274" y="174" width="12" height="12"/><rect x="334" y="114" width="12" height="12"/></g>
            </svg>'
];

$newPanels = '<div class="svc__panels">
          @if(isset($categories) && count($categories) > 0)
              @foreach($categories as $index => $cat)
              <article class="card fade-up" data-cursor="{{ $cat->name }}">
                <div class="card__art">
                  @if($cat->image)
                      <img src="{{ $cat->image }}" style="width:100%;height:100%;object-fit:cover;">
                  @else
                      @switch($index)
                          @case(0)
                              ' . $svgs[0] . '
                              @break
                          @case(1)
                              ' . $svgs[1] . '
                              @break
                          @case(2)
                              ' . $svgs[2] . '
                              @break
                          @case(3)
                              ' . $svgs[3] . '
                              @break
                          @case(4)
                              ' . $svgs[4] . '
                              @break
                          @default
                              <div style="width:100%;height:100%;background:#0d0f13;display:flex;align-items:center;justify-content:center;color:#3ddc97;font-size:2rem;"><i class="bi bi-image"></i></div>
                      @endswitch
                  @endif
                </div>
                <p class="card__num">{{ str_pad($index + 1, 2, \'0\', STR_PAD_LEFT) }}</p>
                <h3>{{ $cat->name }}</h3>
                <p>{{ $cat->description }}</p>
                <div class="card__tags">
                  @foreach($cat->items as $item)
                      <span class="tag">{{ $item->title }}</span>
                  @endforeach
                </div>
              </article>
              @endforeach
          @endif
        </div>
      </div>
    </div>
</section>';

$content = preg_replace($oldPanels, $newPanels, $content);

// Replace Selected Work (projects)
$oldWork = '/<div class="hscroll__track">.*?<\/div>\s*<\/div>\s*<\/div>/s';
$newWork = '<div class="hscroll__track">
      @if(isset($projects) && count($projects) > 0)
          @foreach($projects as $proj)
          <article class="wcard" data-cursor="Case study">
            <div class="wcard__art">
                @if($proj->hero_image)
                    <img src="{{ $proj->hero_image }}" style="width:100%;height:100%;object-fit:cover;">
                @else
                    <svg viewBox="0 0 620 440" preserveAspectRatio="xMidYMid slice" style="width:100%;height:100%">
                        <defs><linearGradient id="w1" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#0e3c8c"/><stop offset="1" stop-color="#07080a"/></linearGradient></defs>
                        <rect width="620" height="440" fill="url(#w1)"/>
                        <circle cx="470" cy="120" r="150" fill="#3ddc97" opacity=".14"/>
                        <rect x="60" y="150" width="230" height="150" rx="16" fill="#0b1226" stroke="#3ddc97" stroke-opacity=".5"/>
                    </svg>
                @endif
            </div>
            <div class="wcard__body">
              <div class="wcard__meta"><span>{{ $proj->client ?? \'Client\' }}</span><span>&bull;</span><span>{{ $proj->category ?? \'Category\' }}</span><span>&bull;</span><span>{{ $proj->year ?? \'Year\' }}</span></div>
              <h3>{{ $proj->title }}</h3>
              <p>{{ $proj->challenge ?? $proj->description ?? \'\' }}</p>
              <a class="tlink green mt-s" href="{{ route(\'case-study\', $proj->id) }}">Read case study</a>
            </div>
          </article>
          @endforeach
      @endif
    </div>
  </div>
</div>';

$content = preg_replace($oldWork, $newWork, $content);

file_put_contents($file, $content);
echo "Replaced content successfully.\n";
