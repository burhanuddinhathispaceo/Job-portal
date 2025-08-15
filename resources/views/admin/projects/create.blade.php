@extends('admin.layouts.app')

@section('title', 'Create Project')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="card bg-gradient-primary text-white shadow-lg border-0 mb-4">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="h3 mb-0 font-weight-bold">
                        <i class="fas fa-project-diagram mr-2"></i>Create New Project
                    </h1>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left mr-2"></i>Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.projects.store') }}" method="POST">
        @csrf
        
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
                                       value="{{ old('title') }}" required placeholder="e.g., E-commerce Website Development">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Company <span class="text-danger">*</span></label>
                                <select name="company_id" class="form-select @error('company_id') is-invalid @enderror" required>
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
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
                                        <option value="{{ $projectType->id }}" {{ old('project_type_id') == $projectType->id ? 'selected' : '' }}>
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
                                       value="{{ old('duration_months') }}" min="1" max="60" placeholder="3">
                                @error('duration_months')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label">Project Description <span class="text-danger">*</span></label>
                                <textarea name="description" rows="6" class="form-control @error('description') is-invalid @enderror" 
                                          required placeholder="Describe the project scope, objectives, and deliverables">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label">Requirements</label>
                                <textarea name="requirements" rows="4" class="form-control @error('requirements') is-invalid @enderror" 
                                          placeholder="List the technical requirements and qualifications needed">{{ old('requirements') }}</textarea>
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
                                       value="{{ old('location') }}" placeholder="City, State or Remote">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_remote" value="1" 
                                           id="is_remote" {{ old('is_remote') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_remote">
                                        Remote Work Available
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Minimum Budget ($)</label>
                                <input type="number" name="budget_min" class="form-control @error('budget_min') is-invalid @enderror" 
                                       value="{{ old('budget_min') }}" min="0" placeholder="5000">
                                @error('budget_min')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Maximum Budget ($)</label>
                                <input type="number" name="budget_max" class="form-control @error('budget_max') is-invalid @enderror" 
                                       value="{{ old('budget_max') }}" min="0" placeholder="15000">
                                @error('budget_max')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Application Deadline</label>
                                <input type="date" name="application_deadline" class="form-control @error('application_deadline') is-invalid @enderror" 
                                       value="{{ old('application_deadline') }}" min="{{ date('Y-m-d') }}">
                                @error('application_deadline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Required Skills</label>
                                <input type="text" name="skills" class="form-control @error('skills') is-invalid @enderror" 
                                       value="{{ old('skills') }}" placeholder="Laravel, Vue.js, MySQL (comma separated)">
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
                                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Visibility</label>
                            <select name="visibility" class="form-select @error('visibility') is-invalid @enderror">
                                <option value="public" {{ old('visibility', 'public') == 'public' ? 'selected' : '' }}>Public</option>
                                <option value="featured" {{ old('visibility') == 'featured' ? 'selected' : '' }}>Featured</option>
                                <option value="highlighted" {{ old('visibility') == 'highlighted' ? 'selected' : '' }}>Highlighted</option>
                                <option value="private" {{ old('visibility') == 'private' ? 'selected' : '' }}>Private</option>
                            </select>
                            @error('visibility')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_urgent" value="1" 
                                   id="is_urgent" {{ old('is_urgent') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_urgent">
                                Mark as Urgent
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Project Guidelines -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold text-primary">
                            <i class="fas fa-lightbulb mr-2"></i>Project Guidelines
                        </h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0 small text-muted">
                            <li class="mb-2">
                                <i class="fas fa-check text-success mr-2"></i>
                                Write clear and detailed project description
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success mr-2"></i>
                                Specify realistic budget range
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success mr-2"></i>
                                List all required technical skills
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success mr-2"></i>
                                Set reasonable project timeline
                            </li>
                            <li class="mb-0">
                                <i class="fas fa-check text-success mr-2"></i>
                                Include any special requirements
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary btn-block mb-2">
                            <i class="fas fa-save mr-2"></i>Create Project
                        </button>
                        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary btn-block">
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