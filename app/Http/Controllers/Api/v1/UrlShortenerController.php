<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\CreateShortUrl;
use App\Actions\ResolveShortUrl;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShortUrlRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class UrlShortenerController extends Controller
{
    public function __construct(
        private readonly CreateShortUrl $createShortUrl,
        private readonly ResolveShortUrl $resolveShortUrl
    ) {}

    public function store(StoreShortUrlRequest $request): JsonResponse
    {
        $shortUrl = $this->createShortUrl->execute($request->url);

        return new JsonResponse([
            'short_url' => url("/s/{$shortUrl->short_code}"),
            'original_url' => $shortUrl->original_url
        ], JsonResponse::HTTP_CREATED);
    }

    public function redirect(string $shortCode): RedirectResponse
    {
        $shortUrl = $this->resolveShortUrl->execute($shortCode);

        return redirect($shortUrl->original_url);
    }
}
