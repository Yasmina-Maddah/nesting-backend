<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MoodBoard;
use Illuminate\Support\Facades\Storage;

class MoodBoardController extends Controller
{
    // GET /profile/{childProfileId}/mood-board
    public function getMoodBoard($childProfileId)
    {
        $moodBoard = MoodBoard::where('child_profile_id', $childProfileId)->get();

        return response()->json($moodBoard);
    }

    // POST /profile/{childProfileId}/mood-board
    public function createMoodBoard(Request $request, $childProfileId)
    {
        $validatedData = $request->validate([
            'image_path' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'string|max:255',
        ]);

        if ($request->hasFile('image_path')) {
            $validatedData['image_path'] = $request->file('image_path')->store('mood_boards', 'public');
        }

        $validatedData['child_profile_id'] = $childProfileId;
        $moodBoard = MoodBoard::create($validatedData);

        return response()->json(['message' => 'Mood board created', 'data' => $moodBoard]);
    }

    // DELETE /profile/{childProfileId}/mood-board/{id}
    public function deleteMoodBoard($id)
    {
        $moodBoard = MoodBoard::find($id);

        if (!$moodBoard) {
            return response()->json(['message' => 'Mood board item not found'], 404);
        }

        Storage::disk('public')->delete($moodBoard->image_path);
        $moodBoard->delete();

        return response()->json(['message' => 'Mood board item deleted']);
    }
}
