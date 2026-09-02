<div class="sector-card" data-id="{{ $sector->id }}">
    <div class="sector-hdr" @click="toggleSector({{ $sector->id }})" style="display:flex;align-items:center;">
        <span class="svc-chevron" :class="expanded.includes({{ $sector->id }}) ? 'open' : ''"><i class="bi bi-chevron-right"></i></span>
        <span class="sector-num">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
        <div class="sector-info">
            <div class="sector-name">{{ $sector->heading_en }}</div>
            @if($sector->heading_id)
                <div class="sector-desc">{{ $sector->heading_id }}</div>
            @endif
        </div>
        <span class="sector-badge {{ $sector->is_active ? 'on' : 'off' }}">{{ $sector->is_active ? 'Active' : 'Inactive' }}</span>
        <div class="sector-acts" @click.stop>
            <div class="svc-toggle" :class="{{ $sector->is_active ? 'on' : '' }}" @click="toggleSector({{ $sector->id }})"></div>
            <a href="{{ route('admin.about.sectors.edit', $sector->id) }}" class="btn btn-secondary btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
            <form action="{{ route('admin.about.sectors.destroy', $sector->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this sector and all its items?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" title="Delete"><i class="bi bi-trash"></i></button>
            </form>
        </div>
    </div>

    <div class="sector-body" x-show="expanded.includes({{ $sector->id }})">
        <template x-if="true">
            <div>
                @if($sector->items && $sector->items->count())
                    @foreach($sector->items as $item)
                    <div class="sector-item">
                        <div style="flex:1">
                            <div style="font-size:.8rem;font-weight:500;color:var(--gray-900)">{{ $item->item_name }}</div>
                            @if($item->description)
                                <div class="sector-item-desc">{{ $item->description }}</div>
                            @endif
                        </div>
                        <span class="sector-badge {{ $item->is_active ? 'on' : 'off' }}" style="font-size:.6rem">{{ $item->is_active ? 'Active' : 'Inactive' }}</span>
                        <div class="sector-acts" @click.stop>
                            <a href="{{ route('admin.about.sectors.edit', $sector->id) }}" class="btn btn-secondary btn-sm" title="Edit Item"><i class="bi bi-pencil"></i></a>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="svc-empty">
                        <i class="bi bi-inbox"></i>
                        <div>No items yet. Add items in edit form.</div>
                    </div>
                @endif
            </div>
        </template>
    </div>
</div>
