<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionStoreRequest extends FormRequest
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
            'test_id' => ['required', 'integer', 'exists:tests,id'],
            'type' => ['required', 'in:one,many,write'],
            'answers' => ['required', 'json'],
            'correct' => ['required', 'json'],
            'comment' => ['nullable']
        ];
    }
}
