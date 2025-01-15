<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function getWelcomeMessage()
    {
        $user = Auth::user();

        if ($user) {
            return response()->json([
                'message' => 'Welcome, ' . $user->username . '!',
            ], 200);
        }

        return response()->json([
            'error' => 'User not authenticated.',
        ], 401);
    }
}
