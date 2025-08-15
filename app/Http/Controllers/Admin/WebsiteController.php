<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Admin Website Customization Controller
 * Implements: REQ-ADM-009 to REQ-ADM-012
 * 
 * Handles website customization and theme management
 */
class WebsiteController extends Controller
{
    /**
     * Display website customization dashboard
     */
    public function index()
    {
        $settings = WebsiteSetting::whereIn('group', ['appearance', 'branding', 'homepage', 'layout'])
                                  ->get()
                                  ->groupBy('group');

        return view('admin.website.index', compact('settings'));
    }

    /**
     * Update website appearance settings
     */
    public function updateAppearance(Request $request)
    {
        $request->validate([
            'theme' => 'required|in:light,dark,auto',
            'primary_color' => 'required|regex:/^#[0-9A-F]{6}$/i',
            'secondary_color' => 'required|regex:/^#[0-9A-F]{6}$/i',
            'font_family' => 'required|string',
        ]);

        foreach ($request->all() as $key => $value) {
            if ($key !== '_token') {
                WebsiteSetting::updateOrCreate(
                    ['key' => $key, 'group' => 'appearance'],
                    ['value' => $value, 'type' => 'string']
                );
            }
        }

        return redirect()
            ->route('admin.website.index')
            ->with('success', __('admin.website.appearance_updated'));
    }

    /**
     * Update branding settings
     */
    public function updateBranding(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_tagline' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'favicon' => 'nullable|image|max:512',
        ]);

        $data = $request->except(['logo', 'favicon']);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $oldLogo = WebsiteSetting::where('key', 'logo')->first();
            if ($oldLogo && Storage::exists($oldLogo->value)) {
                Storage::delete($oldLogo->value);
            }
            $data['logo'] = $request->file('logo')->store('website', 'public');
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            $oldFavicon = WebsiteSetting::where('key', 'favicon')->first();
            if ($oldFavicon && Storage::exists($oldFavicon->value)) {
                Storage::delete($oldFavicon->value);
            }
            $data['favicon'] = $request->file('favicon')->store('website', 'public');
        }

        foreach ($data as $key => $value) {
            WebsiteSetting::updateOrCreate(
                ['key' => $key, 'group' => 'branding'],
                ['value' => $value, 'type' => 'string']
            );
        }

        return redirect()
            ->route('admin.website.index')
            ->with('success', __('admin.website.branding_updated'));
    }

    /**
     * Update homepage settings
     */
    public function updateHomepage(Request $request)
    {
        $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'nullable|string|max:500',
            'show_stats' => 'boolean',
            'show_featured_jobs' => 'boolean',
            'show_featured_companies' => 'boolean',
            'show_testimonials' => 'boolean',
        ]);

        foreach ($request->all() as $key => $value) {
            if ($key !== '_token') {
                WebsiteSetting::updateOrCreate(
                    ['key' => $key, 'group' => 'homepage'],
                    ['value' => $value, 'type' => is_bool($value) ? 'boolean' : 'string']
                );
            }
        }

        return redirect()
            ->route('admin.website.index')
            ->with('success', __('admin.website.homepage_updated'));
    }

    /**
     * Update header/footer settings
     */
    public function updateLayout(Request $request)
    {
        $request->validate([
            'header_style' => 'required|in:transparent,solid,sticky',
            'footer_style' => 'required|in:minimal,standard,extended',
            'show_social_links' => 'boolean',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
        ]);

        foreach ($request->all() as $key => $value) {
            if ($key !== '_token') {
                WebsiteSetting::updateOrCreate(
                    ['key' => $key, 'group' => 'layout'],
                    ['value' => $value, 'type' => is_bool($value) ? 'boolean' : 'string']
                );
            }
        }

        return redirect()
            ->route('admin.website.index')
            ->with('success', __('admin.website.layout_updated'));
    }
}