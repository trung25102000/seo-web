<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreContactMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['nullable', 'email', 'max:160'],
            'phone' => ['nullable', 'string', 'max:30'],
            'channel' => ['required', Rule::in(['website', 'zalo', 'facebook', 'email', 'phone'])],
            'service_type' => ['nullable', Rule::in(['website', 'landing_page', 'catalog', 'custom', 'seo', 'ui_fix', 'coding_task', 'student_support'])],
            'preferred_contact_channel' => ['nullable', Rule::in(['zalo', 'phone', 'email', 'facebook'])],
            'message' => ['required', 'string', 'max:3000'],
        ];
    }
}
