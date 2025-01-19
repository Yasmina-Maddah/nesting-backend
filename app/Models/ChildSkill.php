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
    ];

    public function child()
    {
        return $this->belongsTo(ChildrenProfile::class, 'child_id');
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'skill_id');
    }

    public function visualizations()
    {
        return $this->hasMany(AIVisualization::class, 'child_skill_id');
    }
}
