<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\ShortUrl;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanupShortUrlsCommand extends Command
{
    protected $signature = 'short-urls:cleanup {--days=7 : Number of days to keep URLs}';
    protected $description = 'Soft delete short URLs older than specified days';

    public function handle(): int
    {
        $days = (int) $this->option('days');
        $cutoffDate = Carbon::now()->subDays($days);

        $count = ShortUrl::where('created_at', '<', $cutoffDate)
            ->whereNull('deleted_at')
            ->update(['deleted_at' => Carbon::now()]);

        $this->info("Soft deleted {$count} URLs older than {$days} days.");

        return self::SUCCESS;
    }
}
