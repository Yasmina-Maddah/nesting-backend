<?php

namespace App\Http\Controllers;

use App\Models\ChildrenProfile;

class DashboardController extends Controller
{
    // GET /dashboard/{parentId}
    public function getDashboardData($parentId)
    {
        $profiles = ChildrenProfile::where('parent_id', $parentId)->get();

        return response()->json($profiles);
    }
}
