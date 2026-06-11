<?php

namespace Tests\Feature;

use App\Models\DemoProject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioCaseStudyTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_portfolio_pages_render_published_projects(): void
    {
        $this->withoutVite();

        $project = DemoProject::query()->create([
            'name' => 'Case study landing page chuyển đổi',
            'slug' => 'case-study-landing-page-chuyen-doi',
            'project_type' => 'landing_page',
            'client_problem' => 'Landing page cũ không tạo lead.',
            'implemented_solution' => 'Thiết kế lại hero và form tư vấn.',
            'tech_stack' => ['Laravel', 'TailwindCSS'],
            'role_summary' => 'Thiết kế và triển khai landing page.',
            'outcome_summary' => 'Trang dễ hiểu hơn và CTA rõ hơn.',
            'demo_url' => 'https://example.com/demo',
            'status' => 'published',
            'is_active' => true,
        ]);

        $this->get('/portfolio')
            ->assertOk()
            ->assertSee('Case study landing page chuyển đổi')
            ->assertSee('data-portfolio-showcase-grid', false)
            ->assertSee('data-portfolio-preview', false)
            ->assertSee('Vai trò', false);

        $this->get("/portfolio/{$project->slug}")
            ->assertOk()
            ->assertSee('Bài toán')
            ->assertSee('Giải pháp')
            ->assertSee('Kết quả')
            ->assertSee('Laravel')
            ->assertSee('data-portfolio-show-hero', false)
            ->assertSee('Kết quả nhận được');
    }

    public function test_unpublished_or_inactive_portfolio_project_is_not_public(): void
    {
        $this->withoutVite();

        $draft = DemoProject::query()->create([
            'name' => 'Draft project',
            'slug' => 'draft-project',
            'project_type' => 'website',
            'client_problem' => 'Draft',
            'implemented_solution' => 'Draft',
            'demo_url' => 'https://example.com/draft',
            'status' => 'draft',
            'is_active' => true,
        ]);

        $this->get("/portfolio/{$draft->slug}")->assertNotFound();
    }

    public function test_admin_can_manage_portfolio_projects(): void
    {
        $this->withoutVite();

        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)->get('/admin/marketplace/demo-projects')
            ->assertOk()
            ->assertSee('Portfolio / case studies');

        $this->actingAs($admin)->post('/admin/marketplace/demo-projects', [
            'name' => 'Portfolio fix bug Laravel',
            'project_type' => 'bug_fix',
            'demo_url' => 'https://example.com/fix',
            'client_problem' => 'Website lỗi ở trang checkout.',
            'implemented_solution' => 'Sửa bug validation và query.',
            'tech_stack' => "Laravel\nMySQL",
            'role_summary' => 'Điều tra bug và refactor phần checkout.',
            'outcome_summary' => 'Website ổn định và không còn lỗi checkout.',
            'status' => 'published',
            'is_active' => '1',
        ])->assertRedirect();

        $project = DemoProject::query()->where('name', 'Portfolio fix bug Laravel')->firstOrFail();

        $this->actingAs($admin)->patch("/admin/marketplace/demo-projects/{$project->slug}", [
            'status' => 'draft',
        ])->assertRedirect();

        $this->assertDatabaseHas('demo_projects', [
            'id' => $project->id,
            'status' => 'draft',
        ]);
    }
}
