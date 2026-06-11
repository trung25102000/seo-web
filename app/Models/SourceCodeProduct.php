<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class SourceCodeProduct extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function demoProjects(): HasMany
    {
        return $this->hasMany(DemoProject::class);
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(ProductAttachment::class, 'attachable');
    }
}
