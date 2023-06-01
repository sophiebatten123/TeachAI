<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Powerpoint extends Model
{
    protected $fillable = [
        'lesson_id',
        'powerpoint_content',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
