<?php

declare(strict_types=1);

Schedule::command('short-urls:cleanup')->cron('25 1 * * *');
