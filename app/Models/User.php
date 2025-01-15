<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'user_type', // Added to reflect user roles or types
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the identifier that will be stored in the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key-value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Relationship: A user can have many child profiles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childrenProfiles()
    {
        return $this->hasMany(ChildrenProfile::class, 'parent_id');
    }

    /**
     * Relationship: A user can have many AI visualizations.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function aiVisualizations()
    {
        return $this->hasMany(AiVisualization::class, 'parent_id');
    }
}
