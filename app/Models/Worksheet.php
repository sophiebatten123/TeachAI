<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Worksheet extends Model
{
    protected $fillable = [
        'lesson_id',
        'worksheet_content',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}