@extends('admin.layouts.app')

@section('title', __('admin.website.title'))

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-palette text-primary"></i> {{ __('admin.website.customization') }}
            </h1>
            <p class="text-muted mt-2">{{ __('admin.website.customize_appearance') }}</p>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Customization Tabs -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <ul class="nav nav-tabs nav-pills" id="customizationTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#appearance">
                        <i class="fas fa-paint-brush"></i> {{ __('admin.website.appearance') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#branding">
                        <i class="fas fa-trademark"></i> {{ __('admin.website.branding') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#homepage">
                        <i class="fas fa-home"></i> {{ __('admin.website.homepage') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#layout">
                        <i class="fas fa-th-large"></i> {{ __('admin.website.layout') }}
                    </a>
                </li>
            </ul>

            <div class="tab-content mt-4">
                <!-- Appearance Tab -->
                <div class="tab-pane fade show active" id="appearance">
                    <form action="{{ route('admin.website.update-appearance') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin.website.theme') }}</label>
                                    <select name="theme" class="form-control">
                                        <option value="light">{{ __('admin.website.light_theme') }}</option>
                                        <option value="dark">{{ __('admin.website.dark_theme') }}</option>
                                        <option value="auto">{{ __('admin.website.auto_theme') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin.website.font_family') }}</label>
                                    <select name="font_family" class="form-control">
                                        <option value="Inter">Inter</option>
                                        <option value="Roboto">Roboto</option>
                                        <option value="Open Sans">Open Sans</option>
                                        <option value="Lato">Lato</option>
                                        <option value="Poppins">Poppins</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin.website.primary_color') }}</label>
                                    <input type="color" name="primary_color" class="form-control" value="#667eea">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin.website.secondary_color') }}</label>
                                    <input type="color" name="secondary_color" class="form-control" value="#764ba2">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> {{ __('admin.save_changes') }}
                        </button>
                    </form>
                </div>

                <!-- Branding Tab -->
                <div class="tab-pane fade" id="branding">
                    <form action="{{ route('admin.website.update-branding') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin.website.site_name') }}</label>
                                    <input type="text" name="site_name" class="form-control" value="{{ config('app.name') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin.website.site_tagline') }}</label>
                                    <input type="text" name="site_tagline" class="form-control" placeholder="{{ __('admin.website.tagline_placeholder') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin.website.logo') }}</label>
                                    <input type="file" name="logo" class="form-control" accept="image/*">
                                    <small class="text-muted">{{ __('admin.website.logo_help') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin.website.favicon') }}</label>
                                    <input type="file" name="favicon" class="form-control" accept="image/*">
                                    <small class="text-muted">{{ __('admin.website.favicon_help') }}</small>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> {{ __('admin.save_changes') }}
                        </button>
                    </form>
                </div>

                <!-- Homepage Tab -->
                <div class="tab-pane fade" id="homepage">
                    <form action="{{ route('admin.website.update-homepage') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin.website.hero_title') }}</label>
                                    <input type="text" name="hero_title" class="form-control" value="Find Your Dream Job" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin.website.hero_subtitle') }}</label>
                                    <textarea name="hero_subtitle" class="form-control" rows="2">Connect with top companies and opportunities</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check mb-3">
                                    <input type="checkbox" name="show_stats" class="form-check-input" id="showStats" value="1" checked>
                                    <label class="form-check-label" for="showStats">
                                        {{ __('admin.website.show_statistics') }}
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input type="checkbox" name="show_featured_jobs" class="form-check-input" id="showFeaturedJobs" value="1" checked>
                                    <label class="form-check-label" for="showFeaturedJobs">
                                        {{ __('admin.website.show_featured_jobs') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check mb-3">
                                    <input type="checkbox" name="show_featured_companies" class="form-check-input" id="showFeaturedCompanies" value="1" checked>
                                    <label class="form-check-label" for="showFeaturedCompanies">
                                        {{ __('admin.website.show_featured_companies') }}
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input type="checkbox" name="show_testimonials" class="form-check-input" id="showTestimonials" value="1" checked>
                                    <label class="form-check-label" for="showTestimonials">
                                        {{ __('admin.website.show_testimonials') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> {{ __('admin.save_changes') }}
                        </button>
                    </form>
                </div>

                <!-- Layout Tab -->
                <div class="tab-pane fade" id="layout">
                    <form action="{{ route('admin.website.update-layout') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin.website.header_style') }}</label>
                                    <select name="header_style" class="form-control">
                                        <option value="transparent">{{ __('admin.website.transparent_header') }}</option>
                                        <option value="solid">{{ __('admin.website.solid_header') }}</option>
                                        <option value="sticky">{{ __('admin.website.sticky_header') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin.website.footer_style') }}</label>
                                    <select name="footer_style" class="form-control">
                                        <option value="minimal">{{ __('admin.website.minimal_footer') }}</option>
                                        <option value="standard">{{ __('admin.website.standard_footer') }}</option>
                                        <option value="extended">{{ __('admin.website.extended_footer') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <hr>
                                <h5>{{ __('admin.website.social_links') }}</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Facebook URL</label>
                                    <input type="url" name="facebook_url" class="form-control" placeholder="https://facebook.com/yourpage">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Twitter URL</label>
                                    <input type="url" name="twitter_url" class="form-control" placeholder="https://twitter.com/yourhandle">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>LinkedIn URL</label>
                                    <input type="url" name="linkedin_url" class="form-control" placeholder="https://linkedin.com/company/yourcompany">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Instagram URL</label>
                                    <input type="url" name="instagram_url" class="form-control" placeholder="https://instagram.com/yourhandle">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-check mb-3">
                                    <input type="checkbox" name="show_social_links" class="form-check-input" id="showSocialLinks" value="1" checked>
                                    <label class="form-check-label" for="showSocialLinks">
                                        {{ __('admin.website.show_social_links') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> {{ __('admin.save_changes') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.nav-pills .nav-link {
    color: #6c757d;
    border-radius: 20px;
    padding: 10px 20px;
    margin-right: 10px;
    transition: all 0.3s;
}

.nav-pills .nav-link:hover {
    background-color: #f8f9fa;
}

.nav-pills .nav-link.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}
</style>
@endsection