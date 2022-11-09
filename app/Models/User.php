<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Kyslik\ColumnSortable\Sortable;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Routing\UrlGenerator;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'city',
        'birth',
        'sex',
        'school_id',
        'grade',
        'img_url'
    ];

    protected $sortable = [
        'name',
        'email',
        'password',
        'city',
        'birth',
        'sex',
        'school_id',
        'grade',
        'img_url'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeWithFilters($query, $filters)
    {
        return $query->when($filters->name, function ($query) use ($filters) {
            $query->where('name', 'LIKE', '%' . $filters->name . '%');
        })->when($filters->school_id, function ($query) use ($filters) {
            $query->where('school_id', $filters->school_id);
        })->when($filters->grade, function ($query) use ($filters) {
            $query->where('grade', $filters->grade);
        });
    }

    /**
     * Send a password reset notification to the user.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token, $this->email));
    }

    public function courses() {
        return $this->hasMany(Course::class);
        //return $this->belongsToMany(Course::class)->withPivot('completed');
    }

    public function availableCourses() {
        return $this->belongsToMany(Course::class);
    }

    public function school() {
        return $this->belongsTo(School::class);
    }

    public function studentsIds()
    {
        $ids = [];

        foreach ($this->courses as $course) {
            $ids = [...$ids, ...$course->studentsIds()];
        }

        return $ids;
    }

    public function passed(Test $test) {
        $attempts = Attempt::where("user_id", $this->id)->where("test_id", $test->id)->get();

        if ($attempts->count() == 0) {
            return "Не приступил";
        }

        if ($attempts->where('is_passed',true)->count() > 0) {
            return "Сдал успешно";
        }

        if ($attempts->where('is_passed', true)->count() == 0) {
            return "Не сдал";
        }

        return "Не приступил";
    }
}
