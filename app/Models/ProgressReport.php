<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgressReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_id',
        'skill_id',
        'interaction_summary',
        'progress_score',
    ];

    public function child()
    {
        return $this->belongsTo(ChildProfile::class, 'child_id');
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'skill_id');
    }
}
