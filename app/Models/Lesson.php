<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic',
        'description',
        'teacher_id',
        'group_id',
        'scheduled_at',
        'duration_minutes',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    /**
     * Get the teacher that teaches this lesson.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the group for this lesson.
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Get the students attending this lesson.
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'lesson_student')
            ->withPivot('attendance', 'score')
            ->withTimestamps();
    }
}
