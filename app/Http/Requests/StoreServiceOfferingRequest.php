<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreServiceOfferingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('access-admin') ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:160'],
            'service_group' => ['required', Rule::in(['seo', 'ui_fix', 'website', 'student_support', 'coding_task'])],
            'short_description' => ['required', 'string', 'max:500'],
            'detail_description' => ['required', 'string', 'max:12000'],
            'target_audiences' => ['nullable', 'string', 'max:3000'],
            'key_benefits' => ['nullable', 'string', 'max:4000'],
            'process_steps' => ['nullable', 'string', 'max:4000'],
            'pricing_note' => ['nullable', 'string', 'max:2000'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ];
    }
}
