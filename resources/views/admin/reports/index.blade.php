@extends('admin.layouts.app')

@section('title', __('admin.reports.title'))

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-chart-bar text-primary"></i> {{ __('admin.reports.advanced_reports') }}
            </h1>
            <p class="text-muted mt-2">{{ __('admin.reports.generate_comprehensive_reports') }}</p>
        </div>
    </div>

    <!-- Report Cards Grid -->
    <div class="row">
        @foreach($availableReports as $key => $name)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 report-card" data-report="{{ $key }}">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="report-icon-wrapper">
                            @switch($key)
                                @case('user_activity')
                                    <i class="fas fa-users fa-2x text-primary"></i>
                                    @break
                                @case('job_performance')
                                    <i class="fas fa-briefcase fa-2x text-success"></i>
                                    @break
                                @case('revenue_analysis')
                                    <i class="fas fa-dollar-sign fa-2x text-warning"></i>
                                    @break
                                @case('application_trends')
                                    <i class="fas fa-chart-line fa-2x text-info"></i>
                                    @break
                                @case('company_performance')
                                    <i class="fas fa-building fa-2x text-purple"></i>
                                    @break
                                @case('candidate_analytics')
                                    <i class="fas fa-user-graduate fa-2x text-teal"></i>
                                    @break
                                @case('system_health')
                                    <i class="fas fa-heartbeat fa-2x text-danger"></i>
                                    @break
                                @case('subscription_metrics')
                                    <i class="fas fa-credit-card fa-2x text-orange"></i>
                                    @break
                                @default
                                    <i class="fas fa-chart-pie fa-2x text-secondary"></i>
                            @endswitch
                        </div>
                    </div>
                    <h5 class="card-title font-weight-bold">{{ $name }}</h5>
                    <p class="card-text text-muted small">{{ __('admin.reports.' . $key . '_description') }}</p>
                    <button class="btn btn-primary btn-sm generate-report" data-report="{{ $key }}">
                        <i class="fas fa-play-circle"></i> {{ __('admin.reports.generate') }}
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- System Health Report (Always Visible) -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-server"></i> {{ __('admin.reports.system_health_overview') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div id="system-health-container">
                        <div class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">{{ __('admin.loading') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Report Generation Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="reportModalTitle">{{ __('admin.reports.generate_report') }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="reportForm">
                    @csrf
                    <input type="hidden" name="report_type" id="report_type">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.reports.start_date') }}</label>
                                <input type="date" name="start_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.reports.end_date') }}</label>
                                <input type="date" name="end_date" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="additional-filters">
                        <!-- Dynamic filters will be loaded here -->
                    </div>

                    <div class="form-group">
                        <label>{{ __('admin.reports.export_format') }}</label>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-outline-primary active">
                                <input type="radio" name="format" value="preview" checked> 
                                <i class="fas fa-eye"></i> {{ __('admin.preview') }}
                            </label>
                            <label class="btn btn-outline-success">
                                <input type="radio" name="format" value="csv"> 
                                <i class="fas fa-file-csv"></i> CSV
                            </label>
                            <label class="btn btn-outline-info">
                                <input type="radio" name="format" value="xlsx"> 
                                <i class="fas fa-file-excel"></i> Excel
                            </label>
                            <label class="btn btn-outline-danger">
                                <input type="radio" name="format" value="pdf"> 
                                <i class="fas fa-file-pdf"></i> PDF
                            </label>
                        </div>
                    </div>
                </form>

                <div id="report-preview" class="mt-4" style="display: none;">
                    <!-- Report preview will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    {{ __('admin.close') }}
                </button>
                <button type="button" class="btn btn-primary" id="generateReportBtn">
                    <i class="fas fa-cog fa-spin" style="display: none;"></i>
                    <span>{{ __('admin.reports.generate') }}</span>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.report-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.report-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}

.report-icon-wrapper {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
}

.report-icon-wrapper i {
    color: white !important;
}

.text-purple { color: #6f42c1; }
.text-teal { color: #20c997; }
.text-orange { color: #fd7e14; }

.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
</style>

@push('scripts')
<script>
$(document).ready(function() {
    // Load system health on page load
    loadSystemHealth();

    // Generate report button click
    $('.generate-report').click(function() {
        const reportType = $(this).data('report');
        $('#report_type').val(reportType);
        $('#reportModalTitle').text($(this).parent().find('.card-title').text());
        
        // Load dynamic filters based on report type
        loadReportFilters(reportType);
        
        $('#reportModal').modal('show');
    });

    // Generate report
    $('#generateReportBtn').click(function() {
        const format = $('input[name="format"]:checked').val();
        const reportType = $('#report_type').val();
        
        if (format === 'preview') {
            generateReportPreview(reportType);
        } else {
            exportReport(reportType, format);
        }
    });

    function loadSystemHealth() {
        $.get('{{ route("admin.reports.system-health") }}', function(data) {
            let html = `
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center">
                            <h6>{{ __('admin.reports.database_status') }}</h6>
                            <span class="badge badge-${data.database_status === 'healthy' ? 'success' : 'danger'} p-2">
                                ${data.database_status.toUpperCase()}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h6>{{ __('admin.reports.storage_usage') }}</h6>
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar bg-${data.storage_usage.percentage > 80 ? 'danger' : 'success'}" 
                                     style="width: ${data.storage_usage.percentage}%">
                                    ${data.storage_usage.percentage}%
                                </div>
                            </div>
                            <small>${data.storage_usage.used} / ${data.storage_usage.total}</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h6>{{ __('admin.reports.active_sessions') }}</h6>
                            <h3 class="text-primary">${data.active_sessions}</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h6>{{ __('admin.reports.queue_status') }}</h6>
                            <span class="badge badge-${data.queue_status.status === 'active' ? 'success' : 'warning'} p-2">
                                ${data.queue_status.status.toUpperCase()}
                            </span>
                            <br>
                            <small>${data.queue_status.pending_jobs} {{ __('admin.pending') }}</small>
                        </div>
                    </div>
                </div>
            `;
            $('#system-health-container').html(html);
        });
    }

    function loadReportFilters(reportType) {
        let filters = '';
        
        switch(reportType) {
            case 'job_performance':
                filters = `
                    <label>{{ __('admin.reports.filter_by_company') }}</label>
                    <select name="company_id" class="form-control">
                        <option value="">{{ __('admin.all_companies') }}</option>
                        <!-- Load companies dynamically -->
                    </select>
                `;
                break;
            case 'user_activity':
                filters = `
                    <label>{{ __('admin.reports.filter_by_role') }}</label>
                    <select name="role" class="form-control">
                        <option value="">{{ __('admin.all_roles') }}</option>
                        <option value="admin">{{ __('admin.admin') }}</option>
                        <option value="company">{{ __('admin.company') }}</option>
                        <option value="candidate">{{ __('admin.candidate') }}</option>
                    </select>
                `;
                break;
        }
        
        $('#additional-filters').html(filters);
    }

    function generateReportPreview(reportType) {
        const formData = $('#reportForm').serialize();
        
        // Show loading
        $('#generateReportBtn i').show();
        $('#generateReportBtn span').text('{{ __("admin.generating") }}');
        
        $.post(`/admin/reports/${reportType.replace('_', '-')}`, formData, function(data) {
            // Display preview
            let previewHtml = '<h5>{{ __("admin.reports.preview") }}</h5>';
            previewHtml += '<div class="table-responsive"><pre>' + JSON.stringify(data, null, 2) + '</pre></div>';
            
            $('#report-preview').html(previewHtml).show();
        }).always(function() {
            $('#generateReportBtn i').hide();
            $('#generateReportBtn span').text('{{ __("admin.reports.generate") }}');
        });
    }

    function exportReport(reportType, format) {
        const formData = $('#reportForm').serialize() + `&report_type=${reportType}&format=${format}`;
        
        $.post('{{ route("admin.reports.export") }}', formData, function(data) {
            if (data.success) {
                window.location.href = data.download_url;
            }
        });
    }
});
</script>
@endpush
@endsection