<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $games = Game::all(); // Fetch all games
        return response()->json($games);
    }

    public function update(Request $request, $id)
    {
    $game = Game::findOrFail($id);
    $game->update($request->all());

    return response()->json(['message' => 'Game updated successfully', 'game' => $game]);
    }

    public function destroy($id)
    {
    $game = Game::findOrFail($id);
    $game->delete();

    return response()->json(['message' => 'Game deleted successfully']);
    }


}
