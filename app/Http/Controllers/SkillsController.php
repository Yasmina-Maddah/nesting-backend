<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\ChildSkill;
use App\Models\ChildrenProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillsController extends Controller
{
    public function fetchSkills()
    {
        $skills = Skill::all();
        return response()->json(['skills' => $skills], 200);
    }

    public function assignSkill(Request $request)
    {
        $request->validate([
            'children_id' => 'required|exists:children_profiles,id',
            'skill_id' => 'required|exists:skills,id',
        ]);

        $child = ChildrenProfile::where('id', $request->children_id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$child) {
            return response()->json(['error' => 'Child not found or does not belong to the authenticated user'], 403);
        }

        $childSkill = ChildSkill::create([
            'child_id' => $request->children_id,
            'skill_id' => $request->skill_id,
        ]);

        return response()->json([
            'message' => 'Skill assigned successfully',
            'child_skill' => $childSkill,
            'ai_url' => url('/ai/' . $childSkill->child_skill_id),
        ], 201);
    }

    public function fetchAssignedSkill($children_id)
    {
        $childSkill = ChildSkill::with('skill')
            ->where('child_id', $children_id)
            ->whereHas('child', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->first();

        if (!$childSkill) {
            return response()->json(['error' => 'No skill assigned to this child or child not found'], 404);
        }

        return response()->json(['assigned_skill' => $childSkill->skill], 200);
    }

    public function updateAssignedSkill(Request $request)
    {
        $request->validate([
            'children_id' => 'required|exists:children_profiles,id', 
            'skill_id' => 'required|exists:skills,id',
        ]);

        $childSkill = ChildSkill::where('child_id', $request->children_id)
            ->whereHas('child', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->first();

        if (!$childSkill) {
            return response()->json(['error' => 'No skill assigned to this child or child not found'], 404);
        }

        $childSkill->update(['skill_id' => $request->skill_id]);

        return response()->json([
            'message' => 'Skill updated successfully',
            'updated_skill' => $childSkill,
        ], 200);
    }

    public function removeAssignedSkill($children_id)
    {
        $childSkill = ChildSkill::where('child_id', $children_id)
            ->whereHas('child', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->first();

        if (!$childSkill) {
            return response()->json(['error' => 'No skill assigned to this child or child not found'], 404);
        }

        $childSkill->delete();

        return response()->json(['message' => 'Assigned skill removed successfully'], 200);
    }
}
