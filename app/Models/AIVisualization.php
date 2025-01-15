<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiVisualization extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_id', 'skill_id', 'theme', 'prompt', 'generated_story'
    ];

    public function child()
    {
        return $this->belongsTo(ChildrenProfile::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}

