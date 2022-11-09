<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'theme_id' => ['required', 'integer', 'exists:themes,id'],
            'minutes' => ['required', 'integer', 'gt:0'],
            'min_correct' => ['required', 'integer', 'gt:0'],
            'section_id' => ['required'],
            'title' => ['nullable', 'string', 'max:255'],
            'order' => ['nullable', 'integer'],
            'is_required' => ['nullable']
        ];
    }
}
