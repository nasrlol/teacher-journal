<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Teacher extends Model
{
    use HasFactory;

    protected $table = 'teacher';

    /**
     * @return HasMany
     */

    public function group(): HasMany
    {
        return $this->hasMany(Group::class);

    }
}
