<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoodBoard extends Model
{
    use HasFactory;

    protected $fillable = ['child_profile_id', 'image_path', 'description'];

    public function childProfile()
    {
        return $this->belongsTo(ChildrenProfile::class, 'child_profile_id');
    }
}
