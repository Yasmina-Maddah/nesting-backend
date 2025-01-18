<?php

namespace App\Http\Controllers;

use App\Models\ChildrenProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChildProfileController extends Controller
{
    // Create Child Profile
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->user_type !== 'parent') {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'hobbies' => 'nullable|string',
            'dream_career' => 'nullable|string',
        ]);

        $child = ChildrenProfile::create([
            'parent_id' => $user->id,
            'name' => $request->name,
            'date_of_birth' => $request->date_of_birth,
            'hobbies' => $request->hobbies,
            'dream_career' => $request->dream_career,
        ]);

        return response()->json([
            'message' => 'Child profile created successfully',
            'child' => [
                'id' => $child->id,
                'name' => $child->name,
                'date_of_birth' => $child->date_of_birth,
                'hobbies' => $child->hobbies,
                'dream_career' => $child->dream_career,
                'profile_photo' => $child->profile_photo ? asset("storage/{$child->profile_photo}") : null,
                'cover_photo' => $child->cover_photo ? asset("storage/{$child->cover_photo}") : null,
            ],
        ], 201);
    }

    // Retrieve All Child Profiles for the Authenticated Parent
    public function index()
    {
        $user = Auth::user();

        if (!$user || $user->user_type !== 'parent') {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        $children = ChildrenProfile::where('parent_id', $user->id)->get();

        return response()->json(['children' => $children->map(function ($child) {
            return [
                'id' => $child->id,
                'name' => $child->name,
                'date_of_birth' => $child->date_of_birth,
                'hobbies' => $child->hobbies,
                'dream_career' => $child->dream_career,
                'profile_photo' => $child->profile_photo ? asset("storage/{$child->profile_photo}") : null,
                'cover_photo' => $child->cover_photo ? asset("storage/{$child->cover_photo}") : null,
            ];
        })]);
    }

    // Retrieve Single Child Profile
    public function show($id)
    {
        $user = Auth::user();

        if (!$user || $user->user_type !== 'parent') {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        $child = ChildrenProfile::where('parent_id', $user->id)->where('id', $id)->first();

        if (!$child) {
            return response()->json(['error' => 'Child profile not found'], 404);
        }

        return response()->json([
            'child' => [
                'id' => $child->id,
                'name' => $child->name,
                'date_of_birth' => $child->date_of_birth,
                'hobbies' => $child->hobbies,
                'dream_career' => $child->dream_career,
                'profile_photo' => $child->profile_photo ? asset("storage/{$child->profile_photo}") : null,
                'cover_photo' => $child->cover_photo ? asset("storage/{$child->cover_photo}") : null,
            ],
        ]);
    }

    // Update Child Profile
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user || $user->user_type !== 'parent') {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        $child = ChildrenProfile::where('parent_id', $user->id)->where('id', $id)->first();

        if (!$child) {
            return response()->json(['error' => 'Child profile not found'], 404);
        }

        $request->validate([
            'name' => 'string|max:255',
            'date_of_birth' => 'date',
            'hobbies' => 'nullable|string',
            'dream_career' => 'nullable|string',
        ]);

        $child->update($request->only(['name', 'date_of_birth', 'hobbies', 'dream_career']));

        return response()->json([
            'message' => 'Child profile updated successfully',
            'child' => [
                'id' => $child->id,
                'name' => $child->name,
                'date_of_birth' => $child->date_of_birth,
                'hobbies' => $child->hobbies,
                'dream_career' => $child->dream_career,
                'profile_photo' => $child->profile_photo ? asset("storage/{$child->profile_photo}") : null,
                'cover_photo' => $child->cover_photo ? asset("storage/{$child->cover_photo}") : null,
            ],
        ]);
    }

    // Upload/Update Cover Photo
    public function uploadCoverPhoto(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user || $user->user_type !== 'parent') {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        $child = ChildrenProfile::where('parent_id', $user->id)->where('id', $id)->first();

        if (!$child) {
            return response()->json(['error' => 'Child profile not found'], 404);
        }

        $request->validate([
            'cover_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($child->cover_photo) {
            Storage::disk('public')->delete($child->cover_photo);
        }

        $path = $request->file('cover_photo')->store('cover_photos', 'public');
        $child->cover_photo = $path;
        $child->save();

        return response()->json([
            'message' => 'Cover photo updated successfully',
            'child' => [
                'id' => $child->id,
                'name' => $child->name,
                'date_of_birth' => $child->date_of_birth,
                'hobbies' => $child->hobbies,
                'dream_career' => $child->dream_career,
                'profile_photo' => $child->profile_photo ? asset("storage/{$child->profile_photo}") : null,
                'cover_photo' => asset("storage/{$child->cover_photo}"),
            ],
        ]);
    }

    // Upload/Update Profile Photo
    public function uploadProfilePhoto(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user || $user->user_type !== 'parent') {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        $child = ChildrenProfile::where('parent_id', $user->id)->where('id', $id)->first();

        if (!$child) {
            return response()->json(['error' => 'Child profile not found'], 404);
        }

        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($child->profile_photo) {
            Storage::disk('public')->delete($child->profile_photo);
        }

        $path = $request->file('profile_photo')->store('profile_photos', 'public');
        $child->profile_photo = $path;
        $child->save();

        return response()->json([
            'message' => 'Profile photo updated successfully',
            'child' => [
                'id' => $child->id,
                'name' => $child->name,
                'date_of_birth' => $child->date_of_birth,
                'hobbies' => $child->hobbies,
                'dream_career' => $child->dream_career,
                'profile_photo' => asset("storage/{$child->profile_photo}"),
                'cover_photo' => $child->cover_photo ? asset("storage/{$child->cover_photo}") : null,
            ],
        ]);
    }

    // Delete Child Profile
    public function destroy($id)
    {
        $user = Auth::user();

        if (!$user || $user->user_type !== 'parent') {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        $child = ChildrenProfile::where('parent_id', $user->id)->where('id', $id)->first();

        if (!$child) {
            return response()->json(['error' => 'Child profile not found'], 404);
        }

        if ($child->profile_photo) {
            Storage::disk('public')->delete($child->profile_photo);
        }

        if ($child->cover_photo) {
            Storage::disk('public')->delete($child->cover_photo);
        }

        $child->delete();

        return response()->json(['message' => 'Child profile deleted successfully']);
    }
}
