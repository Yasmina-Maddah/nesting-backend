<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiVisualization extends Model
{
    use HasFactory;

    protected $fillable = ['parent_id', 'skill_id', 'theme', 'prompt', 'generated_story'];

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'skill_id');
    }
}
