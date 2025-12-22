<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'date',
        'teacher_id',
        'group_id',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Get the teacher that created this activity.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the group for this activity.
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Get the students participating in this activity.
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'activity_student')
            ->withPivot('score', 'notes')
            ->withTimestamps();
    }
}

