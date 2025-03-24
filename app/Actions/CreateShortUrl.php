<?php

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
            'visits' => 0
        ]);
    }

    private function generateUniqueShortCode(): string
    {
        do {
            $code = Str::random(6);
        } while (ShortUrl::where('short_code', $code)->exists());

        return $code;
    }
}
