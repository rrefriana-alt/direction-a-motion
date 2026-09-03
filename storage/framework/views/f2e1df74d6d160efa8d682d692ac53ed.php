<div class="svc-card sector-card" data-id="<?php echo e($sector->id); ?>">
    <span class="drag-handle"><i class="bi bi-grip-vertical"></i></span>
    <span class="svc-num"><?php echo e(str_pad($index + 1, 2, '0', STR_PAD_LEFT)); ?></span>
    <div class="svc-info" style="cursor:pointer" x-on:click="toggle(<?php echo e($sector->id); ?>)">
        <div class="svc-label"><?php echo e($sector->heading_en); ?></div>
        <?php if($sector->heading_id): ?>
        <div style="font-size:.75rem;color:var(--gray-500);margin-top:.1rem"><?php echo e($sector->heading_id); ?></div>
        <?php endif; ?>
        <?php if($sector->items && $sector->items->count()): ?>
        <div style="font-size:.7rem;color:var(--gray-400);margin-top:.15rem"><?php echo e($sector->items->count()); ?> item<?php echo e($sector->items->count() > 1 ? 's' : ''); ?></div>
        <?php endif; ?>
    </div>
    <div class="svc-acts">
        <span class="svc-badge <?php echo e($sector->is_active ? 'svc-badge--val' : 'svc-badge--off'); ?>"><?php echo e($sector->is_active ? 'Active' : 'Off'); ?></span>
        <div class="svc-toggle <?php echo e($sector->is_active ? 'on' : ''); ?>" data-toggle-url="<?php echo e(route('admin.about.sectors.toggle', $sector->id)); ?>"></div>
        <a href="<?php echo e(route('admin.about.sectors.edit', $sector->id)); ?>" class="btn btn-secondary btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
        <form action="<?php echo e(route('admin.about.sectors.destroy', $sector->id)); ?>" method="POST" style="display:inline" onsubmit="return confirm('Delete this sector and all its items?')">
            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
            <button type="submit" class="btn btn-danger btn-sm" title="Delete"><i class="bi bi-trash"></i></button>
        </form>
    </div>
</div>

<div x-show="expanded.includes(<?php echo e($sector->id); ?>)" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" style="margin:-.25rem 0 .65rem 3rem;border-left:2px solid var(--gray-200);padding-left:.75rem">
    <?php if($sector->items && $sector->items->count()): ?>
        <?php $__currentLoopData = $sector->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div style="display:flex;align-items:center;gap:.75rem;padding:.5rem .75rem;background:#fff;border:1px solid var(--gray-100);border-radius:var(--radius-md);margin-bottom:.4rem">
            <div style="flex:1;min-width:0">
                <div style="font-size:.8rem;font-weight:500;color:var(--gray-900)"><?php echo e($item->name); ?></div>
                <?php if($item->description): ?>
                <div style="font-size:.7rem;color:var(--gray-500);margin-top:.1rem"><?php echo e(Str::limit($item->description, 60)); ?></div>
                <?php endif; ?>
            </div>
            <?php if($item->icon): ?>
            <span style="font-size:.75rem;color:var(--gray-400)"><i class="bi <?php echo e($item->icon); ?>"></i></span>
            <?php endif; ?>
            <span class="svc-badge <?php echo e($item->is_active ? 'svc-badge--val' : 'svc-badge--off'); ?>" style="font-size:.6rem"><?php echo e($item->is_active ? 'On' : 'Off'); ?></span>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <div style="padding:1rem;text-align:center;font-size:.78rem;color:var(--gray-400)">
            <i class="bi bi-inbox" style="display:block;font-size:1.1rem;margin-bottom:.25rem"></i>
            No items yet. Add items via edit form.
        </div>
    <?php endif; ?>
</div>
<?php /**PATH D:\Reyhan\Fugo Creative\direction-a-motion(git)\direction-a-motion\resources\views/admin/about/sectors/_sector_card.blade.php ENDPATH**/ ?>