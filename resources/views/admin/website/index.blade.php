@extends('admin.layouts.app')

@section('title', 'Website Settings')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white shadow-lg border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h3 mb-0">
                                <i class="fas fa-palette me-2"></i>Website Customization
                            </h1>
                            <p class="mb-0 opacity-75">Customize your website appearance, branding, and layout</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Appearance Settings -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 font-weight-bold text-primary">
                        <i class="fas fa-paint-brush mr-2"></i>Appearance Settings
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.website.update-appearance') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Theme</label>
                            <select name="theme" class="form-select @error('theme') is-invalid @enderror">
                                <option value="light" {{ old('theme', $settings['appearance']['theme'] ?? 'light') == 'light' ? 'selected' : '' }}>Light Theme</option>
                                <option value="dark" {{ old('theme', $settings['appearance']['theme'] ?? 'light') == 'dark' ? 'selected' : '' }}>Dark Theme</option>
                                <option value="auto" {{ old('theme', $settings['appearance']['theme'] ?? 'light') == 'auto' ? 'selected' : '' }}>Auto (System)</option>
                            </select>
                            @error('theme')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Primary Color</label>
                            <input type="color" name="primary_color" class="form-control form-control-color @error('primary_color') is-invalid @enderror" 
                                   value="{{ old('primary_color', $settings['appearance']['primary_color'] ?? '#667eea') }}">
                            @error('primary_color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Secondary Color</label>
                            <input type="color" name="secondary_color" class="form-control form-control-color @error('secondary_color') is-invalid @enderror" 
                                   value="{{ old('secondary_color', $settings['appearance']['secondary_color'] ?? '#764ba2') }}">
                            @error('secondary_color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Font Family</label>
                            <select name="font_family" class="form-select @error('font_family') is-invalid @enderror">
                                <option value="Inter" {{ old('font_family', $settings['appearance']['font_family'] ?? 'Inter') == 'Inter' ? 'selected' : '' }}>Inter</option>
                                <option value="Roboto" {{ old('font_family', $settings['appearance']['font_family'] ?? 'Inter') == 'Roboto' ? 'selected' : '' }}>Roboto</option>
                                <option value="Open Sans" {{ old('font_family', $settings['appearance']['font_family'] ?? 'Inter') == 'Open Sans' ? 'selected' : '' }}>Open Sans</option>
                                <option value="Poppins" {{ old('font_family', $settings['appearance']['font_family'] ?? 'Inter') == 'Poppins' ? 'selected' : '' }}>Poppins</option>
                            </select>
                            @error('font_family')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i>Save Appearance
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Theme Preview -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 font-weight-bold text-primary">
                        <i class="fas fa-eye mr-2"></i>Theme Preview
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>Current Theme:</strong> {{ ucfirst($settings['appearance']['theme'] ?? 'light') }}
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Theme changes will be applied after saving and refreshing the page.</small>
                    </div>
                    <div class="d-flex gap-3">
                        <div class="flex-fill">
                            <div class="p-3 border rounded" style="background: {{ $settings['appearance']['primary_color'] ?? '#667eea' }};">
                                <small class="text-white">Primary Color</small>
                            </div>
                        </div>
                        <div class="flex-fill">
                            <div class="p-3 border rounded" style="background: {{ $settings['appearance']['secondary_color'] ?? '#764ba2' }};">
                                <small class="text-white">Secondary Color</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
</style>
@endpush
@endsection