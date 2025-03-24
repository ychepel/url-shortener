<?php

namespace Tests\Feature;

use App\Models\ShortUrl;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UrlShortenerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_short_url(): void
    {
        $response = $this->postJson('/api/shorten', [
            'url' => 'https://example.com'
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'short_url',
                'original_url'
            ]);

        $this->assertDatabaseHas('short_urls', [
            'original_url' => 'https://example.com'
        ]);
    }

    public function test_validates_invalid_url(): void
    {
        $response = $this->postJson('/api/shorten', [
            'url' => 'not-a-valid-url'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['url']);
    }

    public function test_requires_url_parameter(): void
    {
        $response = $this->postJson('/api/shorten', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['url']);
    }

    public function test_validates_url_minimum_length(): void
    {
        $response = $this->postJson('/api/shorten', [
            'url' => 'h://a'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['url']);
    }

    public function test_validates_url_maximum_length(): void
    {
        $longUrl = 'https://example.com/' . str_repeat('a', 2048);
        
        $response = $this->postJson('/api/shorten', [
            'url' => $longUrl
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['url']);
    }

    public function test_generates_unique_short_codes(): void
    {
        $response1 = $this->postJson('/api/shorten', [
            'url' => 'https://example1.com'
        ]);
        $response2 = $this->postJson('/api/shorten', [
            'url' => 'https://example2.com'
        ]);

        $shortUrls = ShortUrl::orderBy('id')->get();
        $this->assertCount(2, $shortUrls);
        $this->assertNotEquals($shortUrls[0]->short_code, $shortUrls[1]->short_code);
    }

    public function test_redirects_to_original_url(): void
    {
        $shortUrl = ShortUrl::create([
            'original_url' => 'https://example.com',
            'short_code' => 'abc123',
            'visits' => 0
        ]);

        $response = $this->get("/s/{$shortUrl->short_code}");

        $response->assertStatus(302)
            ->assertRedirect($shortUrl->original_url);

        $this->assertEquals(1, $shortUrl->fresh()->visits);
    }

    public function test_returns_404_for_nonexistent_short_code(): void
    {
        $response = $this->get('/s/nonexistent');

        $response->assertStatus(404);
    }

    public function test_increments_visits_counter(): void
    {
        $shortUrl = ShortUrl::create([
            'original_url' => 'https://example.com',
            'short_code' => 'abc123',
            'visits' => 5
        ]);

        $this->get("/s/{$shortUrl->short_code}");
        $this->get("/s/{$shortUrl->short_code}");
        $this->get("/s/{$shortUrl->short_code}");

        $this->assertEquals(8, $shortUrl->fresh()->visits);
    }
}
