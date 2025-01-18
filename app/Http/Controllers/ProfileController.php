<?php

// app/Http/Controllers/ChildProfileController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChildrenProfile;
use Illuminate\Support\Facades\Auth;

class Profile extends Controller
{
    // Store a new child profile
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'profile_photo' => 'nullable|image',
            'cover_photo' => 'nullable|image',
            'date_of_birth' => 'nullable|date',
            'hobbies' => 'nullable|string',
            'dream_career' => 'nullable|string',
        ]);

        $childProfile = new ChildProfile();
        $childProfile->parent_id = Auth::id();
        $childProfile->name = $validated['name'];
        $childProfile->profile_photo = $request->file('profile_photo')?->store('profile_photos', 'public');
        $childProfile->cover_photo = $request->file('cover_photo')?->store('cover_photos', 'public');
        $childProfile->date_of_birth = $validated['date_of_birth'];
        $childProfile->hobbies = $validated['hobbies'];
        $childProfile->dream_career = $validated['dream_career'];
        $childProfile->save();

        return response()->json(['message' => 'Child profile created successfully', 'data' => $childProfile], 201);
    }

    // Get a specific child profile
    public function show($id)
    {
        $childProfile = ChildProfile::where('parent_id', Auth::id())->findOrFail($id);
        return response()->json($childProfile);
    }

    // Update a child profile
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'profile_photo' => 'nullable|image',
            'cover_photo' => 'nullable|image',
            'date_of_birth' => 'nullable|date',
            'hobbies' => 'nullable|string',
            'dream_career' => 'nullable|string',
        ]);

        $childProfile = ChildProfile::where('parent_id', Auth::id())->findOrFail($id);

        $childProfile->name = $validated['name'] ?? $childProfile->name;
        if ($request->hasFile('profile_photo')) {
            $childProfile->profile_photo = $request->file('profile_photo')->store('profile_photos', 'public');
        }
        if ($request->hasFile('cover_photo')) {
            $childProfile->cover_photo = $request->file('cover_photo')->store('cover_photos', 'public');
        }
        $childProfile->date_of_birth = $validated['date_of_birth'] ?? $childProfile->date_of_birth;
        $childProfile->hobbies = $validated['hobbies'] ?? $childProfile->hobbies;
        $childProfile->dream_career = $validated['dream_career'] ?? $childProfile->dream_career;
        $childProfile->save();

        return response()->json(['message' => 'Child profile updated successfully', 'data' => $childProfile]);
    }

    // Delete a child profile
    public function destroy($id)
    {
        $childProfile = Profile::where('parent_id', Auth::id())->findOrFail($id);
        $childProfile->delete();

        return response()->json(['message' => 'Child profile deleted successfully']);
    }
}
