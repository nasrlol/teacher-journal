<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'teacher_id',
    ];

    /**
     * Get the teacher that owns the group.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the students in this group.
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Get the sub-groups for this group.
     */
    public function subGroups(): HasMany
    {
        return $this->hasMany(SubGroup::class);
    }

    /**
     * Get the lessons for this group.
     */
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }
}
