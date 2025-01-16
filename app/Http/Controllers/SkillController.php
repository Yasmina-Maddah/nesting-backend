<?php

namespace App\Http\Controllers;

use App\Models\ChildSkill;
use App\Models\ChildrenProfile;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function selectSkill(Request $request, $id)
    {
        $validated = $request->validate([
            'skill_id' => 'required|exists:skills,id',
        ]);

        $skillId = $validated['skill_id'];

        // Ensure child exists
        $child = ChildrenProfile::find($id);
        if (!$child) {
            return response()->json(['error' => 'Child not found'], 404);
        }

        // Check if the skill is already assigned
        $existingSkill = ChildSkill::where('child_id', $id)
            ->where('skill_id', $skillId)
            ->first();

        if ($existingSkill) {
            return response()->json(['message' => 'Skill already assigned'], 200);
        }

        // Assign the skill to the child
        $childSkill = ChildSkill::create([
            'child_id' => $id,
            'skill_id' => $skillId,
            'progress' => 0, // Default progress
        ]);

        return response()->json([
            'message' => 'Skill selected successfully',
            'child_skill' => $childSkill,
        ], 201);
    }
}
