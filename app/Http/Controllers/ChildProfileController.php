<?php

namespace App\Http\Controllers;

use App\Models\ChildrenProfile;
use App\Models\MoodBoard;
use Illuminate\Http\Request;

class ChildProfileController extends Controller
{
    /**
     * Create a new child profile.
     */
    public function store(Request $request)
{
    $request->validate([
        'parent_id' => 'required|exists:users,id', // Validate parent_id instead of user_id
        'name' => 'required|string|max:255',
        'date_of_birth' => 'required|date',
        'hobbies' => 'nullable|string',
        'dream_career' => 'nullable|string',
    ]);

    try {
        $child = ChildrenProfile::create([
            'parent_id' => $request->parent_id, // Use parent_id
            'name' => $request->name,
            'date_of_birth' => $request->date_of_birth,
            'hobbies' => $request->hobbies,
            'dream_career' => $request->dream_career,
        ]);

        return response()->json([
            'message' => 'Child profile created successfully',
            'child_id' => $child->id,
        ], 201);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Failed to create child profile',
            'details' => $e->getMessage(),
        ], 500);
    }
}


    /**
     * View a specific child profile.
     */
    public function show($id)
    {
        $child = ChildrenProfile::with('moodBoards')->findOrFail($id);
        return response()->json($child, 200);
    }

    /**
     * Update a child profile.
     */
    public function update(Request $request, $id)
    {
        $child = ChildrenProfile::findOrFail($id);

        $request->validate([
            'name' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'hobbies' => 'nullable|string',
            'dream_career' => 'nullable|string',
        ]);

        $child->update($request->only(['name', 'date_of_birth', 'hobbies', 'dream_career']));

        return response()->json(['message' => 'Child profile updated successfully', 'data' => $child], 200);
    }

    /**
     * Delete a child profile.
     */
    public function destroy($id)
    {
        $child = ChildrenProfile::findOrFail($id);
        $child->delete();

        return response()->json(['message' => 'Child profile deleted successfully'], 200);
    }

    /**
     * Upload a cover photo for a child profile.
     */
    public function uploadCoverPhoto(Request $request, $id)
    {
        $request->validate([
            'cover_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $child = ChildrenProfile::findOrFail($id);

        $path = $request->file('cover_photo')->store('cover_photos', 'public');
        $child->cover_photo = $path;
        $child->save();

        return response()->json(['message' => 'Cover photo uploaded successfully', 'path' => $path], 200);
    }

    /**
     * Upload a profile photo for a child profile.
     */
    public function uploadProfilePhoto(Request $request, $id)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $child = ChildrenProfile::findOrFail($id);

        $path = $request->file('profile_photo')->store('profile_photos', 'public');
        $child->profile_photo = $path;
        $child->save();

        return response()->json(['message' => 'Profile photo uploaded successfully', 'path' => $path], 200);
    }

    /**
     * Add a mood board for a child profile.
     */
    public function addMoodBoard(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
        ]);

        $child = ChildrenProfile::findOrFail($id);

        $path = $request->file('image')->store('mood_boards', 'public');

        $moodBoard = $child->moodBoards()->create([
            'image' => $path,
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Mood board added successfully', 'data' => $moodBoard], 201);
    }
}
