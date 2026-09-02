@if ($paginator->hasPages())
<nav class="d-flex align-items-center justify-content-between" style="flex-wrap:wrap;gap:.5rem">
    <div style="font-size:.73rem;color:var(--gray-400)">
        Showing {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} of {{ $paginator->total() }} results
    </div>
    <ul class="pagination pagination-sm" style="margin:0;gap:.2rem">
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link" style="padding:.25rem .55rem;font-size:.73rem;border-radius:6px;border:1px solid var(--gray-200);color:var(--gray-400);background:var(--gray-50)">‹</span></li>
        @else
            <li class="page-item"><a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="page-link" style="padding:.25rem .55rem;font-size:.73rem;border-radius:6px;border:1px solid var(--gray-200);color:var(--gray-700);background:#fff;text-decoration:none">‹</a></li>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled"><span class="page-link" style="padding:.25rem .55rem;font-size:.73rem;border-radius:6px;border:1px solid var(--gray-200);color:var(--gray-400);background:var(--gray-50)">{{ $element }}</span></li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><span class="page-link" style="padding:.25rem .55rem;font-size:.73rem;border-radius:6px;border:1px solid #10b981;background:#10b981;color:#fff;font-weight:600">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a href="{{ $url }}" class="page-link" style="padding:.25rem .55rem;font-size:.73rem;border-radius:6px;border:1px solid var(--gray-200);color:var(--gray-700);background:#fff;text-decoration:none">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <li class="page-item"><a href="{{ $paginator->nextPageUrl() }}" rel="next" class="page-link" style="padding:.25rem .55rem;font-size:.73rem;border-radius:6px;border:1px solid var(--gray-200);color:var(--gray-700);background:#fff;text-decoration:none">›</a></li>
        @else
            <li class="page-item disabled"><span class="page-link" style="padding:.25rem .55rem;font-size:.73rem;border-radius:6px;border:1px solid var(--gray-200);color:var(--gray-400);background:var(--gray-50)">›</span></li>
        @endif
    </ul>
</nav>
@endif
