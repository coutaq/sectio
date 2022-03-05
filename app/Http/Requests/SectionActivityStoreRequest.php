<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SectionActivityStoreRequest extends FormRequest
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
            'date' => ['required'],
            'title' => ['required'],
            'description' => ['required'],
            'section_id' => 'required'
        ];
    }
}
