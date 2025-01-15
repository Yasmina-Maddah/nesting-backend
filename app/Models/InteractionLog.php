<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InteractionLog extends Model
{
    use HasFactory;

    protected $fillable = ['child_id', 'activity_id', 'interaction_time', 'notes'];

    public function child()
    {
        return $this->belongsTo(ChildrenProfile::class, 'child_id');
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }
}
