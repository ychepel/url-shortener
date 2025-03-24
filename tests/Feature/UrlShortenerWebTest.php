<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\ShortUrl;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UrlShortenerWebTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_page_can_be_rendered(): void
    {
        $response = $this->get(route('url.create'));

        $response->assertStatus(200)
            ->assertViewIs('url-shortener.create')
            ->assertSee('URL Shortener')
            ->assertSee('Enter URL to shorten');
    }

    public function test_can_create_url_via_web_interface(): void
    {
        $response = $this->post(route('url.shorten'), [
            'url' => 'https://example.com'
        ]);

        $response->assertStatus(200)
            ->assertViewIs('url-shortener.create')
            ->assertViewHas('shortUrl')
            ->assertViewHas('originalUrl', 'https://example.com')
            ->assertSee('URL shortened successfully');

        $this->assertDatabaseHas('short_urls', [
            'original_url' => 'https://example.com'
        ]);
    }

    public function test_can_create_url_with_custom_alias(): void
    {
        $response = $this->post(route('url.shorten'), [
            'url' => 'https://example.com',
            'custom_alias' => 'my-custom'
        ]);

        $response->assertStatus(200)
            ->assertViewIs('url-shortener.create')
            ->assertViewHas('shortUrl', url('/s/my-custom'))
            ->assertSee('URL shortened successfully');

        $this->assertDatabaseHas('short_urls', [
            'original_url' => 'https://example.com',
            'short_code' => 'my-custom'
        ]);
    }

    public function test_shows_validation_errors(): void
    {
        $response = $this->post(route('url.shorten'), [
            'url' => 'not-a-valid-url',
            'custom_alias' => 'a'
        ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['url', 'custom_alias']);
    }

    public function test_cannot_use_duplicate_custom_alias(): void
    {
        $this->post(route('url.shorten'), [
            'url' => 'https://example.com',
            'custom_alias' => 'my-alias'
        ]);

        $response = $this->post(route('url.shorten'), [
            'url' => 'https://another-example.com',
            'custom_alias' => 'my-alias'
        ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['custom_alias']);

        $this->assertEquals(1, ShortUrl::where('short_code', 'my-alias')->count());
    }

    public function test_old_input_is_preserved_after_validation_error(): void
    {
        $response = $this->post(route('url.shorten'), [
            'url' => 'not-a-valid-url',
            'custom_alias' => 'my-alias'
        ]);

        $response->assertStatus(302)
            ->assertSessionHasInput([
                'url' => 'not-a-valid-url',
                'custom_alias' => 'my-alias'
            ]);

        $this->get('/shorten')
            ->assertSee('not-a-valid-url')
            ->assertSee('my-alias');
    }

    public function test_custom_alias_must_match_pattern(): void
    {
        $response = $this->post(route('url.shorten'), [
            'url' => 'https://example.com',
            'custom_alias' => 'invalid@alias!'
        ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['custom_alias']);
    }
}
