<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }
}
