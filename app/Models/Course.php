<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'path_trailer',
        'about',
        'thumbnail',
        'category_id',
        'teacher_id',
    ];

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }
    public function teacher(): BelongsTo {
        return $this->belongsTo(Teacher::class);
    }
    public function courseKeypoints (): HasMany {
        return $this->hasMany(CourseKeypoint::class);
    }
    public function students (): BelongsToMany {
        return $this->belongsToMany(User::class, 'course_students');
    }
    public function coursevideos() :HasMany {
        return $this->hasMany(CourseVideo::class);
    }
}
