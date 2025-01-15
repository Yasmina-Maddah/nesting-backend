<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChildrenProfile;
use App\Models\ChildSkill;
use App\Models\ProgressReport;

class ProgressReportController extends Controller
{
    public function generateReport($childId)
    {
        // Fetch child profile
        $child = ChildrenProfile::with('skills')->find($childId);

        if (!$child) {
            return response()->json(['error' => 'Child profile not found'], 404);
        }

        $reports = [];
        foreach ($child->skills as $skill) {
            // Generate progress (this would be dynamic in a real-world case)
            $progress = random_int(50, 100);

            // Identify areas for improvement
            $improvements = [];
            if ($progress < 75) {
                $improvements[] = "Focus more on {$skill->skill_name}.";
            }

            // Save or update report
            $report = ProgressReport::updateOrCreate(
                ['child_skill_id' => $skill->pivot->id],
                [
                    'progress_entry' => $progress,
                    'improvements' => json_encode($improvements),
                ]
            );

            $reports[] = $report;
        }

        return response()->json([
            'message' => 'Progress reports generated successfully.',
            'child' => [
                'name' => $child->name,
                'age' => now()->diffInYears($child->date_of_birth),
                'hobbies' => json_decode($child->hobbies),
            ],
            'reports' => $reports,
        ], 200);
    }

    public function getReport($childId)
    {
        // Fetch child profile
        $child = ChildrenProfile::with('skills', 'skills.progressReports')->find($childId);

        if (!$child) {
            return response()->json(['error' => 'Child profile not found'], 404);
        }

        return response()->json([
            'child' => [
                'name' => $child->name,
                'age' => now()->diffInYears($child->date_of_birth),
                'hobbies' => json_decode($child->hobbies),
            ],
            'reports' => $child->skills->map(function ($skill) {
                return [
                    'skill_name' => $skill->skill_name,
                    'progress_entry' => $skill->progressReports->progress_entry ?? 0,
                    'improvements' => $skill->progressReports->improvements ?? [],
                ];
            }),
        ], 200);
    }
}
