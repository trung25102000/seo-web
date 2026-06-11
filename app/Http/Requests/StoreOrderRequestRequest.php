<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequestRequest extends FormRequest
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
            'customer_group' => ['required', Rule::in(['shop_owner', 'online_seller', 'student'])],
            'need_type' => ['required', Rule::in(['template', 'custom_website', 'landing_page'])],
            'website_template_id' => ['nullable', 'exists:website_templates,id'],
            'pricing_package_id' => ['nullable', 'exists:pricing_packages,id'],
            'customization_request' => ['nullable', 'string', 'max:3000'],
        ];
    }
}
