<?php

namespace App\Models;

use App\Core\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Application extends Pivot
{
    use HasFilter, HasFactory;

    protected $table = 'course_user';

    public $incrementing = true;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getApplicationInfoAttribute(): array
    {
        return [
            'application_id' => $this->id,
            'user_id' => $this->user_id,
            'course_id' => $this->course_id,
            'enrollment_date' => $this->created_at,
            'name' => $this->user->name,
            'last_name' => $this->user->last_name,
            'second_name' => $this->user->second_name,
            'course_name' => $this->course->name,
        ];
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
