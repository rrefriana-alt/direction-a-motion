@extends('admin.layout')
@section('title', 'Add Career Opening')

@section('content')
<div class="max-w-3xl space-y-6">
    <!-- Header / Back navigation -->
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.careers.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors mb-2">
                <i class="ph ph-arrow-left"></i>
                <span>Back to Careers</span>
            </a>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Create Career Opening</h1>
            <p class="text-sm text-slate-500 mt-1">Publish a new job opportunity or role to your careers section.</p>
        </div>
    </div>

    <!-- Error Messages -->
    @if ($errors->any())
    <div class="bg-rose-50 border border-rose-200 text-rose-800 rounded-xl p-4">
        <div class="flex items-center gap-2 mb-2 font-semibold text-rose-900">
            <i class="ph ph-warning-circle text-lg"></i>
            <span>Please correct the errors below:</span>
        </div>
        <ul class="list-disc list-inside text-sm space-y-1 text-rose-700">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form Card -->
    <form action="{{ route('admin.careers.store') }}" method="POST" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 md:p-8 space-y-6">
        @csrf

        <!-- Job Title -->
        <div>
            <label for="title" class="block text-sm font-semibold text-slate-800 mb-1.5">
                Job Title / Position <span class="text-rose-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="ph ph-briefcase text-lg"></i>
                </div>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="{{ old('title') }}" 
                    placeholder="e.g. Senior Motion Graphic Designer" 
                    required 
                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border @error('title') border-rose-400 bg-rose-50/20 @else border-slate-300 @enderror rounded-lg text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-colors text-sm"
                >
            </div>
            @error('title')
                <p class="text-xs text-rose-600 mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <!-- Type and Location Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Employment Type -->
            <div>
                <label for="type" class="block text-sm font-semibold text-slate-800 mb-1.5">
                    Employment Type <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="ph ph-clock text-lg"></i>
                    </div>
                    <select 
                        id="type" 
                        name="type" 
                        required 
                        class="w-full pl-10 pr-8 py-2.5 bg-slate-50/50 border @error('type') border-rose-400 bg-rose-50/20 @else border-slate-300 @enderror rounded-lg text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-colors text-sm appearance-none"
                    >
                        @php
                            $types = ['Full-Time', 'Part-Time', 'Contract', 'Freelance', 'Internship', 'Remote'];
                            $selectedType = old('type', 'Full-Time');
                        @endphp
                        @foreach($types as $t)
                            <option value="{{ $t }}" {{ $selectedType === $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="ph ph-caret-down text-base"></i>
                    </div>
                </div>
                @error('type')
                    <p class="text-xs text-rose-600 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- Location -->
            <div>
                <label for="location" class="block text-sm font-semibold text-slate-800 mb-1.5">
                    Location / Office <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="ph ph-map-pin text-lg"></i>
                    </div>
                    <input 
                        type="text" 
                        id="location" 
                        name="location" 
                        value="{{ old('location', 'Bandung') }}" 
                        placeholder="e.g. Bandung / Jakarta / Remote" 
                        required 
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border @error('location') border-rose-400 bg-rose-50/20 @else border-slate-300 @enderror rounded-lg text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-colors text-sm"
                    >
                </div>
                @error('location')
                    <p class="text-xs text-rose-600 mt-1.5">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Status Checkbox / Switch -->
        <div class="pt-2 border-t border-slate-100">
            <label class="relative flex items-start gap-3 p-4 rounded-lg bg-slate-50/80 hover:bg-slate-50 border border-slate-200 cursor-pointer transition-colors">
                <input 
                    type="checkbox" 
                    name="is_open" 
                    value="1" 
                    {{ old('is_open', true) ? 'checked' : '' }} 
                    class="mt-1 w-4 h-4 rounded text-blue-600 focus:ring-blue-500 border-slate-300 transition"
                >
                <div class="space-y-0.5">
                    <span class="block text-sm font-semibold text-slate-800">Active & Open for Applications</span>
                    <span class="block text-xs text-slate-500">When checked, this career listing will be marked as active and visible for job candidates.</span>
                </div>
            </label>
            @error('is_open')
                <p class="text-xs text-rose-600 mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
            <a href="{{ route('admin.careers.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50 font-medium text-sm transition-colors">
                Cancel
            </a>
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white rounded-lg font-medium text-sm transition-colors shadow-sm">
                <i class="ph ph-check text-base"></i>
                <span>Create Position</span>
            </button>
        </div>
    </form>
</div>
@endsection
