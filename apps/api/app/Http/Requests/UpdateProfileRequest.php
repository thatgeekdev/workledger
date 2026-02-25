<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Permite que o próprio usuário ou admin atualize
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => [
                'sometimes',
                'string',
                'max:255'
            ],

            'gender' => [
                'sometimes',
                'in:male,female'
            ],

            'date_of_birth' => [
                'sometimes',
                'date',
                'before:today'
            ],

            'phone_number' => [
                'sometimes',
                'string',
                'max:20',
                'regex:/^[0-9+\-\s()]+$/'
            ],

            'address' => [
                'sometimes',
                'string',
                'max:255'
            ],

            'job_title' => [
                'sometimes',
                'string',
                'max:255'
            ],

            'department' => [
                'sometimes',
                'string',
                'max:255'
            ],

            'avatar_url' => [
                'sometimes',
                'nullable',
                'url'
            ],

            'bio' => [
                'sometimes',
                'nullable',
                'string',
                'max:2000'
            ],

            'status' => [
                'sometimes',
                'in:active,inactive,absent'
            ],
        ];
    }
}
