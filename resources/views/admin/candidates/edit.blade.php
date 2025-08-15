@extends('admin.layouts.app')

@section('title', 'Edit Candidate')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="card bg-gradient-primary text-white shadow-lg border-0 mb-4">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="h3 mb-0 font-weight-bold">
                        <i class="fas fa-user-edit mr-2"></i>Edit Candidate
                    </h1>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.candidates.index') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left mr-2"></i>Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.candidates.update', $candidate) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row">
            <!-- Main Information -->
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold text-primary">
                            <i class="fas fa-user mr-2"></i>Personal Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" 
                                       value="{{ old('first_name', $candidate->first_name) }}" required>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" 
                                       value="{{ old('last_name', $candidate->last_name) }}" required>
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email', $candidate->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone', $candidate->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                       value="{{ old('date_of_birth', $candidate->date_of_birth) }}">
                                @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Professional Title</label>
                                <input type="text" name="professional_title" class="form-control @error('professional_title') is-invalid @enderror" 
                                       value="{{ old('professional_title', $candidate->professional_title) }}" placeholder="e.g., Software Engineer">
                                @error('professional_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Years of Experience</label>
                                <input type="number" name="experience_years" class="form-control @error('experience_years') is-invalid @enderror" 
                                       value="{{ old('experience_years', $candidate->experience_years) }}" min="0" max="50">
                                @error('experience_years')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                <small class="text-muted">Leave blank to keep current password</small>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label">Professional Summary</label>
                                <textarea name="professional_summary" rows="4" class="form-control @error('professional_summary') is-invalid @enderror" 
                                          placeholder="Brief description of professional background and expertise">{{ old('professional_summary', $candidate->professional_summary) }}</textarea>
                                @error('professional_summary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Location Information -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold text-primary">
                            <i class="fas fa-map-marker-alt mr-2"></i>Location Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" 
                                       value="{{ old('address', $candidate->address) }}">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" 
                                       value="{{ old('city', $candidate->city) }}">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">State/Province</label>
                                <input type="text" name="state" class="form-control @error('state') is-invalid @enderror" 
                                       value="{{ old('state', $candidate->state) }}">
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Country</label>
                                <input type="text" name="country" class="form-control @error('country') is-invalid @enderror" 
                                       value="{{ old('country', $candidate->country) }}">
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Postal Code</label>
                                <input type="text" name="postal_code" class="form-control @error('postal_code') is-invalid @enderror" 
                                       value="{{ old('postal_code', $candidate->postal_code) }}">
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Salary Information -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold text-primary">
                            <i class="fas fa-dollar-sign mr-2"></i>Salary Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Current Salary</label>
                                <input type="number" name="current_salary" class="form-control @error('current_salary') is-invalid @enderror" 
                                       value="{{ old('current_salary', $candidate->current_salary) }}" min="0">
                                @error('current_salary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Expected Salary</label>
                                <input type="number" name="expected_salary" class="form-control @error('expected_salary') is-invalid @enderror" 
                                       value="{{ old('expected_salary', $candidate->expected_salary) }}" min="0">
                                @error('expected_salary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Current Profile Photo -->
                @if($candidate->profile_photo)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold text-primary">
                            <i class="fas fa-image mr-2"></i>Current Photo
                        </h5>
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ asset($candidate->profile_photo) }}" class="img-thumbnail rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                </div>
                @endif

                <!-- Status & Settings -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold text-primary">
                            <i class="fas fa-cog mr-2"></i>Settings
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Account Status</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="active" {{ old('status', $candidate->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $candidate->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="suspended" {{ old('status', $candidate->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Profile Completion</label>
                            <input type="number" name="profile_completion" class="form-control @error('profile_completion') is-invalid @enderror" 
                                   value="{{ old('profile_completion', $candidate->profile_completion ?? 50) }}" min="0" max="100">
                            <small class="text-muted">Percentage (0-100)</small>
                            @error('profile_completion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender', $candidate->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $candidate->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender', $candidate->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                <option value="prefer_not_to_say" {{ old('gender', $candidate->gender) == 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Profile Photo Upload -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold text-primary">
                            <i class="fas fa-camera mr-2"></i>Update Profile Photo
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <img src="{{ $candidate->profile_photo ? asset($candidate->profile_photo) : 'https://via.placeholder.com/150' }}" 
                                 id="photoPreview" class="img-thumbnail rounded-circle" 
                                 style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                        <div class="mb-3">
                            <input type="file" name="profile_photo" class="form-control @error('profile_photo') is-invalid @enderror" 
                                   accept="image/*" onchange="previewPhoto(this)">
                            <small class="text-muted">Recommended: 200x200px, Max: 2MB</small>
                            @error('profile_photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold text-primary">
                            <i class="fas fa-chart-bar mr-2"></i>Statistics
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <div class="border-end">
                                    <h4 class="mb-0 text-primary">{{ $candidate->applications()->count() }}</h4>
                                    <small class="text-muted">Applications</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <h4 class="mb-0 text-success">{{ $candidate->bookmarks()->count() }}</h4>
                                <small class="text-muted">Bookmarks</small>
                            </div>
                        </div>
                        <div class="text-center">
                            <small class="text-muted">Member since {{ $candidate->created_at->format('M d, Y') }}</small>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary btn-block mb-2">
                            <i class="fas fa-save mr-2"></i>Update Candidate
                        </button>
                        <a href="{{ route('admin.candidates.index') }}" class="btn btn-secondary btn-block">
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

@push('scripts')
<script>
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('photoPreview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection