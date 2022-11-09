<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class TestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'chapter_id' => $this->chapter_id,
            'minutes' => $this->minutes,
            'min_correct' => $this->min_correct,
            'questions' => new QuestionCollection($this->questions),
            'section_id' => $this->section_id,
            'title' => $this->title,
            'order' => $this->order,
            'is_required' => $this->is_required
            //'completed' => $this->completed(Auth::user())
        ];
    }
}
