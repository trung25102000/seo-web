<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreQuoteRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:120'],
            'customer_email' => ['nullable', 'email', 'max:160'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'preferred_contact_channel' => ['required', Rule::in(['zalo', 'phone', 'email', 'facebook'])],
            'customer_group' => ['required', Rule::in(['shop_owner', 'online_seller', 'student'])],
            'service_type' => ['required', Rule::in(['website', 'landing_page', 'catalog', 'custom', 'seo', 'ui_fix', 'coding_task', 'student_support'])],
            'budget_range' => ['nullable', 'string', 'max:80'],
            'deadline' => ['nullable', 'string', 'max:120'],
            'technology_stack' => ['nullable', 'string', 'max:160'],
            'requirements' => ['required', 'string', 'max:4000'],
        ];
    }
}
