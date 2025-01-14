<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildSkill extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_id',
        'skill_id',
        'progress',
    ];

    // Relationships
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
        return $this->hasMany(ProgressReport::class, 'child_skill_id');
    }
}
