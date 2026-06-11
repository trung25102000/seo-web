<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDemoProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('access-admin') ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:160'],
            'project_type' => ['required', Rule::in(['website', 'landing_page', 'seo', 'app', 'bug_fix'])],
            'website_template_id' => ['nullable', 'exists:website_templates,id'],
            'demo_url' => ['required', 'url', 'max:255'],
            'admin_url' => ['nullable', 'url', 'max:255'],
            'username' => ['nullable', 'string', 'max:120'],
            'password_hint' => ['nullable', 'string', 'max:120'],
            'client_problem' => ['required', 'string', 'max:3000'],
            'implemented_solution' => ['required', 'string', 'max:4000'],
            'tech_stack' => ['nullable', 'string', 'max:2000'],
            'role_summary' => ['nullable', 'string', 'max:2000'],
            'outcome_summary' => ['nullable', 'string', 'max:2000'],
            'preview_image_path' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['published', 'draft'])],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
