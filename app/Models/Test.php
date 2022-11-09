<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
        'minutes',
        'min_correct',
        'theme_id',
        'section_id',
        'title',
        'order',
        'is_required'
    ];

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function attempts()
    {
        return $this->hasMany(Attempt::class);
    }

    public function passed($id)
    {
        return $this->attempts()->where('user_id', $id)->where('is_passed', true)->count() > 0;
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function isAvailable(User $user)
    {
        return true;/*Attempt::where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())
                        ->where('user_id', $user->id)
                        ->where('test_id', $this->id)
                        ->count() <= 3;*/
    }
}
