<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return ['published_at' => 'datetime'];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public static function pillarOptions(): array
    {
        return [
            'seo' => [
                'label' => 'SEO website',
                'summary' => 'Title, meta, nội dung, internal link và chuyển đổi từ traffic tự nhiên.',
            ],
            'landing_page' => [
                'label' => 'Landing page',
                'summary' => 'Bố cục chốt lead, thông điệp bán hàng và tối ưu CTA theo chiến dịch.',
            ],
            'ui_fix' => [
                'label' => 'Sửa giao diện',
                'summary' => 'Fix responsive, tăng tốc độ đọc trang và xử lý các lỗi UI gây mất khách.',
            ],
            'student_support' => [
                'label' => 'Hỗ trợ đồ án',
                'summary' => 'Ý tưởng, tài liệu, database, source Laravel và kế hoạch hoàn thiện đồ án.',
            ],
            'technical' => [
                'label' => 'Kỹ thuật web/code/app',
                'summary' => 'Chia sẻ fix bug, API, stack Laravel/React/Next.js và task lập trình thực chiến.',
            ],
        ];
    }

    public static function serviceGroupOptions(): array
    {
        return [
            'seo' => 'SEO website',
            'website' => 'Website và landing page',
            'ui_fix' => 'Fix giao diện',
            'student_support' => 'Hỗ trợ đồ án',
            'coding_task' => 'Task code',
        ];
    }

    public function pillarMeta(): array
    {
        return static::pillarOptions()[$this->content_pillar ?: 'technical']
            ?? static::pillarOptions()['technical'];
    }
}
