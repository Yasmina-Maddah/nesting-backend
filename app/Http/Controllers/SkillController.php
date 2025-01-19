<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChildSkill;
use App\Models\ChildrenProfile;
use App\Models\Skill;

class SkillController extends Controller
{
    public function selectSkill(Request $request, $childId)
    {
        $validated = $request->validate([
            'skill_id' => 'required|exists:skills,id',
        ]);

        $child = ChildrenProfile::find($childId);
        if (!$child) {
            return response()->json(['error' => 'Child not found'], 404);
        }

        $skillId = $validated['skill_id'];

        // Check if the skill is already assigned
        $existingSkill = ChildSkill::where('child_id', $childId)
            ->where('skill_id', $skillId)
            ->first();

        if ($existingSkill) {
            return response()->json(['message' => 'Skill already assigned'], 200);
        }

        // Assign the skill to the child
        $childSkill = ChildSkill::create([
            'child_id' => $childId,
            'skill_id' => $skillId,
            'progress' => 0,
        ]);

        return response()->json([
            'message' => 'Skill selected successfully',
            'child_skill' => $childSkill,
        ], 201);
    }
}
