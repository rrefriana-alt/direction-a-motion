<div class="svc-card sector-card" data-id="{{ $sector->id }}">
    <span class="drag-handle"><i class="bi bi-grip-vertical"></i></span>
    <span class="svc-num">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
    <div class="svc-info" style="cursor:pointer" x-on:click="toggle({{ $sector->id }})">
        <div class="svc-label">{{ $sector->heading_en }}</div>
        @if($sector->heading_id)
        <div style="font-size:.75rem;color:var(--gray-500);margin-top:.1rem">{{ $sector->heading_id }}</div>
        @endif
        @if($sector->items && $sector->items->count())
        <div style="font-size:.7rem;color:var(--gray-400);margin-top:.15rem">{{ $sector->items->count() }} item{{ $sector->items->count() > 1 ? 's' : '' }}</div>
        @endif
    </div>
    <div class="svc-acts">
        <span class="svc-badge {{ $sector->is_active ? 'svc-badge--val' : 'svc-badge--off' }}">{{ $sector->is_active ? 'Active' : 'Off' }}</span>
        <div class="svc-toggle {{ $sector->is_active ? 'on' : '' }}" data-toggle-url="{{ route('admin.about.sectors.toggle', $sector->id) }}"></div>
        <a href="{{ route('admin.about.sectors.edit', $sector->id) }}" class="btn btn-secondary btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
        <form action="{{ route('admin.about.sectors.destroy', $sector->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this sector and all its items?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm" title="Delete"><i class="bi bi-trash"></i></button>
        </form>
    </div>
</div>

<div x-show="expanded.includes({{ $sector->id }})" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" style="margin:-.25rem 0 .65rem 3rem;border-left:2px solid var(--gray-200);padding-left:.75rem">
    @if($sector->items && $sector->items->count())
        @foreach($sector->items as $item)
        <div style="display:flex;align-items:center;gap:.75rem;padding:.5rem .75rem;background:#fff;border:1px solid var(--gray-100);border-radius:var(--radius-md);margin-bottom:.4rem">
            <div style="flex:1;min-width:0">
                <div style="font-size:.8rem;font-weight:500;color:var(--gray-900)">{{ $item->name }}</div>
                @if($item->description)
                <div style="font-size:.7rem;color:var(--gray-500);margin-top:.1rem">{{ Str::limit($item->description, 60) }}</div>
                @endif
            </div>
            @if($item->icon)
            <span style="font-size:.75rem;color:var(--gray-400)"><i class="bi {{ $item->icon }}"></i></span>
            @endif
            <span class="svc-badge {{ $item->is_active ? 'svc-badge--val' : 'svc-badge--off' }}" style="font-size:.6rem">{{ $item->is_active ? 'On' : 'Off' }}</span>
        </div>
        @endforeach
    @else
        <div style="padding:1rem;text-align:center;font-size:.78rem;color:var(--gray-400)">
            <i class="bi bi-inbox" style="display:block;font-size:1.1rem;margin-bottom:.25rem"></i>
            No items yet. Add items via edit form.
        </div>
    @endif
</div>
