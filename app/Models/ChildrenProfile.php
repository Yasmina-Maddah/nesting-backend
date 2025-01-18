<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildrenProfile extends Model
{
    use HasFactory;

    protected $fillable = ['parent_id', 'name', 'profile_photo', 'cover_photo', 'date_of_birth', 'hobbies', 'dream_career', 'archived'];

    protected $casts = [
        'hobbies' => 'array',
        'archived' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function moodBoards()
{
    return $this->hasMany(MoodBoard::class);
}


    public function childSkills()
    {
        return $this->hasMany(ChildSkill::class, 'child_id');
    }

    public function interactionLogs()
    {
        return $this->hasMany(InteractionLog::class, 'child_id');
    }

    public function skills()
    {
    return $this->belongsToMany(Skill::class, 'child_skills', 'child_id', 'skill_id')
                ->withPivot('id', 'progress');
    }
}
