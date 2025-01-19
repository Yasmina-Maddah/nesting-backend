<?php

namespace App\Http\Controllers;

use App\Models\ChildProfile;
use Illuminate\Http\Request;

class ChildProfileController extends Controller
{
    // Fetch all profiles for the authenticated user
    public function index()
    {
        $profiles = ChildProfile::where('user_id', auth()->id())->get();
        return response()->json($profiles);
    }

    // Create a new profile
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'date_of_birth' => 'required|date',
            'hobbies' => 'nullable|string',
            'dream_job' => 'nullable|string|max:100',
        ]);

        $profile = ChildProfile::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'date_of_birth' => $request->date_of_birth,
            'hobbies' => $request->hobbies,
            'dream_job' => $request->dream_job,
        ]);

        return response()->json(['message' => 'Profile created successfully', 'profile' => $profile], 201);
    }

    // Retrieve a specific profile
    public function show($id)
    {
        $profile = ChildProfile::where('id', $id)->where('user_id', auth()->id())->first();

        if (!$profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        return response()->json($profile);
    }

    // Update a specific profile
    public function update(Request $request, $id)
    {
        $profile = ChildProfile::where('id', $id)->where('user_id', auth()->id())->first();

        if (!$profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        $request->validate([
            'name' => 'nullable|string|max:100',
            'date_of_birth' => 'nullable|date',
            'hobbies' => 'nullable|string',
            'dream_job' => 'nullable|string|max:100',
        ]);

        $profile->update($request->only('name', 'date_of_birth', 'hobbies', 'dream_job'));

        return response()->json(['message' => 'Profile updated successfully', 'profile' => $profile]);
    }

    // Delete a specific profile
    public function destroy($id)
    {
        $profile = ChildProfile::where('id', $id)->where('user_id', auth()->id())->first();

        if (!$profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        $profile->delete();

        return response()->json(['message' => 'Profile deleted successfully']);
    }
}
