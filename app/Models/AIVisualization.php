<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiVisualization extends Model
{
    use HasFactory;

    // Define the table name (optional, if it follows Laravel conventions)
    protected $table = 'ai_visualizations';

    // Allow mass assignment for these fields
    protected $fillable = [
        'child_id',
        'skill_id',
        'story',
        'challenges',
        'interaction_data',
        'progress_percentage',
    ];

    // Define relationships

    /**
     * Get the child associated with this AI visualization.
     */
    public function child()
    {
        return $this->belongsTo(ChildrenProfile::class, 'child_id');
    }

    /**
     * Get the skill associated with this AI visualization.
     */
    public function skill()
    {
        return $this->belongsTo(Skill::class, 'skill_id');
    }

    /**
     * Format challenges as an array.
     * (Assumes challenges are stored as JSON in the database)
     */
    public function getChallengesAttribute($value)
    {
        return json_decode($value, true);
    }

    /**
     * Format interaction data as an array.
     * (Assumes interaction data is stored as JSON in the database)
     */
    public function getInteractionDataAttribute($value)
    {
        return json_decode($value, true);
    }

    /**
     * Set challenges as JSON before saving to the database.
     */
    public function setChallengesAttribute($value)
    {
        $this->attributes['challenges'] = json_encode($value);
    }

    /**
     * Set interaction data as JSON before saving to the database.
     */
    public function setInteractionDataAttribute($value)
    {
        $this->attributes['interaction_data'] = json_encode($value);
    }

    // Additional helper methods (optional)

    /**
     * Check if the child has completed all challenges.
     */
    public function isCompleted()
    {
        return $this->progress_percentage === 100;
    }

    /**
     * Add a progress increment (e.g., after completing a challenge).
     * @param int $increment
     */
    public function addProgress($increment)
    {
        $this->progress_percentage = min(100, $this->progress_percentage + $increment);
        $this->save();
    }

    /**
     * Reset progress to 0.
     */
    public function resetProgress()
    {
        $this->progress_percentage = 0;
        $this->save();
    }
}
