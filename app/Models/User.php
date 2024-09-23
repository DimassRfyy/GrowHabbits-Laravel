<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Teacher;
use App\Models\CourseStudent;
use Illuminate\Support\Carbon;
use App\Models\SubscribeTransaction;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'occupation',
        'avatar',
        'password',
    ];

    public function teachers () :HasMany {
        return $this->hasMany(Teacher::class);
    }
    public function courseStudents () :HasMany {
        return $this->hasMany(CourseStudent::class);
    }
    public function courses (): BelongsToMany {
        return $this->belongsToMany(Course::class, 'course_students');
    }
    public function subscribeTransactions () :HasMany {
        return $this->hasMany(SubscribeTransaction::class);
    }

    public function hasActiveSubscription(){
        $latestSubscription = $this->subscribeTransactions()->where('is_paid',true)->latest('updated_at')->first();
        if (!$latestSubscription){
            return false;
        }
        $subscriptionEndDate = Carbon::parse($latestSubscription->subscription_start_date)->addMonths(1);
        return Carbon::now()->lessThanOrEqualTo($subscriptionEndDate);
        
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
