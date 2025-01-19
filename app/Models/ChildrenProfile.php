<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildrenProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'date_of_birth',
        'hobbies',
        'dream_job',
    ];

    public function parent()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
