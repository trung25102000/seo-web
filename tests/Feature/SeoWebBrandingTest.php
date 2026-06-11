<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoWebBrandingTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_use_project_branding_instead_of_default_laravel_copy(): void
    {
        $this->withoutVite();

        foreach (['/', '/services', '/templates', '/blog', '/login'] as $path) {
            $response = $this->get($path);

            $response->assertOk();
            $response->assertDontSee('Laravel News');
            $response->assertDontSee('Laracasts');
            $response->assertDontSee('Documentation');
            $response->assertDontSee('AI Video Generator');
            $response->assertDontSee('AI video workspace');
        }

        $this->get('/')->assertSee('Web Template Studio');
    }
}
