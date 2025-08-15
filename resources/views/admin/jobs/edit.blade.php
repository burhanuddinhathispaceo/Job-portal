@extends('admin.layouts.app')

@section('title', 'Edit Job')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="card bg-gradient-primary text-white shadow-lg border-0 mb-4">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="h3 mb-0 font-weight-bold">
                        <i class="fas fa-edit mr-2"></i>Edit Job
                    </h1>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.jobs.show', $job) }}" class="btn btn-warning me-2">
                        <i class="fas fa-eye mr-2"></i>View
                    </a>
                    <a href="{{ route('admin.jobs.index') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left mr-2"></i>Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.jobs.update', $job) }}" method="POST">
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
                                <label class="form-label">Job Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                       value="{{ old('title', $job->title) }}" required placeholder="e.g., Senior Software Developer">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Company <span class="text-danger">*</span></label>
                                <select name="company_id" class="form-select @error('company_id') is-invalid @enderror" required>
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ old('company_id', $job->company_id) == $company->id ? 'selected' : '' }}>
                                            {{ $company->company_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('company_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Job Type <span class="text-danger">*</span></label>
                                <select name="job_type_id" class="form-select @error('job_type_id') is-invalid @enderror" required>
                                    <option value="">Select Job Type</option>
                                    @foreach($jobTypes as $jobType)
                                        <option value="{{ $jobType->id }}" {{ old('job_type_id', $job->job_type_id) == $jobType->id ? 'selected' : '' }}>
                                            {{ $jobType->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('job_type_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Industry</label>
                                <select name="industry_id" class="form-select @error('industry_id') is-invalid @enderror">
                                    <option value="">Select Industry</option>
                                    @foreach($industries as $industry)
                                        <option value="{{ $industry->id }}" {{ old('industry_id', $job->industry_id) == $industry->id ? 'selected' : '' }}>
                                            {{ $industry->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('industry_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label">Job Description <span class="text-danger">*</span></label>
                                <textarea name="description" rows="6" class="form-control @error('description') is-invalid @enderror" 
                                          required placeholder="Describe the job responsibilities, requirements, and benefits">{{ old('description', $job->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label">Requirements</label>
                                <textarea name="requirements" rows="4" class="form-control @error('requirements') is-invalid @enderror" 
                                          placeholder="List the key requirements and qualifications">{{ old('requirements', $job->requirements) }}</textarea>
                                @error('requirements')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Location & Compensation -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold text-primary">
                            <i class="fas fa-map-marker-alt mr-2"></i>Location & Compensation
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Location</label>
                                <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" 
                                       value="{{ old('location', $job->location) }}" placeholder="City, State">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_remote" value="1" 
                                           id="is_remote" {{ old('is_remote', $job->is_remote) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_remote">
                                        Remote Work Available
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Minimum Salary</label>
                                <input type="number" name="salary_min" class="form-control @error('salary_min') is-invalid @enderror" 
                                       value="{{ old('salary_min', $job->salary_min) }}" min="0" placeholder="50000">
                                @error('salary_min')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Maximum Salary</label>
                                <input type="number" name="salary_max" class="form-control @error('salary_max') is-invalid @enderror" 
                                       value="{{ old('salary_max', $job->salary_max) }}" min="0" placeholder="80000">
                                @error('salary_max')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Salary Type</label>
                                <select name="salary_type" class="form-select @error('salary_type') is-invalid @enderror">
                                    <option value="yearly" {{ old('salary_type', $job->salary_type) == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                    <option value="monthly" {{ old('salary_type', $job->salary_type) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="hourly" {{ old('salary_type', $job->salary_type) == 'hourly' ? 'selected' : '' }}>Hourly</option>
                                </select>
                                @error('salary_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Experience Level</label>
                                <select name="experience_level" class="form-select @error('experience_level') is-invalid @enderror">
                                    <option value="">Select Experience Level</option>
                                    <option value="entry" {{ old('experience_level', $job->experience_level) == 'entry' ? 'selected' : '' }}>Entry Level</option>
                                    <option value="mid" {{ old('experience_level', $job->experience_level) == 'mid' ? 'selected' : '' }}>Mid Level</option>
                                    <option value="senior" {{ old('experience_level', $job->experience_level) == 'senior' ? 'selected' : '' }}>Senior Level</option>
                                    <option value="executive" {{ old('experience_level', $job->experience_level) == 'executive' ? 'selected' : '' }}>Executive</option>
                                </select>
                                @error('experience_level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Skills & Additional Info -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold text-primary">
                            <i class="fas fa-cogs mr-2"></i>Skills & Additional Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label">Required Skills</label>
                                <input type="text" name="skills" class="form-control @error('skills') is-invalid @enderror" 
                                       value="{{ old('skills', $job->skills->pluck('name')->implode(', ')) }}" 
                                       placeholder="PHP, Laravel, Vue.js, MySQL (comma separated)">
                                <small class="text-muted">Separate skills with commas</small>
                                @error('skills')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Application Deadline</label>
                                <input type="date" name="application_deadline" class="form-control @error('application_deadline') is-invalid @enderror" 
                                       value="{{ old('application_deadline', $job->application_deadline ? $job->application_deadline->format('Y-m-d') : '') }}" 
                                       min="{{ date('Y-m-d') }}">
                                @error('application_deadline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Available Positions</label>
                                <input type="number" name="available_positions" class="form-control @error('available_positions') is-invalid @enderror" 
                                       value="{{ old('available_positions', $job->available_positions) }}" min="1" max="100">
                                @error('available_positions')
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
                                    <h4 class="mb-0 text-primary">{{ $job->views_count ?? 0 }}</h4>
                                    <small class="text-muted">Views</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <h4 class="mb-0 text-success">{{ $job->applications()->count() }}</h4>
                                <small class="text-muted">Applications</small>
                            </div>
                        </div>
                        <div class="text-center">
                            <small class="text-muted">Posted {{ $job->created_at->diffForHumans() }}</small>
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
                                <option value="active" {{ old('status', $job->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $job->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="closed" {{ old('status', $job->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Visibility</label>
                            <select name="visibility" class="form-select @error('visibility') is-invalid @enderror">
                                <option value="public" {{ old('visibility', $job->visibility) == 'public' ? 'selected' : '' }}>Public</option>
                                <option value="featured" {{ old('visibility', $job->visibility) == 'featured' ? 'selected' : '' }}>Featured</option>
                                <option value="highlighted" {{ old('visibility', $job->visibility) == 'highlighted' ? 'selected' : '' }}>Highlighted</option>
                                <option value="private" {{ old('visibility', $job->visibility) == 'private' ? 'selected' : '' }}>Private</option>
                            </select>
                            @error('visibility')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Employment Type</label>
                            <select name="employment_type" class="form-select @error('employment_type') is-invalid @enderror">
                                <option value="full_time" {{ old('employment_type', $job->employment_type) == 'full_time' ? 'selected' : '' }}>Full Time</option>
                                <option value="part_time" {{ old('employment_type', $job->employment_type) == 'part_time' ? 'selected' : '' }}>Part Time</option>
                                <option value="contract" {{ old('employment_type', $job->employment_type) == 'contract' ? 'selected' : '' }}>Contract</option>
                                <option value="freelance" {{ old('employment_type', $job->employment_type) == 'freelance' ? 'selected' : '' }}>Freelance</option>
                                <option value="internship" {{ old('employment_type', $job->employment_type) == 'internship' ? 'selected' : '' }}>Internship</option>
                            </select>
                            @error('employment_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_urgent" value="1" 
                                   id="is_urgent" {{ old('is_urgent', $job->is_urgent) ? 'checked' : '' }}>
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
                            <i class="fas fa-save mr-2"></i>Update Job
                        </button>
                        <a href="{{ route('admin.jobs.show', $job) }}" class="btn btn-secondary btn-block">
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