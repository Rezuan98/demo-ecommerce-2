<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use App\Models\AboutValue;
use App\Models\AboutProcess;
use App\Models\TeamMember;

class AboutController extends Controller
{
    public function index()
    {
        $aboutSection = AboutSection::where('status', true)->first();
        $values = AboutValue::where('status', true)->orderBy('sort_order')->get();
        $processes = AboutProcess::where('status', true)->orderBy('step_number')->get();
        $teamMembers = TeamMember::where('status', true)->orderBy('sort_order')->get();

        return view('frontend.pages.about', compact(
            'aboutSection',
            'values',
            'processes',
            'teamMembers'
        ));
    }
}
