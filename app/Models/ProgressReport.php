<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgressReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_skill_id',
        'progress_entry',
    ];

    // Relationships
    public function childSkill()
    {
        return $this->belongsTo(ChildSkill::class, 'child_skill_id');
    }
}
