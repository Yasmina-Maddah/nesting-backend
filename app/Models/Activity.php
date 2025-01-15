<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['child_skill_id', 'description', 'status'];

    public function childSkill()
    {
        return $this->belongsTo(ChildSkill::class, 'child_skill_id');
    }
}
