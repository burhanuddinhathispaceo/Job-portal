@extends('admin.layouts.app')

@section('title', 'Edit Project')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="card bg-gradient-primary text-white shadow-lg border-0 mb-4">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="h3 mb-0 font-weight-bold">
                        <i class="fas fa-edit mr-2"></i>Edit Project
                    </h1>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-warning me-2">
                        <i class="fas fa-eye mr-2"></i>View
                    </a>
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left mr-2"></i>Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.projects.update', $project) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <!-- Main Information -->
            <div class="col-lg-8">
                <!-- Basic Information -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold text-primary">
                            <i class="fas fa-info-circle mr-2"></i>Basic Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Project Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                       value="{{ old('title', $project->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Company <span class="text-danger">*</span></label>
                                <select name="company_id" class="form-select @error('company_id') is-invalid @enderror" required>
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ old('company_id', $project->company_id) == $company->id ? 'selected' : '' }}>
                                            {{ $company->company_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('company_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Project Type <span class="text-danger">*</span></label>
                                <select name="project_type_id" class="form-select @error('project_type_id') is-invalid @enderror" required>
                                    <option value="">Select Project Type</option>
                                    @foreach($projectTypes as $projectType)
                                        <option value="{{ $projectType->id }}" {{ old('project_type_id', $project->project_type_id) == $projectType->id ? 'selected' : '' }}>
                                            {{ $projectType->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('project_type_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Duration (Months)</label>
                                <input type="number" name="duration_months" class="form-control @error('duration_months') is-invalid @enderror" 
                                       value="{{ old('duration_months', $project->duration_months) }}" min="1" max="60">
                                @error('duration_months')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label">Project Description <span class="text-danger">*</span></label>
                                <textarea name="description" rows="6" class="form-control @error('description') is-invalid @enderror" 
                                          required>{{ old('description', $project->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label">Requirements</label>
                                <textarea name="requirements" rows="4" class="form-control @error('requirements') is-invalid @enderror">{{ old('requirements', $project->requirements) }}</textarea>
                                @error('requirements')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Location & Budget -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold text-primary">
                            <i class="fas fa-map-marker-alt mr-2"></i>Location & Budget
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Location</label>
                                <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" 
                                       value="{{ old('location', $project->location) }}">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_remote" value="1" 
                                           id="is_remote" {{ old('is_remote', $project->is_remote) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_remote">
                                        Remote Work Available
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Minimum Budget ($)</label>
                                <input type="number" name="budget_min" class="form-control @error('budget_min') is-invalid @enderror" 
                                       value="{{ old('budget_min', $project->budget_min) }}" min="0">
                                @error('budget_min')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Maximum Budget ($)</label>
                                <input type="number" name="budget_max" class="form-control @error('budget_max') is-invalid @enderror" 
                                       value="{{ old('budget_max', $project->budget_max) }}" min="0">
                                @error('budget_max')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Application Deadline</label>
                                <input type="date" name="application_deadline" class="form-control @error('application_deadline') is-invalid @enderror" 
                                       value="{{ old('application_deadline', $project->application_deadline ? $project->application_deadline->format('Y-m-d') : '') }}" 
                                       min="{{ date('Y-m-d') }}">
                                @error('application_deadline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Required Skills</label>
                                <input type="text" name="skills" class="form-control @error('skills') is-invalid @enderror" 
                                       value="{{ old('skills', $project->skills->pluck('name')->implode(', ')) }}">
                                <small class="text-muted">Separate skills with commas</small>
                                @error('skills')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Current Statistics -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold text-primary">
                            <i class="fas fa-chart-bar mr-2"></i>Current Statistics
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <div class="border-end">
                                    <h4 class="mb-0 text-primary">{{ $project->views_count ?? 0 }}</h4>
                                    <small class="text-muted">Views</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <h4 class="mb-0 text-success">{{ $project->applications()->count() }}</h4>
                                <small class="text-muted">Applications</small>
                            </div>
                        </div>
                        <div class="text-center">
                            <small class="text-muted">Posted {{ $project->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>

                <!-- Status & Settings -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold text-primary">
                            <i class="fas fa-cog mr-2"></i>Settings
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="active" {{ old('status', $project->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $project->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="closed" {{ old('status', $project->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Visibility</label>
                            <select name="visibility" class="form-select @error('visibility') is-invalid @enderror">
                                <option value="public" {{ old('visibility', $project->visibility) == 'public' ? 'selected' : '' }}>Public</option>
                                <option value="featured" {{ old('visibility', $project->visibility) == 'featured' ? 'selected' : '' }}>Featured</option>
                                <option value="highlighted" {{ old('visibility', $project->visibility) == 'highlighted' ? 'selected' : '' }}>Highlighted</option>
                                <option value="private" {{ old('visibility', $project->visibility) == 'private' ? 'selected' : '' }}>Private</option>
                            </select>
                            @error('visibility')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_urgent" value="1" 
                                   id="is_urgent" {{ old('is_urgent', $project->is_urgent) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_urgent">
                                Mark as Urgent
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary btn-block mb-2">
                            <i class="fas fa-save mr-2"></i>Update Project
                        </button>
                        <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-secondary btn-block">
                            <i class="fas fa-times mr-2"></i>Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
</style>
@endpush
@endsection