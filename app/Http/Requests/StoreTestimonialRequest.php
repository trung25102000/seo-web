<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTestimonialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('access-admin') ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'avatar_label' => ['nullable', 'string', 'max:8'],
            'audience_type' => ['required', Rule::in(['shop_owner', 'online_seller', 'student', 'small_business'])],
            'service_type' => ['required', Rule::in(['website', 'landing_page', 'seo', 'ui_fix', 'coding_task', 'student_support'])],
            'content' => ['required', 'string', 'max:2000'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'trust_tag' => ['nullable', 'string', 'max:120'],
            'status' => ['required', Rule::in(['published', 'draft'])],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ];
    }
}
