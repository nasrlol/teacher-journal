<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'group_id',
    ];

    /**
     * Get the parent group.
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Get the students in this sub-group.
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
