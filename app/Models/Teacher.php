<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Group;


class Teacher extends Model
{
    protected $table = 'teacher';

    /**
     * @return HasMany
     */

    public function group(): HasMany
    {
        return $this->hasMany(Group::class);

    }
}
