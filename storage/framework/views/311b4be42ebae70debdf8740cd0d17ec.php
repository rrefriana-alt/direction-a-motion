<div class="stat-card" data-id="<?php echo e($stat->id); ?>" draggable="true">
    <span class="stat-num"><?php echo e(str_pad($index + 1, 2, '0', STR_PAD_LEFT)); ?></span>
    <div class="stat-info">
        <div class="stat-name"><?php echo e($stat->label); ?></div>
        <div class="stat-value">
            <span class="stat-badge on" style="font-size:.7rem">Value: <?php echo e($stat->value); ?></span>
            <?php if($stat->suffix): ?>
                <span class="stat-suffix"><?php echo e($stat->suffix); ?></span>
            <?php endif; ?>
        </div>
    </div>
    <span class="stat-badge off" x-show="!stat.is_active">Off</span>
    <div class="stat-acts">
        <div class="svc-toggle" :class="<?php echo e($stat->is_active ? 'on' : ''); ?>" onclick="toggleStat(<?php echo e($stat->id); ?>)"></div>
        <a href="<?php echo e(route('admin.about.statistics.edit', $stat->id)); ?>" class="btn btn-secondary btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
        <form action="<?php echo e(route('admin.about.statistics.destroy', $stat->id)); ?>" method="POST" style="display:inline" onsubmit="return confirm('Delete this statistic?')">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
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
<?php /**PATH D:\Reyhan\Fugo Creative\direction-a-motion(git)\direction-a-motion\resources\views/admin/about/statistics/_stat_card.blade.php ENDPATH**/ ?>