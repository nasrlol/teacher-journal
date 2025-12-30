<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'name',
        'last_name',
        'age',
        'group_id',
        'sub_group_id',
        'points',
        'enrollment_date',
    ];

    protected $casts = [
        'enrollment_date' => 'date',
    ];

    /**
     * Get the group this student belongs to.
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Get the sub-group this student belongs to.
     */
    public function subGroup(): BelongsTo
    {
        return $this->belongsTo(SubGroup::class);
    }

    /**
     * Get the lessons this student attends.
     */
    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class, 'lesson_student')
            ->withPivot('attendance', 'score')
            ->withTimestamps();
    }

    /**
     * Get the activities this student participates in.
     */
    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(Activity::class, 'activity_student')
            ->withPivot('score', 'notes')
            ->withTimestamps();
    }
}
