<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class School extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'title',
        'rosvuz_id'
    ];

    protected $sortable = [
        'title'
    ];

    public function users(){
        return $this->hasMany(User::class);
    }

    public function courses() {
        return $this->belongsToMany(Course::class);
    }
}
