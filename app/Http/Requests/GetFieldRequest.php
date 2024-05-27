<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetFieldRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'township_id' => 'nullable|integer|exists:townships,id',
            'weekday_id' => 'nullable|integer|exists:weekdays,id',
            'weekend_id' => 'nullable|integer|exists:weekends,id',
            'type_id' => 'nullable|integer|exists:types,id',
            'keyword' => 'nullable|string',
            'limit' => 'nullable|integer'
        ];
    }
}
