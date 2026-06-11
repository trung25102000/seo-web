<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnimatedTrustVisualsTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_renders_animated_trust_visuals_and_badges(): void
    {
        $this->withoutVite();

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('data-hero-visuals', false);
        $response->assertSee('data-reveal', false);
        $response->assertSee('Phản hồi trong 15-60 phút');
        $response->assertSee('Thống nhất công việc trước khi làm');
        $response->assertSee('Bàn giao có hướng dẫn');
        $response->assertSee('Tổng quan dịch vụ');
        $response->assertSee('data-visual-system', false);
        $response->assertSee('data-background-particles', false);
    }

    public function test_public_ui_keeps_project_branding_without_default_laravel_copy(): void
    {
        $this->withoutVite();

        foreach (['/', '/services', '/templates'] as $path) {
            $response = $this->get($path);

            $response->assertOk();
            $response->assertSee('Web Template Studio');
            $response->assertDontSee('Laravel News');
            $response->assertDontSee('Laracasts');
            $response->assertDontSee('Documentation');
            $response->assertDontSee('AI Video Generator');
        }
    }

    public function test_frontend_assets_include_scroll_reveal_and_reduced_motion_support(): void
    {
        $css = file_get_contents(resource_path('css/app.css'));
        $js = file_get_contents(resource_path('js/app.js'));

        $this->assertStringContainsString('prefers-reduced-motion', $css);
        $this->assertStringContainsString('--color-primary', $css);
        $this->assertStringContainsString('site-particle-float', $css);
        $this->assertStringContainsString('skeleton-shimmer', $css);
        $this->assertStringContainsString('[data-reveal]', $css);
        $this->assertStringContainsString('IntersectionObserver', $js);
        $this->assertStringContainsString('is-visible', $js);
        $this->assertStringContainsString('data-count-up', $js);
    }
}
