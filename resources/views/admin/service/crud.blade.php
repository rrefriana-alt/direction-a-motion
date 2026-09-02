@extends('admin.layouts.app')
@section('title', 'Service Management')
@section('page-title', 'Service Management')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.services.index') }}">Services</a></li>
    <li class="breadcrumb-item active">Manage Services</li>
@endsection

@push('styles')
<style>
    .svc{display:flex;flex-direction:column;gap:1rem;}
    .svc-card{background:#fff;border:1px solid var(--gray-200);border-radius:var(--radius-lg);overflow:hidden;transition:box-shadow .2s;}
    .svc-card:hover{box-shadow:var(--shadow-sm);}
    .svc-hdr{padding:1rem 1.25rem;display:flex;align-items:center;gap:.75rem;cursor:pointer;user-select:none;transition:background .15s;}
    .svc-hdr:hover{background:var(--gray-50);}
    .svc-body{padding:0 1.25rem 1.25rem;border-top:1px solid var(--gray-100);}
    .svc-num{font-family:var(--f-mono,monospace);font-size:1.1rem;font-weight:700;color:var(--green-500);width:32px;text-align:center;flex-shrink:0;}
    .svc-info{flex:1;min-width:0;}
    .svc-name{font-size:.9rem;font-weight:600;color:var(--gray-900);}
    .svc-desc{font-size:.75rem;color:var(--gray-500);margin-top:.125rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
    .svc-badge{display:inline-flex;align-items:center;gap:.25rem;font-size:.65rem;font-weight:600;padding:.15rem .5rem;border-radius:99px;line-height:1.2;}
    .svc-badge.on{background:var(--green-50);color:var(--green-700);}
    .svc-badge.off{background:var(--gray-100);color:var(--gray-400);}
    .svc-acts{display:flex;gap:.3rem;flex-shrink:0;}
    .svc-chevron{transition:transform .2s;font-size:.75rem;color:var(--gray-400);}
    .svc-chevron.open{transform:rotate(90deg);}
    .svc-det{background:var(--gray-50);border:1px solid var(--gray-100);border-radius:var(--radius-md);padding:.75rem 1rem;margin-top:.75rem;}
    .svc-det-hdr{display:flex;align-items:center;gap:.5rem;}
    .svc-det-info{flex:1;min-width:0;}
    .svc-det-name{font-size:.85rem;font-weight:600;color:var(--gray-900);}
    .svc-det-content{font-size:.7rem;color:var(--gray-500);margin-top:.125rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
    .svc-item{display:flex;align-items:center;gap:.75rem;padding:.5rem .75rem;background:#fff;border:1px solid var(--gray-100);border-radius:var(--radius-sm);margin-top:.5rem;transition:background .15s;}
    .svc-item:hover{background:var(--gray-50);}
    .svc-thumb{width:36px;height:36px;border-radius:var(--radius-sm);object-fit:cover;background:var(--gray-100);flex-shrink:0;}
    .svc-thumb-empty{width:36px;height:36px;border-radius:var(--radius-sm);background:var(--gray-100);flex-shrink:0;display:flex;align-items:center;justify-content:center;color:var(--gray-300);font-size:.8rem;}
    .svc-form{margin-top:.75rem;padding:1rem;background:#fff;border:1px solid var(--gray-200);border-radius:var(--radius-md);}
    .svc-form-title{font-size:.8rem;font-weight:600;color:var(--gray-700);margin-bottom:.75rem;padding-bottom:.5rem;border-bottom:1px solid var(--gray-100);}
    .svc-toggle{position:relative;width:36px;height:20px;background:var(--gray-200);border-radius:10px;cursor:pointer;transition:background .2s;flex-shrink:0;}
    .svc-toggle.on{background:var(--green-500);}
    .svc-toggle::after{content:'';position:absolute;top:2px;left:2px;width:16px;height:16px;background:#fff;border-radius:50%;transition:transform .2s;box-shadow:0 1px 3px rgba(0,0,0,.15);}
    .svc-toggle.on::after{transform:translateX(16px);}
    .svc-img{width:44px;height:44px;border-radius:var(--radius-sm);object-fit:cover;border:1px solid var(--gray-100);}
    .svc-empty{text-align:center;padding:2rem;color:var(--gray-400);font-size:.8rem;}
    .svc-empty i{font-size:1.5rem;display:block;margin-bottom:.5rem;}
.svc-drag-handle{cursor:grab;color:var(--gray-300);font-size:.75rem;padding:.25rem;transition:color .15s;display:flex;align-items:center;}
.svc-drag-handle:hover{color:var(--gray-600);}
.svc-det.dragging,.svc-item.dragging{opacity:.8;}
.svc-det.drag-over{border-color:var(--green-400);background:var(--green-50);outline:2px dashed var(--green-400);}
.svc-item.drag-over{border-color:var(--green-400);background:var(--green-50);outline:2px dashed var(--green-400);}
    .svc-add-row{margin-top:.75rem;padding:.75rem;border:1px dashed var(--gray-200);border-radius:var(--radius-md);text-align:center;font-size:.75rem;color:var(--gray-400);cursor:pointer;transition:all .15s;}
    .svc-add-row:hover{border-color:var(--green-400);color:var(--green-600);background:var(--green-50);}
    #alertContainer{position:fixed;top:1rem;right:1rem;z-index:9999;display:flex;flex-direction:column;gap:.5rem;}
    .fl{display:grid;gap:.75rem;}
    .fl-2{grid-template-columns:1fr 1fr;}
    .fl-3{grid-template-columns:1fr 1fr 1fr;}
    .fg{display:flex;flex-direction:column;gap:.25rem;}
    .fg-label{font-size:.75rem;font-weight:600;color:var(--gray-700);}
    .fg-input{border:1px solid var(--gray-300);border-radius:var(--radius-md);padding:.5rem .75rem;font-size:.8rem;color:var(--gray-900);transition:all .2s;}
    .fg-input:focus{border-color:var(--green-500);box-shadow:0 0 0 3px rgba(16,185,129,.1);outline:none;}
    .fg-input::placeholder{color:var(--gray-400);}
    textarea.fg-input{resize:vertical;min-height:60px;}
    .svc-acts-row{display:flex;gap:.5rem;margin-top:1rem;justify-content:flex-end;}
</style>
@endpush

@section('content')
<div id="alertContainer"></div>

<div x-data="serviceCrud()" x-init="init()">

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2 style="margin:0">Service Management</h2>
        <p style="margin:0;color:var(--gray-500);font-size:.8125rem">Manage categories, details, and items for the services page.</p>
    </div>
    <button class="btn btn-primary" @click="showAddCategory = true" x-show="!showAddCategory">
        <i class="bi bi-plus-lg"></i> Add Category
    </button>
</div>

{{-- ═══ NEW CATEGORY FORM ═══ --}}
<div class="svc-card" x-show="showAddCategory" x-transition style="border-color:var(--green-400);">
    <div style="padding:1rem 1.25rem;background:var(--green-50);border-bottom:1px solid var(--green-100);">
        <span style="font-size:.875rem;font-weight:600;color:var(--green-700)"><i class="bi bi-plus-circle"></i> New Category</span>
    </div>
    <div style="padding:1.25rem;">
        <div class="fl fl-2">
            <div class="fg">
                <label class="fg-label">Name <span style="color:var(--danger)">*</span></label>
                <input type="text" class="fg-input" x-model="catForm.name" required placeholder="e.g. Fugo Design">
            </div>
            <div class="fg">
                <label class="fg-label">Slug <span style="color:var(--danger)">*</span></label>
                <input type="text" class="fg-input" x-model="catForm.slug" required placeholder="fugo-design">
            </div>
        </div>
        <div class="fl fl-2" style="margin-top:.75rem;">
            <div class="fg">
                <label class="fg-label">Display Title <span style="color:var(--danger)">*</span></label>
                <input type="text" class="fg-input" x-model="catForm.title" required placeholder="e.g. Design & Branding">
            </div>
            <div class="fg">
                <label class="fg-label">Icon (Bootstrap)</label>
                <input type="text" class="fg-input" x-model="catForm.icon" placeholder="e.g. bi-palette">
            </div>
        </div>
        <div class="fg" style="margin-top:.75rem;">
            <label class="fg-label">Description <span style="color:var(--danger)">*</span></label>
            <textarea class="fg-input" x-model="catForm.description" rows="2" required placeholder="Short description for this category"></textarea>
        </div>
        <div class="fl fl-2" style="margin-top:.75rem;">
            <div class="fg">
                <label class="fg-label">Sort Order</label>
                <input type="number" class="fg-input" x-model.number="catForm.sort_order" min="0">
            </div>
            <div class="fg">
                <label class="fg-label">Status</label>
                <div style="display:flex;align-items:center;gap:.5rem;">
                    <div class="svc-toggle" :class="catForm.is_active ? 'on' : ''" @click="catForm.is_active = !catForm.is_active"></div>
                    <span style="font-size:.75rem;color:var(--gray-600)" x-text="catForm.is_active ? 'Active' : 'Inactive'"></span>
                </div>
            </div>
        </div>
        <div class="svc-acts-row">
            <button type="button" class="btn btn-secondary btn-sm" @click="showAddCategory = false">Cancel</button>
            <button type="button" class="btn btn-primary btn-sm" @click="storeCategory()" :disabled="loading">
                <span x-show="!loading"><i class="bi bi-check-lg"></i> Save Category</span>
                <span x-show="loading">Saving...</span>
            </button>
        </div>
    </div>
</div>

{{-- ═══ CATEGORY LIST ═══ --}}
<template x-for="(cat, ci) in categories" :key="cat.id">
<div class="svc-card">
    <div class="svc-hdr" @click="toggleCategory(cat.id)">
        <span class="svc-chevron" :class="expanded.includes(cat.id) ? 'open' : ''"><i class="bi bi-chevron-right"></i></span>
        <span class="svc-num" x-text="String(ci + 1).padStart(2, '0')"></span>
        <div class="svc-info">
            <div class="svc-name" x-text="cat.name"></div>
            <div class="svc-desc" x-text="cat.description"></div>
        </div>
        <span class="svc-badge" :class="cat.is_active ? 'on' : 'off'" x-text="cat.is_active ? 'Active' : 'Inactive'"></span>
        <div class="svc-acts" @click.stop>
            <button class="btn btn-secondary btn-sm" @click="editCategory(cat); if(!expanded.includes(cat.id)) expanded.push(cat.id)" title="Edit"><i class="bi bi-pencil"></i></button>
            <button class="btn btn-danger btn-sm" @click="deleteCategory(cat.id)" title="Delete"><i class="bi bi-trash"></i></button>
            <button class="btn btn-primary btn-sm" @click="showAddDetailFor = showAddDetailFor === cat.id ? null : cat.id; if(!expanded.includes(cat.id)) expanded.push(cat.id)" title="Add Detail"><i class="bi bi-plus"></i></button>
        </div>
    </div>

    <div class="svc-body" x-show="expanded.includes(cat.id)" x-transition.duration.200ms>

        {{-- Edit Category Form --}}
        <div x-show="editingCatId === cat.id" class="svc-form">
            <div class="svc-form-title"><i class="bi bi-pencil"></i> Edit Category</div>
            <div class="fl fl-2">
                <div class="fg">
                    <label class="fg-label">Name</label>
                    <input type="text" class="fg-input" x-model="editCatForm.name" required>
                </div>
                <div class="fg">
                    <label class="fg-label">Slug</label>
                    <input type="text" class="fg-input" x-model="editCatForm.slug" required>
                </div>
            </div>
            <div class="fl fl-2" style="margin-top:.75rem;">
                <div class="fg">
                    <label class="fg-label">Display Title</label>
                    <input type="text" class="fg-input" x-model="editCatForm.title" required>
                </div>
                <div class="fg">
                    <label class="fg-label">Icon</label>
                    <input type="text" class="fg-input" x-model="editCatForm.icon" placeholder="bi-palette">
                </div>
            </div>
            <div class="fg" style="margin-top:.75rem;">
                <label class="fg-label">Description</label>
                <textarea class="fg-input" x-model="editCatForm.description" rows="2" required></textarea>
            </div>
            <div class="fl fl-2" style="margin-top:.75rem;">
                <div class="fg">
                    <label class="fg-label">Sort Order</label>
                    <input type="number" class="fg-input" x-model.number="editCatForm.sort_order" min="0">
                </div>
                <div class="fg">
                    <label class="fg-label">Status</label>
                    <div style="display:flex;align-items:center;gap:.5rem;">
                        <div class="svc-toggle" :class="editCatForm.is_active ? 'on' : ''" @click="editCatForm.is_active = !editCatForm.is_active"></div>
                        <span style="font-size:.75rem;color:var(--gray-600)" x-text="editCatForm.is_active ? 'Active' : 'Inactive'"></span>
                    </div>
                </div>
            </div>
            <div class="svc-acts-row">
                <button type="button" class="btn btn-secondary btn-sm" @click="editingCatId = null">Cancel</button>
                <button type="button" class="btn btn-primary btn-sm" @click="updateCategory(cat.id)">Update Category</button>
            </div>
        </div>

        {{-- Add Detail Form --}}
        <div x-show="showAddDetailFor === cat.id" class="svc-form">
            <div class="svc-form-title"><i class="bi bi-plus-circle"></i> New Detail</div>
            <div class="fl fl-2">
                <div class="fg">
                    <label class="fg-label">Detail Name <span style="color:var(--danger)">*</span></label>
                    <input type="text" class="fg-input" x-model="detailForm.category_name" required placeholder="e.g. Creative Campaign (POSM)">
                </div>
                <div class="fg">
                    <label class="fg-label">Sort Order</label>
                    <input type="number" class="fg-input" x-model.number="detailForm.sort_order" min="0">
                </div>
            </div>
            <div class="fg" style="margin-top:.75rem;">
                <label class="fg-label">Content / Description</label>
                <textarea class="fg-input" x-model="detailForm.content" rows="2" placeholder="Poster, flyer, banner, billboard..."></textarea>
            </div>
            <div style="margin-top:.75rem;">
                <label class="fg-label">Status</label>
                <div style="display:flex;align-items:center;gap:.5rem;">
                    <div class="svc-toggle" :class="detailForm.is_active ? 'on' : ''" @click="detailForm.is_active = !detailForm.is_active"></div>
                    <span style="font-size:.75rem;color:var(--gray-600)" x-text="detailForm.is_active ? 'Active' : 'Inactive'"></span>
                </div>
            </div>
            <div class="svc-acts-row">
                <button type="button" class="btn btn-secondary btn-sm" @click="showAddDetailFor = null">Cancel</button>
                <button type="button" class="btn btn-primary btn-sm" @click="storeDetail(cat.id)">Save Detail</button>
            </div>
        </div>

        {{-- Detail List --}}
        <template x-for="(detail, di) in cat.all_details" :key="detail.id">
        <div class="svc-det" draggable="true" @dragstart="dragDetail($event, detail, cat.id)" @dragover.prevent="$event.currentTarget.classList.add('drag-over')" @dragleave="$event.currentTarget.classList.remove('drag-over')" @drop="dropDetail($event, cat, di)" @dragend="$event.currentTarget.classList.remove('drag-over'); $event.currentTarget.classList.remove('dragging')" :class="dragOverDetail === di ? 'drag-over' : ''">
            <div class="svc-det-hdr"><div class="svc-drag-handle" title="Drag to reorder"><i class="bi bi-grip-vertical"></i></div>
                <div class="svc-det-info">
                    <div style="display:flex;align-items:center;gap:.5rem;">
                        <span class="svc-det-name" x-text="detail.category_name"></span>
                        <span class="svc-badge off" x-show="!detail.is_active" style="font-size:.6rem">Off</span>
                    </div>
                    <div class="svc-det-content" x-show="detail.content" x-text="detail.content"></div>
                </div>
                <div class="svc-acts" @click.stop>
                    <button class="btn btn-secondary btn-sm" @click="editDetail(detail); if(!expanded.includes(cat.id)) expanded.push(cat.id)" title="Edit"><i class="bi bi-pencil"></i></button>
                    <button class="btn btn-danger btn-sm" @click="deleteDetail(detail.id)" title="Delete"><i class="bi bi-trash"></i></button>
                    <button class="btn btn-primary btn-sm" @click="showAddItemFor = showAddItemFor === detail.id ? null : detail.id; if(!expanded.includes(cat.id)) expanded.push(cat.id)" title="Add Item"><i class="bi bi-plus"></i></button>
                </div>
            </div>

            {{-- Edit Detail Form --}}
            <div x-show="editingDetailId === detail.id" class="svc-form" style="margin-top:.5rem;">
                <div class="svc-form-title"><i class="bi bi-pencil"></i> Edit Detail</div>
                <div class="fl fl-2">
                    <div class="fg">
                        <label class="fg-label">Detail Name</label>
                        <input type="text" class="fg-input" x-model="editDetailForm.category_name" required>
                    </div>
                    <div class="fg">
                        <label class="fg-label">Sort Order</label>
                        <input type="number" class="fg-input" x-model.number="editDetailForm.sort_order" min="0">
                    </div>
                </div>
                <div class="fg" style="margin-top:.75rem;">
                    <label class="fg-label">Content</label>
                    <textarea class="fg-input" x-model="editDetailForm.content" rows="2"></textarea>
                </div>
                <div style="margin-top:.75rem;">
                    <div style="display:flex;align-items:center;gap:.5rem;">
                        <div class="svc-toggle" :class="editDetailForm.is_active ? 'on' : ''" @click="editDetailForm.is_active = !editDetailForm.is_active"></div>
                        <span style="font-size:.75rem;color:var(--gray-600)" x-text="editDetailForm.is_active ? 'Active' : 'Inactive'"></span>
                    </div>
                </div>
                <div class="svc-acts-row">
                    <button type="button" class="btn btn-secondary btn-sm" @click="editingDetailId = null">Cancel</button>
                    <button type="button" class="btn btn-primary btn-sm" @click="updateDetail(detail.id)">Update</button>
                </div>
            </div>

            {{-- Add Item Form --}}
            <div x-show="showAddItemFor === detail.id" class="svc-form" style="margin-top:.5rem;">
                <div class="svc-form-title"><i class="bi bi-plus-circle"></i> New Item</div>
                <div class="fl fl-2">
                    <div class="fg">
                        <label class="fg-label">Item Name <span style="color:var(--danger)">*</span></label>
                        <input type="text" class="fg-input" x-model="itemForm.item_name" required placeholder="e.g. Poster">
                    </div>
                    <div class="fg">
                        <label class="fg-label">Sort Order</label>
                        <input type="number" class="fg-input" x-model.number="itemForm.sort_order" min="0">
                    </div>
                </div>
                <div class="fg" style="margin-top:.75rem;">
                    <label class="fg-label">Description</label>
                    <textarea class="fg-input" x-model="itemForm.description" rows="2" placeholder="Optional description..."></textarea>
                </div>
                <div class="fg" style="margin-top:.75rem;">
                    <label class="fg-label">Image</label>
                    <input type="file" class="fg-input" accept="image/*" @change="handleItemImg($event, 'new')" style="padding:.4rem .75rem;">
                    <template x-if="itemForm._preview">
                        <img :src="itemForm._preview" class="svc-img" alt="Preview" style="margin-top:.5rem;">
                    </template>
                </div>
                <div style="margin-top:.75rem;">
                    <div style="display:flex;align-items:center;gap:.5rem;">
                        <div class="svc-toggle" :class="itemForm.is_active ? 'on' : ''" @click="itemForm.is_active = !itemForm.is_active"></div>
                        <span style="font-size:.75rem;color:var(--gray-600)" x-text="itemForm.is_active ? 'Active' : 'Inactive'"></span>
                    </div>
                </div>
                <div class="svc-acts-row">
                    <button type="button" class="btn btn-secondary btn-sm" @click="showAddItemFor = null">Cancel</button>
                    <button type="button" class="btn btn-primary btn-sm" @click="storeItem(detail.id)">Save Item</button>
                </div>
            </div>

            {{-- Item List --}}
            <template x-for="(item, ii) in detail.all_items" :key="item.id">
            <div class="svc-item" draggable="true" @dragstart="dragItem($event, item, detail.id)" @dragover.prevent="$event.currentTarget.classList.add('drag-over')" @dragleave="$event.currentTarget.classList.remove('drag-over')" @drop="dropItem($event, detail, ii)" @dragend="$event.currentTarget.classList.remove('drag-over'); $event.currentTarget.classList.remove('dragging')">
                <template x-if="item.image">
                    <img :src="'/img/' + item.image" class="svc-thumb" :alt="item.item_name">
                </template>
                <template x-if="!item.image">
                    <div class="svc-thumb-empty"><i class="bi bi-image"></i></div>
                </template>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:.8rem;font-weight:500;color:var(--gray-900)" x-text="item.item_name"></div>
                    <div style="font-size:.7rem;color:var(--gray-500)" x-show="item.description" x-text="item.description"></div>
                </div>
                <span class="svc-badge off" x-show="!item.is_active" style="font-size:.6rem">Off</span>
                <div class="svc-acts" @click.stop>
                    <button class="btn btn-secondary btn-sm" @click="editItem(item, detail.id); if(!expanded.includes(detail.service_category_id)) expanded.push(detail.service_category_id)" title="Edit"><i class="bi bi-pencil"></i></button>
                    <button class="btn btn-danger btn-sm" @click="deleteItem(item.id)" title="Delete"><i class="bi bi-trash"></i></button>
                </div>
            </div>
            </template>

            {{-- Edit Item Form --}}
            <div x-show="editingItemDetailId === detail.id" class="svc-form" style="margin-top:.5rem;">
                <div class="svc-form-title"><i class="bi bi-pencil"></i> Edit Item</div>
                <div class="fl fl-2">
                    <div class="fg">
                        <label class="fg-label">Item Name</label>
                        <input type="text" class="fg-input" x-model="editItemForm.item_name" required>
                    </div>
                    <div class="fg">
                        <label class="fg-label">Sort Order</label>
                        <input type="number" class="fg-input" x-model.number="editItemForm.sort_order" min="0">
                    </div>
                </div>
                <div class="fg" style="margin-top:.75rem;">
                    <label class="fg-label">Description</label>
                    <textarea class="fg-input" x-model="editItemForm.description" rows="2"></textarea>
                </div>
                <div class="fg" style="margin-top:.75rem;">
                    <label class="fg-label">Image</label>
                    <input type="file" class="fg-input" accept="image/*" @change="handleItemImg($event, 'edit')" style="padding:.4rem .75rem;">
                    <div style="display:flex;align-items:center;gap:.75rem;margin-top:.5rem;">
                        <template x-if="editItemForm._preview">
                            <img :src="editItemForm._preview" class="svc-img" alt="New">
                        </template>
                        <template x-if="!editItemForm._preview && editItemForm._currentImage">
                            <img :src="'/img/' + editItemForm._currentImage" class="svc-img" alt="Current">
                        </template>
                    </div>
                </div>
                <div class="fg" style="margin-top:.75rem;">
                    <label class="fg-label">Pindah ke Detail</label>
                    <select class="fg-input" x-model="editItemForm.moveDetailId">
                        <option value="">-- Tidak dipindahkan --</option>
                        <template x-for="(cat, mci) in categories" :key="cat.id">
                            <optgroup :label="cat.name">
                                <template x-for="(det, mdi) in cat.all_details" :key="det.id">
                                    <option :value="det.id" x-text="det.category_name" :selected="det.id === editingItemDetailId"></option>
                                </template>
                            </optgroup>
                        </template>
                    </select>
                </div>
                <div style="margin-top:.75rem;">
                    <div style="display:flex;align-items:center;gap:.5rem;">
                        <div class="svc-toggle" :class="editItemForm.is_active ? 'on' : ''" @click="editItemForm.is_active = !editItemForm.is_active"></div>
                        <span style="font-size:.75rem;color:var(--gray-600)" x-text="editItemForm.is_active ? 'Active' : 'Inactive'"></span>
                    </div>
                </div>
                <div class="svc-acts-row">
                    <button type="button" class="btn btn-secondary btn-sm" @click="editingItemId = null; editingItemDetailId = null">Cancel</button>
                    <button type="button" class="btn btn-primary btn-sm" @click="updateItem(editingItemDetailId)">Update Item</button>
                </div>
            </div>
        </div>
        </template>

        <div x-show="cat.all_details && cat.all_details.length === 0" class="svc-empty">
            <i class="bi bi-inbox"></i>
            <div>No details yet. Click <strong>+</strong> to add one.</div>
        </div>
    </div>
</div>
</template>

<div x-show="categories.length === 0" class="svc-card" style="text-align:center;padding:3rem">
    <i class="bi bi-layers" style="font-size:2rem;color:var(--gray-300)"></i>
    <div style="font-size:.9rem;font-weight:500;color:var(--gray-500);margin-top:.5rem">No categories found</div>
    <div style="font-size:.8rem;color:var(--gray-400);margin-top:.25rem">Click <strong>"Add Category"</strong> to create your first service.</div>
</div>

</div>
@endsection

@push('scripts')
<script>
function serviceCrud() {
    return {
        categories: @json($categories, 0),
        expanded: [],
        loading: false,
        showAddCategory: false,
        showAddDetailFor: null,
        showAddItemFor: null,
        editingCatId: null,
        editingDetailId: null,
        editingItemId: null,
        editingItemDetailId: null,
        catForm: { name: '', slug: '', title: '', description: '', icon: '', sort_order: 0, is_active: true },
        editCatForm: { name: '', slug: '', title: '', description: '', icon: '', sort_order: 0, is_active: true },
        detailForm: { category_name: '', content: '', sort_order: 0, is_active: true },
        editDetailForm: { category_name: '', content: '', sort_order: 0, is_active: true },
        itemForm: { item_name: '', description: '', image: null, sort_order: 0, is_active: true, _preview: null },
        editItemForm: { item_name: '', description: '', image: null, sort_order: 0, is_active: true, _preview: null, _currentImage: null, moveDetailId: '' },
        token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        dragOverDetail: null,
        dragOverItem: null,

        init() {
            this.categories.forEach(c => { if (c.all_details && c.all_details.length > 0) this.expanded.push(c.id); });
        },

        toggleCategory(id) {
            const idx = this.expanded.indexOf(id);
            if (idx > -1) this.expanded.splice(idx, 1);
            else this.expanded.push(id);
        },

        showAlert(type, msg) {
            const el = document.createElement('div');
            el.className = 'alert alert-' + type;
            el.style.cssText = 'border-radius:var(--radius-md);font-size:.8125rem;padding:.75rem 1rem;display:flex;align-items:center;gap:.5rem;min-width:280px;box-shadow:var(--shadow-sm);';
            if (type === 'success') { el.style.background = '#dcfce7'; el.style.color = '#166534'; }
            else { el.style.background = '#fef2f2'; el.style.color = '#991b1b'; }
            el.innerHTML = '<i class="bi bi-' + (type === 'success' ? 'check-circle-fill' : 'exclamation-triangle-fill') + '"></i> ' + msg;
            document.getElementById('alertContainer').appendChild(el);
            setTimeout(() => el.remove(), 4000);
        },

        async api(url, method, body) {
            const opts = { method, headers: { 'X-CSRF-TOKEN': this.token, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } };
            if (body) opts.body = body;
            const res = await fetch(url, opts);
            return res.json();
        },

        handleItemImg(e, mode) {
            const file = e.target.files[0];
            if (!file) return;
            const url = URL.createObjectURL(file);
            if (mode === 'new') { this.itemForm.image = file; this.itemForm._preview = url; }
            else { this.editItemForm.image = file; this.editItemForm._preview = url; }
        },

        // ─── Category ───
        async storeCategory() {
            this.loading = true;
            try {
                const fd = new FormData();
                Object.entries(this.catForm).forEach(([k, v]) => { if (k !== '_preview') fd.append(k, v ?? ''); });
                const data = await this.api('/admin/services/categories', 'POST', fd);
                if (data.success) {
                    this.showAlert('success', data.message);
                    if (data.category) this.categories.push(data.category);
                    this.showAddCategory = false;
                    this.catForm = { name: '', slug: '', title: '', description: '', icon: '', sort_order: 0, is_active: true };
                } else this.showAlert('danger', data.message);
            } catch (e) { this.showAlert('danger', e.message); }
            this.loading = false;
        },

        editCategory(cat) {
            this.editingCatId = cat.id;
            this.editCatForm = { name: cat.name, slug: cat.slug, title: cat.title, description: cat.description, icon: cat.icon, sort_order: cat.sort_order || 0, is_active: !!cat.is_active };
        },

        async updateCategory(id) {
            try {
                const fd = new FormData();
                fd.append('_method', 'PUT');
                Object.entries(this.editCatForm).forEach(([k, v]) => fd.append(k, v ?? ''));
                const data = await this.api('/admin/services/categories/' + id, 'POST', fd);
                if (data.success) {
                    this.showAlert('success', data.message);
                    const idx = this.categories.findIndex(c => c.id === id);
                    if (idx > -1 && data.category) this.categories[idx] = data.category;
                    this.editingCatId = null;
                } else this.showAlert('danger', data.message);
            } catch (e) { this.showAlert('danger', e.message); }
        },

        async deleteCategory(id) {
            if (!confirm('Delete this category and ALL its details & items?')) return;
            try {
                const data = await this.api('/admin/services/categories/' + id, 'DELETE');
                if (data.success) { this.showAlert('success', data.message); this.categories = this.categories.filter(c => c.id !== id); }
                else this.showAlert('danger', data.message);
            } catch (e) { this.showAlert('danger', e.message); }
        },

        // ─── Detail ───
        async storeDetail(catId) {
            try {
                const fd = new FormData();
                fd.append('service_category_id', catId);
                Object.entries(this.detailForm).forEach(([k, v]) => fd.append(k, v ?? ''));
                const data = await this.api('/admin/services/details', 'POST', fd);
                if (data.success) {
                    this.showAlert('success', data.message);
                    const idx = this.categories.findIndex(c => c.id === catId);
                    if (idx > -1 && data.detail) {
                        if (!this.categories[idx].all_details) this.categories[idx].all_details = [];
                        this.categories[idx].all_details.push(data.detail);
                    }
                    this.showAddDetailFor = null;
                    this.detailForm = { category_name: '', content: '', sort_order: 0, is_active: true };
                } else this.showAlert('danger', data.message);
            } catch (e) { this.showAlert('danger', e.message); }
        },

        editDetail(detail) {
            this.editingDetailId = detail.id;
            this.editDetailForm = { category_name: detail.category_name, content: detail.content, sort_order: detail.sort_order || 0, is_active: !!detail.is_active };
        },

        async updateDetail(id) {
            try {
                const fd = new FormData();
                fd.append('_method', 'PUT');
                Object.entries(this.editDetailForm).forEach(([k, v]) => fd.append(k, v ?? ''));
                const data = await this.api('/admin/services/details/' + id, 'POST', fd);
                if (data.success) {
                    this.showAlert('success', data.message);
                    this.categories.forEach(c => {
                        if (c.all_details) {
                            const di = c.all_details.findIndex(d => d.id === id);
                            if (di > -1 && data.detail) c.all_details[di] = data.detail;
                        }
                    });
                    this.editingDetailId = null;
                } else this.showAlert('danger', data.message);
            } catch (e) { this.showAlert('danger', e.message); }
        },

        async deleteDetail(id) {
            if (!confirm('Delete this detail and its items?')) return;
            try {
                const data = await this.api('/admin/services/details/' + id, 'DELETE');
                if (data.success) {
                    this.showAlert('success', data.message);
                    this.categories.forEach(c => { if (c.all_details) c.all_details = c.all_details.filter(d => d.id !== id); });
                } else this.showAlert('danger', data.message);
            } catch (e) { this.showAlert('danger', e.message); }
        },

        // ─── Item ───
        async storeItem(detailId) {
            try {
                const fd = new FormData();
                fd.append('service_detail_id', detailId);
                Object.entries(this.itemForm).forEach(([k, v]) => {
                    if (k === '_preview') return;
                    if (k === 'image' && v) fd.append(k, v);
                    else if (k !== 'image') fd.append(k, v ?? '');
                });
                const data = await this.api('/admin/services/items', 'POST', fd);
                if (data.success) {
                    this.showAlert('success', data.message);
                    this.categories.forEach(c => {
                        if (c.all_details) {
                            const d = c.all_details.find(d => d.id === detailId);
                            if (d) { if (!d.all_items) d.all_items = []; if (data.item) d.all_items.push(data.item); }
                        }
                    });
                    this.showAddItemFor = null;
                    this.itemForm = { item_name: '', description: '', image: null, sort_order: 0, is_active: true, _preview: null };
                } else this.showAlert('danger', data.message);
            } catch (e) { this.showAlert('danger', e.message); }
        },

        editItem(item, detailId) {
            this.editingItemId = item.id;
            this.editingItemDetailId = detailId;
            this.editItemForm = { item_name: item.item_name, description: item.description, image: null, sort_order: item.sort_order || 0, is_active: !!item.is_active, _preview: null, _currentImage: item.image, moveDetailId: '' };
        },

        async updateItem(detailId) {
            try {
                if (this.editItemForm.moveDetailId && parseInt(this.editItemForm.moveDetailId) !== detailId) {
                    await this.moveItem(this.editingItemId, this.editItemForm.moveDetailId);
                }
                const fd = new FormData();
                fd.append('_method', 'PUT');
                Object.entries(this.editItemForm).forEach(([k, v]) => {
                    if (k === '_preview' || k === '_currentImage' || k === 'moveDetailId') return;
                    if (k === 'image' && v) fd.append(k, v);
                    else if (k !== 'image') fd.append(k, v ?? '');
                });
                const data = await this.api('/admin/services/items/' + this.editingItemId, 'POST', fd);
                if (data.success) {
                    this.showAlert('success', data.message);
                    this.categories.forEach(c => {
                        if (c.all_details) {
                            const d = c.all_details.find(d => d.id === (parseInt(this.editItemForm.moveDetailId) || detailId));
                            if (d && d.all_items) {
                                const ii = d.all_items.findIndex(i => i.id === this.editingItemId);
                                if (ii > -1 && data.item) d.all_items[ii] = data.item;
                            }
                        }
                    });
                    this.editingItemId = null;
                    this.editingItemDetailId = null;
                } else this.showAlert('danger', data.message);
            } catch (e) { this.showAlert('danger', e.message); }
        },

        async deleteItem(id) {
            if (!confirm('Delete this item?')) return;
            try {
                const data = await this.api('/admin/services/items/' + id, 'DELETE');
                if (data.success) {
                    this.showAlert('success', data.message);
                    this.categories.forEach(c => {
                        if (c.all_details) c.all_details.forEach(d => { if (d.all_items) d.all_items = d.all_items.filter(i => i.id !== id); });
                    });
                } else this.showAlert('danger', data.message);
            } catch (e) { this.showAlert('danger', e.message); }
        },

        // --- Drag & Drop Details ---
        dragDetail(event, detail, catId) {
            event.dataTransfer.setData('text/plain', JSON.stringify({ type: 'detail', id: detail.id, catId: catId }));
            event.currentTarget.classList.add('dragging');
        },

        async dropDetail(event, cat, targetIndex) {
            event.preventDefault();
            event.currentTarget.classList.remove('drag-over');
            try {
                const data = JSON.parse(event.dataTransfer.getData('text/plain'));
                if (data.type !== 'detail') return;
                if (data.id === cat.all_details[targetIndex].id) return;
                const sourceIndex = cat.all_details.findIndex(d => d.id === data.id);
                if (sourceIndex === -1) return;
                const direction = sourceIndex > targetIndex ? 'up' : 'down';
                const result = await this.api('/admin/services/details/' + data.id + '/reorder', 'POST', new URLSearchParams({ direction: direction }));
                if (result.success) {
                    this.showAlert('success', result.message);
                    const catIdx = this.categories.findIndex(c => c.id === cat.id);
                    if (catIdx > -1 && result.category) this.categories[catIdx] = result.category;
                } else this.showAlert('danger', result.message);
            } catch (e) { this.showAlert('danger', e.message); }
        },

        // --- Drag & Drop Items ---
        dragItem(event, item, detailId) {
            event.dataTransfer.setData('text/plain', JSON.stringify({ type: 'item', id: item.id, detailId: detailId }));
            event.currentTarget.classList.add('dragging');
        },

        async dropItem(event, detail, targetIndex) {
            event.preventDefault();
            event.currentTarget.classList.remove('drag-over');
            try {
                const data = JSON.parse(event.dataTransfer.getData('text/plain'));
                if (data.type !== 'item') return;
                if (data.id === detail.all_items[targetIndex].id) return;
                const sourceIndex = detail.all_items.findIndex(i => i.id === data.id);
                if (sourceIndex === -1) return;
                const direction = sourceIndex > targetIndex ? 'up' : 'down';
                const result = await this.api('/admin/services/items/' + data.id + '/reorder', 'POST', new URLSearchParams({ direction: direction }));
                if (result.success) {
                    this.showAlert('success', result.message);
                    const catIdx = this.categories.findIndex(c => c.all_details && c.all_details.some(d => d.id === detail.id));
                    if (catIdx > -1 && result.category) this.categories[catIdx] = result.category;
                } else this.showAlert('danger', result.message);
            } catch (e) { this.showAlert('danger', e.message); }
        },

        // --- Move Item ---
        async moveItem(itemId, newDetailId) {
            if (!newDetailId) return;
            try {
                const result = await this.api('/admin/services/items/' + itemId + '/move', 'POST', new URLSearchParams({ service_detail_id: newDetailId }));
                if (result.success) {
                    this.showAlert('success', result.message);
                    if (result.categories) {
                        result.categories.forEach(updatedCat => {
                            const idx = this.categories.findIndex(c => c.id === updatedCat.id);
                            if (idx > -1) this.categories[idx] = updatedCat;
                        });
                    }
                    this.editingItemId = null;
                    this.editingItemDetailId = null;
                    this.editItemForm.moveDetailId = '';
                } else this.showAlert('danger', result.message);
            } catch (e) { this.showAlert('danger', e.message); }
        }
    };
}
</script>
@endpush
