<?php

namespace App\Http\Resources;

use App\DeviceGroup;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {


        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'grade' => $this->grade,
            'school_id' => $this->school_id,
            'school' => $this->school,
            'roles' => $this->roles,
            'sex' => $this->sex,
            'city' => $this->city,
            'birth' => $this->birth,
        ];
    }
}
