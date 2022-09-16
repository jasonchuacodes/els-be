<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'activity',
        'activitiable_id',
        'activitiable_type',
    ];

    public function activitiable()
    {
        return $this->morphTo();
    } 
}
