<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubGroup extends Model
{
    use HasFactory;

    protected $attributes = [


    ];

    public function student(): HasMany
    {
        return $this-hasMany(Student::class);
    }
}
