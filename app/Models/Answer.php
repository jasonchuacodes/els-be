<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'quizlog_id',
        'choice_id',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function quizlog()
    {
        return $this->belongsTo(Quizlog::class);
    }

    public function choice()
    {
        return $this->belongsTo(Choice::class);
    }
}
