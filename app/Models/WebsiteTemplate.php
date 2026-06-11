<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class WebsiteTemplate extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return ['gallery' => 'array', 'price' => 'integer'];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(TemplateCategory::class, 'template_category_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(OrderRequest::class);
    }

    public function demoProjects(): HasMany
    {
        return $this->hasMany(DemoProject::class);
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(ProductAttachment::class, 'attachable');
    }
}
