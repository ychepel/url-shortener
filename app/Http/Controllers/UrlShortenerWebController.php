<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CreateShortUrl;
use App\Http\Requests\StoreShortUrlRequest;
use Illuminate\View\View;

class UrlShortenerWebController extends Controller
{
    public function __construct(
        private readonly CreateShortUrl $createShortUrl
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

        return view('url-shortener.create', [
            'shortUrl' => url("/s/{$shortUrl->short_code}"),
            'originalUrl' => $shortUrl->original_url,
        ]);
    }
}
