<div class="stat-card" data-id="{{ $stat->id }}" draggable="true">
    <span class="stat-num">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
    <div class="stat-info">
        <div class="stat-name">{{ $stat->label }}</div>
        <div class="stat-value">
            <span class="stat-badge on" style="font-size:.7rem">Value: {{ $stat->value }}</span>
            @if($stat->suffix)
                <span class="stat-suffix">{{ $stat->suffix }}</span>
            @endif
        </div>
    </div>
    <span class="stat-badge off" x-show="!stat.is_active">Off</span>
    <div class="stat-acts">
        <div class="svc-toggle" :class="{{ $stat->is_active ? 'on' : '' }}" onclick="toggleStat({{ $stat->id }})"></div>
        <a href="{{ route('admin.about.statistics.edit', $stat->id) }}" class="btn btn-secondary btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
        <form action="{{ route('admin.about.statistics.destroy', $stat->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this statistic?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm" title="Delete"><i class="bi bi-trash"></i></button>
        </form>
    </div>
</div>

<script>
function toggleStat(id) {
    fetch('/admin/about/statistics/' + id + '/toggle', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}
</script>
