<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'content' => $this->content,
            'test_id' => $this->test_id,
            'type' => $this->type,
            'img_url' => $this->img_url,
            'answers' => $this->answers,
            'correct' => $this->correct,
            'comment' => $this->comment
        ];
    }
}
