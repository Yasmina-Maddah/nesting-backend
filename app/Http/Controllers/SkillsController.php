<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\ChildSkill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillsController extends Controller
{
    // Fetch all skills
    public function fetchSkills()
    {
        $skills = Skill::all();
        return response()->json(['skills' => $skills]);
    }

    // Assign skill to a child
    public function assignSkill(Request $request)
    {
        $request->validate([
            'child_profile_id' => 'required|exists:children_profiles,id',
            'skill_id' => 'required|exists:skills,id',
        ]);

        // Check if skill already assigned
        $existing = ChildSkill::where('child_id', $request->child_profile_id)
            ->where('skill_id', $request->skill_id)
            ->first();

        if ($existing) {
            return response()->json(['error' => 'Skill already assigned to this child'], 400);
        }

        $childSkill = ChildSkill::create([
            'child_id' => $request->child_profile_id,
            'skill_id' => $request->skill_id,
        ]);

        return response()->json([
            'message' => 'Skill assigned successfully',
            'ai_url' => url('/AIPage/' . $request->child_profile_id . '/' . $request->skill_id),
        ], 201);
    }
}
