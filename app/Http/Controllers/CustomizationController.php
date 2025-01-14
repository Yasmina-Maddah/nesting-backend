<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChildrenProfile;

class CustomizationController extends Controller
{
    // GET /profile/customization/{id}
    public function getCustomization($id)
    {
        $profile = ChildrenProfile::find($id);

        if (!$profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        return response()->json([
            'date_of_birth' => $profile->date_of_birth,
            'hobbies' => json_decode($profile->hobbies),
            'dream_career' => $profile->dream_career,
        ]);
    }

    // PUT /profile/customization/{id}
    public function updateCustomization(Request $request, $id)
    {
        $profile = ChildrenProfile::find($id);

        if (!$profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        $validatedData = $request->validate([
            'date_of_birth' => 'date',
            'hobbies' => 'array',
            'dream_career' => 'string|max:255',
        ]);

        if ($request->has('hobbies')) {
            $validatedData['hobbies'] = json_encode($request->hobbies);
        }

        $profile->update($validatedData);

        return response()->json(['message' => 'Customization updated successfully']);
    }
}
