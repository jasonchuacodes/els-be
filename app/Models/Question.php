<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = ['question'];

    public function quiz() 
    {
        return $this->belongsTo(Quiz::class);
    }

    public function choices() 
    {
        return $this->hasMany(Choice::class);
    }

    public function answers() 
    {
        return $this->hasMany(Answer::class);
    }
}
