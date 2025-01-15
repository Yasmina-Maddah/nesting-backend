<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChildSkill;
use App\Models\ChildrenProfile;

class SkillController extends Controller
{
    public function selectSkill(Request $request, $id)
    {
        $validated = $request->validate([
            'skill_id' => 'required|exists:skills,id',
        ]);

        $child = ChildrenProfile::find($id);

        if (!$child) {
            return response()->json(['error' => 'Child profile not found'], 404);
        }

        $childAge = now()->diffInYears($child->date_of_birth);

        if ($childAge < 3 || $childAge > 7) {
            return response()->json(['error' => 'Child age must be between 3 and 7 years'], 400);
        }

        $childSkill = ChildSkill::updateOrCreate(
            ['child_id' => $id, 'skill_id' => $validated['skill_id']],
            ['progress' => 0]
        );

        return response()->json(['message' => 'Skill selected successfully', 'childSkill' => $childSkill], 200);
    }
}
