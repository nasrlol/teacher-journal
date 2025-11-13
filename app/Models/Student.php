<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    Use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'age',
        'enrollment_date',
    ];
    
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }   

    // TODO: apparently not needed? why? dont know yet... :-) 
    protected $table =  'lessons';
}
