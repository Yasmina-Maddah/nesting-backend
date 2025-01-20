<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';


    protected $fillable = [
        'skill_name',
        'description',
    ];

    public function childSkills()
    {
        return $this->hasMany(ChildSkill::class, 'skill_id');
    }
}
