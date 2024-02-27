<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DutyRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'user_id' => ['nullable', 'exists:users,id'],
            'room_id' => ['nullable', 'exists:rooms,id'],
            'status' => ['required', 'string', 'max:255'],
            'frequency' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date'],
        ];
    }
}
