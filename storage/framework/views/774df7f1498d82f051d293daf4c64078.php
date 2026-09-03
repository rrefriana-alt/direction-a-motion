<?php $__env->startSection('title', 'Edit Sector'); ?>
<?php $__env->startSection('page-title', 'Edit Sector'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.about.sectors.index')); ?>">Sectors</a></li>
    <li class="breadcrumb-item active">Edit</li>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .fg{display:flex;flex-direction:column;gap:.25rem;margin-bottom:1rem;}
    .fg-label{font-size:.75rem;font-weight:600;color:var(--gray-700);}
    .fg-input{border:1px solid var(--gray-300);border-radius:var(--radius-md);padding:.5rem .75rem;font-size:.8rem;color:var(--gray-900);transition:all .2s;}
    .fg-input:focus{border-color:var(--green-500);box-shadow:0 0 0 3px rgba(16,185,129,.1);outline:none;}
    textarea.fg-input{resize:vertical;min-height:60px;}
    .fl-2{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
    .svc-toggle{position:relative;width:36px;height:20px;background:var(--gray-200);border-radius:10px;cursor:pointer;transition:background .2s;flex-shrink:0;}
    .svc-toggle.on{background:var(--green-500);}
    .svc-toggle::after{content:'';position:absolute;top:2px;left:2px;width:16px;height:16px;background:#fff;border-radius:50%;transition:transform .2s;box-shadow:0 1px 3px rgba(0,0,0,.15);}
    .svc-toggle.on::after{transform:translateX(16px);}
    .item-row{background:#fff;border:1px solid var(--gray-200);border-radius:var(--radius-md);padding:1rem;margin-bottom:.75rem;position:relative;}
    .remove-item{position:absolute;top:.5rem;right:.5rem;cursor:pointer;color:var(--danger);font-size:1rem;}
    #alertContainer{position:fixed;top:1rem;right:1rem;z-index:9999;display:flex;flex-direction:column;gap:.5rem;}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div id="alertContainer"></div>

<form action="<?php echo e(route('admin.about.sectors.update', $sector->id)); ?>" method="POST" id="sectorForm">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div class="card mb-4">
        <div class="card-header">
            <h3 style="margin:0"><i class="bi bi-pencil"></i> Edit Sector</h3>
        </div>
        <div class="card-body">
            <div class="fl-2">
                <div class="fg">
                    <label class="fg-label">Heading EN <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="heading_en" class="fg-input" required value="<?php echo e($sector->heading_en); ?>">
                </div>
                <div class="fg">
                    <label class="fg-label">Heading ID <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="heading_id" class="fg-input" required value="<?php echo e($sector->heading_id); ?>">
                </div>
            </div>

            <div class="fl-2">
                <div class="fg">
                    <label class="fg-label">Sort Order</label>
                    <input type="number" name="sort_order" class="fg-input" min="0" value="<?php echo e($sector->sort_order); ?>">
                </div>
                <div class="fg">
                    <label class="fg-label">Status</label>
                    <div style="display:flex;align-items:center;gap:.5rem;">
                        <div class="svc-toggle <?php echo e($sector->is_active ? 'on' : ''); ?>" id="toggleStatus"></div>
                        <span style="font-size:.75rem;color:var(--gray-600)" id="statusText"><?php echo e($sector->is_active ? 'Active' : 'Inactive'); ?></span>
                    </div>
                    <input type="hidden" name="is_active" value="<?php echo e($sector->is_active ? '1' : '0'); ?>" id="statusInput">
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 style="margin:0"><i class="bi bi-box-seam"></i> Sector Items (<?php echo e($sector->items->count() ?? 0); ?>)</h3>
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addItemRow()">
                <i class="bi bi-plus"></i> Add Item
            </button>
        </div>
        <div class="card-body" id="itemsContainer">
            <?php if($sector->items && $sector->items->count()): ?>
                <?php $__currentLoopData = $sector->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="item-row" data-item-id="<?php echo e($item->id); ?>">
                    <input type="hidden" name="items[<?php echo e($idx); ?>][id]" value="<?php echo e($item->id); ?>">
                    <div class="fl-2">
                        <div class="fg">
                            <label class="fg-label">Item Name</label>
                            <input type="text" name="items[<?php echo e($idx); ?>][item_name]" class="fg-input" value="<?php echo e($item->item_name); ?>">
                        </div>
                        <div class="fg">
                            <label class="fg-label">Icon (Bootstrap)</label>
                            <input type="text" name="items[<?php echo e($idx); ?>][icon]" class="fg-input" placeholder="bi-circle" value="<?php echo e($item->icon ?? ''); ?>">
                        </div>
                    </div>
                    <div class="fg">
                        <label class="fg-label">Description</label>
                        <input type="text" name="items[<?php echo e($idx); ?>][description]" class="fg-input" placeholder="Optional description..." value="<?php echo e($item->description ?? ''); ?>">
                    </div>
                    <div class="fl-2">
                        <div class="fg">
                            <label class="fg-label">Sort Order</label>
                            <input type="number" name="items[<?php echo e($idx); ?>][sort_order]" class="fg-input" min="0" value="<?php echo e($item->sort_order); ?>">
                        </div>
                        <div class="fg">
                            <label class="fg-label">Status</label>
                            <div style="display:flex;align-items:center;gap:.5rem;">
                                <div class="svc-toggle <?php echo e($item->is_active ? 'on' : ''); ?>"></div>
                                <span style="font-size:.75rem;color:var(--gray-600)"><?php echo e($item->is_active ? 'Active' : 'Inactive'); ?></span>
                            </div>
                            <input type="hidden" name="items[<?php echo e($idx); ?>][is_active]" value="<?php echo e($item->is_active ? '1' : '0'); ?>">
                        </div>
                    </div>
                    <button type="button" class="remove-item" onclick="removeItemRow(this)" title="Remove item">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="svc-empty">
                    <i class="bi bi-inbox"></i>
                    <div>No items yet. Click "Add Item" to create one.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div style="display:flex;gap:.75rem;justify-content:flex-end;">
        <a href="<?php echo e(route('admin.about.sectors.index')); ?>" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Update Sector</button>
    </div>
</form>

<script>
let itemCount = <?php echo e($sector->items->count() ?? 0); ?>;

function addItemRow() {
    const container = document.getElementById('itemsContainer');
    const newRow = document.createElement('div');
    newRow.className = 'item-row';
    newRow.innerHTML = `
        <input type="hidden" name="items[${itemCount}][id]" value="">
        <div class="fl-2">
            <div class="fg">
                <label class="fg-label">Item Name</label>
                <input type="text" name="items[${itemCount}][item_name]" class="fg-input">
            </div>
            <div class="fg">
                <label class="fg-label">Icon (Bootstrap)</label>
                <input type="text" name="items[${itemCount}][icon]" class="fg-input" placeholder="bi-circle">
            </div>
        </div>
        <div class="fg">
            <label class="fg-label">Description</label>
            <input type="text" name="items[${itemCount}][description]" class="fg-input" placeholder="Optional description...">
        </div>
        <div class="fl-2">
            <div class="fg">
                <label class="fg-label">Sort Order</label>
                <input type="number" name="items[${itemCount}][sort_order]" class="fg-input" min="0">
            </div>
            <div class="fg">
                <label class="fg-label">Status</label>
                <div style="display:flex;align-items:center;gap:.5rem;">
                    <div class="svc-toggle on"></div>
                    <span style="font-size:.75rem;color:var(--gray-600)">Active</span>
                </div>
                <input type="hidden" name="items[${itemCount}][is_active]" value="1">
            </div>
        </div>
        <button type="button" class="remove-item" onclick="removeItemRow(this)" title="Remove item">
            <i class="bi bi-x-lg"></i>
        </button>
    `;
    container.appendChild(newRow);
    itemCount++;
}

function removeItemRow(btn) {
    btn.closest('.item-row').remove();
}

document.getElementById('toggleStatus').addEventListener('click', function() {
    this.classList.toggle('on');
    const isActive = this.classList.contains('on');
    document.getElementById('statusInput').value = isActive ? '1' : '0';
    document.getElementById('statusText').textContent = isActive ? 'Active' : 'Inactive';
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Reyhan\Fugo Creative\direction-a-motion(git)\direction-a-motion\resources\views/admin/about/sectors/edit.blade.php ENDPATH**/ ?>