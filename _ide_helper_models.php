<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $original_url
 * @property string $short_code
 * @property int $visits
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortUrl newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortUrl newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortUrl query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortUrl whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortUrl whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortUrl whereOriginalUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortUrl whereShortCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortUrl whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortUrl whereVisits($value)
 */
	class ShortUrl extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 */
	class User extends \Eloquent {}
}

