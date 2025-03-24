<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CreateQrCode;
use App\Actions\CreateShortUrl;
use App\Actions\ResolveShortUrl;
use App\Http\Requests\StoreShortUrlRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UrlShortenerWebController extends Controller
{
    public function __construct(
        private readonly CreateShortUrl $createShortUrl,
        private readonly ResolveShortUrl $resolveShortUrl,
        private readonly CreateQrCode $createQrCode,
    ) {}

    public function create(): View
    {
        return view('url-shortener.create');
    }

    public function store(StoreShortUrlRequest $request): View
    {
        $shortUrl = $this->createShortUrl->execute(
            $request->url,
            $request->custom_alias
        );
        $shortUrlValue = $this->createShortUrl->getShortUrl($shortUrl->short_code);

        return view('url-shortener.create', [
            'shortUrl' => $shortUrlValue,
            'originalUrl' => $shortUrl->original_url,
            'qrCode' => $this->createQrCode->execute($shortUrlValue)
        ]);
    }

    public function redirect(string $shortCode): RedirectResponse
    {
        $shortUrl = $this->resolveShortUrl->execute($shortCode);

        return redirect($shortUrl->original_url);
    }
}
