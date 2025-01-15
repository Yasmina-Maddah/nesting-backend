<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildSkill extends Model
{
    use HasFactory;

    protected $fillable = ['child_id', 'skill_id', 'progress'];

    public function child()
    {
        return $this->belongsTo(ChildrenProfile::class, 'child_id');
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'skill_id');
    }

    public function progressReports()
    {
        return $this->hasMany(ProgressReport::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'child_skill_id');
    }

    public function skills()
    {
    return $this->belongsToMany(Skill::class, 'child_skills', 'child_id', 'skill_id')
                ->withPivot('id', 'progress');
    }
}
