<?php

namespace App\Http\Requests\App\Models;

use Illuminate\Foundation\Http\FormRequest;

class RoundActivityStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string', 'max:150'],
            'date' => ['required', 'date'],
            'time' => ['required'],
            'round_id' => ['required', 'integer', 'exists:rounds,id'],
        ];
    }
}
