<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Application extends Model
{
    use HasFactory, Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'place_of_work',
        'email',
        'city',
        'status',
        'reason'
    ];

    protected $sortable = [
        'name',
        'place_of_work',
        'email',
        'city',
        'status'
    ];
}
