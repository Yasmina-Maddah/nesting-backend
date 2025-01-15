<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = ['skill_name', 'description', 'image_path', 'parent_skill_id'];

    public function parentSkill()
    {
        return $this->belongsTo(Skill::class, 'parent_skill_id');
    }

    public function childSkills()
    {
        return $this->hasMany(ChildSkill::class, 'skill_id');
    }

    public function aiVisualizations()
    {
        return $this->hasMany(AiVisualization::class, 'skill_id');
    }

    public function progressReports()
    {
    return $this->hasOne(ProgressReport::class, 'child_skill_id');
    }
}
