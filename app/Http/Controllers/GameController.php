<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Search for games based on a keyword.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $query = $request->input('keyword');

        if (!$query) {
            return response()->json([
                'message' => 'Keyword is required for search.',
            ], 400);
        }

        // Search games by title or description
        $games = Game::where('title', 'LIKE', "%{$query}%")
            ->get(['id', 'title', 'link', 'image', 'created_at']);

        return response()->json($games);
    }

    /**
     * Fetch all games.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $games = Game::all(['id', 'title', 'link', 'image', 'created_at']);

        return response()->json($games);
    }

    /**
     * Show details of a specific game.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $game = Game::find($id);

        if (!$game) {
            return response()->json([
                'message' => 'Game not found.',
            ], 404);
        }

        return response()->json($game);
    }
}
