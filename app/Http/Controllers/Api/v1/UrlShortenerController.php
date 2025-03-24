<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1;

use App\Actions\CreateShortUrl;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShortUrlRequest;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="URL Shortener API",
 *     description="A simple URL shortener service API",
 *     @OA\Contact(
 *         email="admin@example.com"
 *     )
 * )
 */
class UrlShortenerController extends Controller
{
    public function __construct(
        private readonly CreateShortUrl $createShortUrl
    ) {}

    /**
     * Create a short URL
     *
     * @OA\Post(
     *     path="/api/v1/shorten",
     *     summary="Create a short URL",
     *     tags={"URL Shortener"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"url"},
     *             @OA\Property(property="url", type="string", format="url", example="https://example.com"),
     *             @OA\Property(property="custom_alias", type="string", example="my-custom-url")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="URL shortened successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="short_url", type="string", example="http://localhost/s/abc123"),
     *             @OA\Property(property="original_url", type="string", example="https://example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function store(StoreShortUrlRequest $request): JsonResponse
    {
        $shortUrl = $this->createShortUrl->execute(
            $request->url,
            $request->custom_alias
        );

        return new JsonResponse([
            'short_url' => url("/s/{$shortUrl->short_code}"),
            'original_url' => $shortUrl->original_url
        ], JsonResponse::HTTP_CREATED);
    }
}
