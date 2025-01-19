<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AIVisualization extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_skill_id',
        'story_text',
        'visualization_path',
        'challenges',
    ];

    public function childSkill()
    {
        return $this->belongsTo(ChildSkill::class, 'child_skill_id');
    }
}
