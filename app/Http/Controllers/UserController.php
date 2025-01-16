<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getParentDetails(Request $request)
    {
        $user = Auth::user(); // Get the authenticated user
        
        if ($user && $user->user_type === 'parent') {
            return response()->json([
                'username' => $user->username,
                'email' => $user->email,
            ]);
        }

        return response()->json(['error' => 'User not found or not a parent'], 404);
    }
}

