<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DemoProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_code_product_id',
        'website_template_id',
        'name',
        'slug',
        'project_type',
        'client_problem',
        'implemented_solution',
        'tech_stack',
        'role_summary',
        'outcome_summary',
        'preview_image_path',
        'demo_url',
        'admin_url',
        'username',
        'password_hint',
        'status',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'tech_stack' => 'array',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function sourceCodeProduct(): BelongsTo
    {
        return $this->belongsTo(SourceCodeProduct::class);
    }

    public function websiteTemplate(): BelongsTo
    {
        return $this->belongsTo(WebsiteTemplate::class);
    }
}
