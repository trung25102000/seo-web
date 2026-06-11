<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGraduationProjectRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_name' => ['required', 'string', 'max:120'],
            'student_email' => ['nullable', 'email', 'max:160'],
            'student_phone' => ['required', 'string', 'max:30'],
            'school' => ['nullable', 'string', 'max:160'],
            'major' => ['nullable', 'string', 'max:160'],
            'topic' => ['required', 'string', 'max:220'],
            'requirements' => ['nullable', 'string', 'max:4000'],
            'need_report' => ['nullable', 'boolean'],
            'need_database' => ['nullable', 'boolean'],
            'need_installation_guide' => ['nullable', 'boolean'],
        ];
    }
}
