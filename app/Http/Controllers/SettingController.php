<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::getSettings();
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'university_name' => 'required|string|max:255',
            'academic_year' => 'required|string|max:255',
            'current_semester' => 'required|integer|min:1|max:9',
            'attendance_status' => 'required|in:Open,Closed',
        ]);

        $settings = Setting::getSettings();
        $settings->update($validated);

        return redirect()->route('settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}
