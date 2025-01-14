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
        'age',
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
}
