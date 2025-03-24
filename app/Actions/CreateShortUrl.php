<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\ShortUrl;
use Illuminate\Support\Str;

class CreateShortUrl
{
    public function execute(string $url, ?string $customAlias = null): ShortUrl
    {
        return ShortUrl::create([
            'original_url' => $url,
            'short_code' => $customAlias ?? $this->generateUniqueShortCode(),
            'visits' => 0,
        ]);
    }

    public function getShortUrl(string $short_code): string
    {
        return url("/s/{$short_code}");
    }

    private function generateUniqueShortCode(): string
    {
        do {
            $code = Str::random(6);
        } while (ShortUrl::where('short_code', $code)->exists());

        return $code;
    }
}
