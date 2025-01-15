<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgressReport extends Model
{
    use HasFactory;

    protected $fillable = ['child_skill_id', 'progress_entry', 'details'];

    protected $casts = [
        'details' => 'array',
    ];

    public function childSkill()
    {
        return $this->belongsTo(ChildSkill::class, 'child_skill_id');
    }
}

