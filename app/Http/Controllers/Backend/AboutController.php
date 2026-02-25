<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutSection;
use App\Models\AboutValue;
use App\Models\AboutProcess;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function edit()
    {
        $aboutSection = AboutSection::first();
        $values = AboutValue::orderBy('sort_order')->get();
        $processes = AboutProcess::orderBy('step_number')->get();
        $teamMembers = TeamMember::orderBy('sort_order')->get();

        return view('back-end.about.edit', compact(
            'aboutSection',
            'values',
            'processes',
            'teamMembers'
        ));
    }

    public function update(Request $request)
    {
        $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_description' => 'required|string',
            'story_title' => 'required|string|max:255',
            'story_description' => 'required|string',
            'years_experience' => 'required|string',
            'happy_customers' => 'required|string',
            'story_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $aboutSection = AboutSection::first() ?? new AboutSection();

        if ($request->hasFile('story_image')) {
            if ($aboutSection->story_image) {
                Storage::delete('public/about/' . $aboutSection->story_image);
            }
            $imageName = time() . '.' . $request->story_image->extension();
            $request->story_image->storeAs('public/about', $imageName);
            $aboutSection->story_image = $imageName;
        }

        $aboutSection->fill($request->except('story_image'));
        $aboutSection->save();

        return redirect()->back()->with('success', 'About section updated successfully');
    }

    public function updateValues(Request $request)
    {
        $request->validate([
            'values.*.title' => 'required|string|max:255',
            'values.*.description' => 'required|string',
            'values.*.icon' => 'required|string',
        ]);

        foreach ($request->values as $valueData) {
            AboutValue::updateOrCreate(
                ['id' => $valueData['id'] ?? null],
                $valueData
            );
        }

        return redirect()->back()->with('success', 'Values updated successfully');
    }

    public function updateProcesses(Request $request)
    {
        $request->validate([
            'processes.*.title' => 'required|string|max:255',
            'processes.*.description' => 'required|string',
            'processes.*.step_number' => 'required|integer|min:1',
        ]);

        foreach ($request->processes as $processData) {
            AboutProcess::updateOrCreate(
                ['id' => $processData['id'] ?? null],
                $processData
            );
        }

        return redirect()->back()->with('success', 'Processes updated successfully');
    }

    public function updateTeamMembers(Request $request)
    {
        $request->validate([
            'team_members.*.name' => 'required|string|max:255',
            'team_members.*.position' => 'required|string|max:255',
            'team_members.*.description' => 'required|string',
            'team_members.*.image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        foreach ($request->team_members as $memberData) {
            $member = TeamMember::findOrNew($memberData['id'] ?? null);

            if (isset($memberData['image']) && $memberData['image']->isValid()) {
                if ($member->image) {
                    Storage::delete('public/team/' . $member->image);
                }
                $imageName = time() . '_' . uniqid() . '.' . $memberData['image']->extension();
                $memberData['image']->storeAs('public/team', $imageName);
                $member->image = $imageName;
            }

            $member->fill($memberData);
            $member->save();
        }

        return redirect()->back()->with('success', 'Team members updated successfully');
    }
}
