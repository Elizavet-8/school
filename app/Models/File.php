<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'url',
        'type',
        'theme_id',
        'section_id'
    ];

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function getFileNameAttribute()
    {
        if (!$this->url) {
            return "Файл не найден";
        }

        if ($this->type == 'video') {
            return $this->url;
        }

        $parts = explode("/", $this->url);

        return end($parts);
    }

    public function getFileNameWithotExtensionAttribute()
    {
        $parts = explode(".", $this->fileName);
        array_pop($parts);

        return implode(".", $parts);
    }
}
