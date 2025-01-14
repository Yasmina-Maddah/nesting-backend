<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChildrenProfile;

class ProfileController extends Controller
{
    // GET /profile/{id}
    public function showProfile($id)
    {
        $profile = ChildrenProfile::find($id);

        if (!$profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        return response()->json($profile);
    }

    // PUT /profile/{id}
    public function updateProfile(Request $request, $id)
    {
        $profile = ChildrenProfile::find($id);

        if (!$profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'date_of_birth' => 'date',
            'hobbies' => 'array',
            'dream_career' => 'string|max:255',
        ]);

        if ($request->has('hobbies')) {
            $validatedData['hobbies'] = json_encode($request->hobbies);
        }

        $profile->update($validatedData);

        return response()->json(['message' => 'Profile updated successfully']);
    }

    // POST /profile/{id}/photo
    public function uploadProfilePhoto(Request $request, $id)
    {
        $profile = ChildrenProfile::find($id);

        if (!$profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        $request->validate(['profile_photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048']);

        $path = $request->file('profile_photo')->store('profile_photos', 'public');
        $profile->update(['profile_photo' => $path]);

        return response()->json(['message' => 'Profile photo updated', 'path' => $path]);
    }

    // POST /profile/{id}/cover
    public function uploadCoverPhoto(Request $request, $id)
    {
        $profile = ChildrenProfile::find($id);

        if (!$profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        $request->validate(['cover_photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048']);

        $path = $request->file('cover_photo')->store('cover_photos', 'public');
        $profile->update(['cover_photo' => $path]);

        return response()->json(['message' => 'Cover photo updated', 'path' => $path]);
    }
}
