<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOffering extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'service_group',
        'short_description',
        'detail_description',
        'target_audiences',
        'key_benefits',
        'process_steps',
        'pricing_note',
        'status',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'target_audiences' => 'array',
            'key_benefits' => 'array',
            'process_steps' => 'array',
            'sort_order' => 'integer',
        ];
    }
}
