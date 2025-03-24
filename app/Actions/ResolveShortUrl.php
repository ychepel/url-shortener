<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\ShortUrl;

class ResolveShortUrl
{
    public function execute(string $shortCode): ShortUrl
    {
        $shortUrl = ShortUrl::where('short_code', $shortCode)->firstOrFail();
        $shortUrl->increment('visits');

        return $shortUrl;
    }
}
