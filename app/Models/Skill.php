<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'skill_name',
        'description',
    ];

    // Relationships
    public function childSkills()
    {
        return $this->hasMany(ChildSkill::class, 'skill_id');
    }

    public function aiVisualizations()
    {
        return $this->hasMany(AIVisualization::class, 'skill_id');
    }
}
