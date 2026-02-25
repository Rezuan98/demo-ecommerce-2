<?php

namespace App\Http\Controllers;
use App\Http\Controllers;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Brian2694\Toastr\Facades\Toastr;

class SiteSettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::first() ?? new SiteSetting();
        return view('back-end.setting.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Debug the incoming request data
        \Log::info('Incoming Request Data:', $request->all());
    
        try {
            // Get or create settings
            $settings = SiteSetting::first();
            if (!$settings) {
                $settings = new SiteSetting();
            }
    
            \Log::info('Settings Before Update:', $settings->toArray());
    
            // Handle logo upload
            if ($request->hasFile('logo')) {
                if ($settings->logo && Storage::disk('public')->exists($settings->logo)) {
                    Storage::disk('public')->delete($settings->logo);
                }
                $logo = $request->file('logo');
                $logoName = 'logo_' . time() . '.' . $logo->getClientOriginalExtension();
                $logo->storeAs('settings', $logoName, 'public');
                $settings->logo = 'settings/' . $logoName;
            }
    
            // Handle favicon upload
            if ($request->hasFile('favicon')) {
                if ($settings->favicon && Storage::disk('public')->exists($settings->favicon)) {
                    Storage::disk('public')->delete($settings->favicon);
                }
                $favicon = $request->file('favicon');
                $faviconName = 'favicon_' . time() . '.' . $favicon->getClientOriginalExtension();
                $favicon->storeAs('settings', $faviconName, 'public');
                $settings->favicon = 'settings/' . $faviconName;
            }
    
            // Explicitly set each field
            $settings->site_name = $request->input('site_name');
            $settings->phone = $request->input('phone');
            $settings->email = $request->input('email');
            $settings->address = $request->input('address');
            $settings->footer_description = $request->input('footer_description');
            $settings->facebook_url = $request->input('facebook_url');
            $settings->instagram_url = $request->input('instagram_url');
            $settings->youtube_url = $request->input('youtube_url');
    
            \Log::info('Settings After Assignment:', $settings->toArray());
    
            // Save with debug information
            $saved = $settings->save();
            
            \Log::info('Save Result:', ['saved' => $saved]);
            \Log::info('Settings After Save:', $settings->fresh()->toArray());
    
            if (!$saved) {
                throw new \Exception('Failed to save settings');
            }
    
            Toastr::success('Settings updated successfully!');
            return redirect()->back();
    
        } catch (\Exception $e) {
            \Log::error('Settings Update Error: ' . $e->getMessage());
            \Log::error('Stack Trace: ' . $e->getTraceAsString());
            Toastr::error('Error updating settings: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
}

