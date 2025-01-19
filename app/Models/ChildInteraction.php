<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildInteraction extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_id',
        'visualization_id',
        'response',
        'is_correct',
    ];

    public function child()
    {
        return $this->belongsTo(ChildProfile::class, 'child_id');
    }

    public function visualization()
    {
        return $this->belongsTo(AIVisualization::class, 'visualization_id');
    }
}
