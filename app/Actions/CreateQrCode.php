<?php

declare(strict_types=1);

namespace App\Actions;

use chillerlan\QRCode\QRCode;

class CreateQrCode
{
    public function execute(string $url): string
    {
        return (new QRCode())->render($url);
    }
}
