<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
        protected $fillable = [
            'user_id',
            'lesson_content',
            'title',
            'objective',
            'recap_activity',
            'teaching',
            'practice',
            'exit_ticket'
        ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function powerpoint()
    {
        return $this->hasOne(Powerpoint::class);
    }
}
