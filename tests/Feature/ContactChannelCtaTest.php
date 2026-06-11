<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactChannelCtaTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_render_contact_channels_and_sticky_cta_markers(): void
    {
        $this->withoutVite();

        foreach (['/', '/services', '/portfolio'] as $path) {
            $response = $this->get($path);

            $response->assertOk();
            $response->assertSee('data-floating-contact', false);
            $response->assertSee('data-footer-emphasis', false);
            $response->assertSee('data-sticky-cta', false);
        }

        foreach (['/', '/services'] as $path) {
            $this->get($path)->assertSee('data-contact-channels', false);
        }
    }

    public function test_frontend_assets_include_sticky_cta_behavior(): void
    {
        $css = file_get_contents(resource_path('css/app.css'));
        $js = file_get_contents(resource_path('js/app.js'));

        $this->assertStringContainsString('.sticky-cta-mobile', $css);
        $this->assertStringContainsString('.floating-contact-icons', $css);
        $this->assertStringContainsString('[data-sticky-cta]', $js);
        $this->assertStringContainsString('[data-floating-contact]', $js);
        $this->assertStringContainsString('is-hidden', $js);
    }
}
