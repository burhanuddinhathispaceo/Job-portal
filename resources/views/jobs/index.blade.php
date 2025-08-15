@extends('layouts.app')

@section('title', 'Browse Jobs')

@section('content')
<div class="container">
    <div class="row">
        <!-- Filters Sidebar -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Filter Jobs</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('jobs.index') }}" method="GET">
                        <div class="mb-3">
                            <label for="search" class="form-label">Keywords</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="search" 
                                   name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Job title, skills...">
                        </div>
                        
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="location" 
                                   name="location" 
                                   value="{{ request('location') }}" 
                                   placeholder="City, State...">
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                        <a href="{{ route('jobs.index') }}" class="btn btn-outline-secondary w-100 mt-2">Clear Filters</a>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Jobs List -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Available Jobs</h2>
                <div class="text-muted">
                    Showing {{ $jobs->firstItem() ?? 0 }}-{{ $jobs->lastItem() ?? 0 }} of {{ $jobs->total() }} jobs
                </div>
            </div>
            
            @if($jobs->count() > 0)
                @foreach($jobs as $job)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 class="card-title">
                                        <a href="{{ route('jobs.show', $job) }}" class="text-decoration-none">
                                            {{ $job->title }}
                                        </a>
                                    </h5>
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        {{ $job->company->company_name ?? $job->company->user->name }}
                                    </h6>
                                    <p class="card-text">{{ Str::limit($job->description, 200) }}</p>
                                    <div class="mb-2">
                                        @if($job->location)
                                            <span class="badge bg-secondary me-2">
                                                <i class="fas fa-map-marker-alt"></i> 
                                                {{ $job->location->city }}, {{ $job->location->state }}
                                            </span>
                                        @endif
                                        @if($job->job_type)
                                            <span class="badge bg-info me-2">{{ $job->job_type }}</span>
                                        @endif
                                        @if($job->industry)
                                            <span class="badge bg-success">{{ $job->industry->name }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 text-end">
                                    <div class="mb-2">
                                        @if($job->salary_min && $job->salary_max)
                                            <strong class="text-success">
                                                ${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }}
                                            </strong>
                                        @elseif($job->salary_min)
                                            <strong class="text-success">From ${{ number_format($job->salary_min) }}</strong>
                                        @endif
                                    </div>
                                    <div class="mb-2">
                                        <small class="text-muted">Posted {{ $job->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="btn-group-vertical w-100">
                                        <a href="{{ route('jobs.show', $job) }}" class="btn btn-primary btn-sm">
                                            View Details
                                        </a>
                                        @auth
                                            @if(auth()->user()->hasRole('candidate'))
                                                <button type="button" class="btn btn-outline-secondary btn-sm bookmark-btn" data-job-id="{{ $job->id }}">
                                                    <i class="fas fa-bookmark"></i> Save
                                                </button>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $jobs->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h4>No jobs found</h4>
                    <p class="text-muted">Try adjusting your search criteria or check back later for new opportunities.</p>
                    <a href="{{ route('jobs.index') }}" class="btn btn-primary">Browse All Jobs</a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Bookmark functionality
    document.querySelectorAll('.bookmark-btn').forEach(button => {
        button.addEventListener('click', function() {
            const jobId = this.dataset.jobId;
            
            fetch('{{ route("candidate.bookmarks.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ job_id: jobId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.innerHTML = '<i class="fas fa-bookmark"></i> Saved';
                    this.classList.remove('btn-outline-secondary');
                    this.classList.add('btn-success');
                    this.disabled = true;
                } else {
                    alert(data.error || 'Failed to bookmark job');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to bookmark job');
            });
        });
    });
});
</script>
@endpush
@endsection