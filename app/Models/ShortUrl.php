<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShortUrl extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'original_url',
        'short_code',
        'visits',
    ];
}
