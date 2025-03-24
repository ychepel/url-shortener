<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\ShortUrl;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreShortUrlRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'url' => ['required', 'url', 'min:5', 'max:2048'],
            'custom_alias' => [
                'nullable',
                'string',
                'min:3',
                'max:20',
                'regex:/^[a-zA-Z0-9-_]+$/',
                Rule::unique(ShortUrl::class, 'short_code'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'custom_alias.regex' => 'Custom alias can only contain letters, numbers, hyphens, and underscores.',
            'custom_alias.unique' => 'This custom alias is already taken. Please choose another one.',
        ];
    }
}
