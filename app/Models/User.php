<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'user_type',
    ];

    // Relationships
    public function childrenProfiles()
    {
        return $this->hasMany(ChildrenProfile::class, 'parent_id');
    }

    public function aiVisualizations()
    {
        return $this->hasMany(AIVisualization::class, 'parent_id');
    }
}
