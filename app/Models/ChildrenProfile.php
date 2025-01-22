<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class ChildrenProfile extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'date_of_birth', 'hobbies', 'dream_job', 'user_id'];

    protected $casts = [
        'date_of_birth' => 'date', 
    ];

    public function parent()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getAgeAttribute()
    {
        return $this->date_of_birth ? $this->date_of_birth->diffInYears(Carbon::now()) : null;
    }
}
