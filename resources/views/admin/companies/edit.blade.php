@extends('admin.layouts.app')

@section('title', 'Edit Company')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="card bg-gradient-primary text-white shadow-lg border-0 mb-4">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="h3 mb-0 font-weight-bold">
                        <i class="fas fa-edit mr-2"></i>Edit Company: {{ $company->company_name }}
                    </h1>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.companies.index') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left mr-2"></i>Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.companies.update', $company) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row">
            <!-- Company Information -->
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold text-primary">
                            <i class="fas fa-info-circle mr-2"></i>Company Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Company Name <span class="text-danger">*</span></label>
                                <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" 
                                       value="{{ old('company_name', $company->company_name) }}" required>
                                @error('company_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email', $company->user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">New Password <small class="text-muted">(Leave blank to keep current)</small></label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone', $company->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Website</label>
                                <input type="url" name="website" class="form-control @error('website') is-invalid @enderror" 
                                       value="{{ old('website', $company->website) }}" placeholder="https://example.com">
                                @error('website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Industry</label>
                                <select name="industry_id" class="form-select @error('industry_id') is-invalid @enderror">
                                    <option value="">Select Industry</option>
                                    @foreach($industries ?? [] as $industry)
                                        <option value="{{ $industry->id }}" {{ old('industry_id', $company->industry_id) == $industry->id ? 'selected' : '' }}>
                                            {{ $industry->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('industry_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $company->description) }}</textarea>
                                @error('description')
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
                                       value="{{ old('address', $company->address) }}">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" 
                                       value="{{ old('city', $company->city) }}">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">State/Province</label>
                                <input type="text" name="state" class="form-control @error('state') is-invalid @enderror" 
                                       value="{{ old('state', $company->state) }}">
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Country</label>
                                <input type="text" name="country" class="form-control @error('country') is-invalid @enderror" 
                                       value="{{ old('country', $company->country) }}">
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Postal Code</label>
                                <input type="text" name="postal_code" class="form-control @error('postal_code') is-invalid @enderror" 
                                       value="{{ old('postal_code', $company->postal_code) }}">
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold text-primary">
                            <i class="fas fa-chart-bar mr-2"></i>Company Statistics
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3 mb-3">
                                <div class="h4 text-primary">{{ $company->jobs_count ?? 0 }}</div>
                                <div class="text-muted">Total Jobs</div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="h4 text-success">{{ $company->projects_count ?? 0 }}</div>
                                <div class="text-muted">Total Projects</div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="h4 text-info">{{ $company->applications_received ?? 0 }}</div>
                                <div class="text-muted">Applications Received</div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="h4 text-warning">{{ $company->views_count ?? 0 }}</div>
                                <div class="text-muted">Profile Views</div>
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
                            <label class="form-label">Account Status</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="active" {{ old('status', $company->user->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $company->user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="suspended" {{ old('status', $company->user->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Verification Status</label>
                            <select name="verification_status" class="form-select @error('verification_status') is-invalid @enderror">
                                <option value="pending" {{ old('verification_status', $company->verification_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="verified" {{ old('verification_status', $company->verification_status) == 'verified' ? 'selected' : '' }}>Verified</option>
                                <option value="rejected" {{ old('verification_status', $company->verification_status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                            @error('verification_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Company Size</label>
                            <select name="company_size" class="form-select @error('company_size') is-invalid @enderror">
                                <option value="">Select Size</option>
                                <option value="1-10" {{ old('company_size', $company->company_size) == '1-10' ? 'selected' : '' }}>1-10 employees</option>
                                <option value="11-50" {{ old('company_size', $company->company_size) == '11-50' ? 'selected' : '' }}>11-50 employees</option>
                                <option value="51-200" {{ old('company_size', $company->company_size) == '51-200' ? 'selected' : '' }}>51-200 employees</option>
                                <option value="201-500" {{ old('company_size', $company->company_size) == '201-500' ? 'selected' : '' }}>201-500 employees</option>
                                <option value="501-1000" {{ old('company_size', $company->company_size) == '501-1000' ? 'selected' : '' }}>501-1000 employees</option>
                                <option value="1000+" {{ old('company_size', $company->company_size) == '1000+' ? 'selected' : '' }}>1000+ employees</option>
                            </select>
                            @error('company_size')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Founded Year</label>
                            <input type="number" name="founded_year" class="form-control @error('founded_year') is-invalid @enderror" 
                                   value="{{ old('founded_year', $company->founded_year) }}" min="1900" max="{{ date('Y') }}">
                            @error('founded_year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Logo Upload -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold text-primary">
                            <i class="fas fa-image mr-2"></i>Company Logo
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            @if($company->logo)
                                <img src="{{ asset($company->logo) }}" id="logoPreview" class="img-thumbnail" style="max-width: 150px;">
                            @else
                                <img src="https://via.placeholder.com/150" id="logoPreview" class="img-thumbnail" style="max-width: 150px;">
                            @endif
                        </div>
                        <div class="mb-3">
                            <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror" 
                                   accept="image/*" onchange="previewLogo(this)">
                            <small class="text-muted">Recommended: 200x200px, Max: 2MB</small>
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Account Info -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold text-primary">
                            <i class="fas fa-info mr-2"></i>Account Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted">Created:</small>
                            <div>{{ $company->created_at->format('M d, Y h:i A') }}</div>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Last Updated:</small>
                            <div>{{ $company->updated_at->format('M d, Y h:i A') }}</div>
                        </div>
                        @if($company->verified_at)
                            <div class="mb-2">
                                <small class="text-muted">Verified:</small>
                                <div>{{ $company->verified_at->format('M d, Y h:i A') }}</div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary btn-block mb-2">
                            <i class="fas fa-save mr-2"></i>Update Company
                        </button>
                        <a href="{{ route('admin.companies.show', $company) }}" class="btn btn-info btn-block mb-2">
                            <i class="fas fa-eye mr-2"></i>View Company
                        </a>
                        <a href="{{ route('admin.companies.index') }}" class="btn btn-secondary btn-block">
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
function previewLogo(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('logoPreview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection