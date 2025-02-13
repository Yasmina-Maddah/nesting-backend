<?php

namespace App\Http\Controllers;

use App\Models\ChildrenProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class ChildrenProfileController extends Controller
{
    public function createProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'date_of_birth' => 'required|date',
            'hobbies' => 'nullable|string',
            'dream_job' => 'nullable|string',
        ]);

        $birthDate = Carbon::parse($request->date_of_birth);
        $age = $birthDate->age;

        if ($age < 3 || $age > 7) {
           return response()->json(['error' => 'Child must be between 3 and 7 years old'], 400);
        }

        $profile = ChildrenProfile::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'date_of_birth' => $request->date_of_birth,
            'hobbies' => $request->hobbies,
            'dream_job' => $request->dream_job,
        ]);

        return response()->json([
            'message' => 'Child profile created successfully',
            'profile' => $profile,
            'skills_url' => url('http://localhost:3000/Skills' . $profile->id), 
        ], 201);
    }

    public function getProfiles()
    {
        $profiles = ChildrenProfile::where('user_id', Auth::id())->get();

        return response()->json(['profiles' => $profiles]);
    }

    public function updateProfile(Request $request, $id)
    {
        $profile = ChildrenProfile::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$profile) {
            return response()->json(['error' => 'Profile not found'], 404);
        }

        $profile->update($request->only(['name', 'date_of_birth', 'hobbies', 'dream_job']));

        return response()->json([
            'message' => 'Child profile updated successfully',
            'profile' => $profile,
        ]);
    }

    public function deleteProfile($id)
    {
        $profile = ChildrenProfile::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$profile) {
            return response()->json(['error' => 'Profile not found'], 404);
        }

        $profile->delete();

        return response()->json(['message' => 'Child profile deleted successfully']);
    }
}
