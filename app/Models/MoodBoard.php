<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildrenProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'profile_photo',
        'cover_photo',
        'date_of_birth',
        'hobbies',
        'dream_career',
    ];

    // Relationships
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function skills()
    {
        return $this->hasMany(ChildSkill::class, 'child_id');
    }

    public function moodBoards()
    {
        return $this->hasMany(MoodBoard::class, 'child_profile_id');
    }
}
