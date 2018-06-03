<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Url.
 *
 * @property int             $id
 * @property int             $owner_id
 * @property string          $origin_url
 * @property string          $short_url
 * @property Carbon          $created_at
 * @property Carbon          $updated_at
 *
 * @property-read User       $owner
 * @property-read Collection $shares
 * @property-read Collection $sharedUsers
 *
 * @package App\Models
 */
class Url extends Model
{
    /**
     * @var string
     */
    protected $table = 'urls';

    /**
     * @var array
     */
    protected $fillable = [
        'owner_id',
        'origin_url',
        'short_url',
    ];

    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
     */

    /**
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function shares(): HasMany
    {
        return $this->hasMany(Share::class, 'url_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function sharedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'shares', 'url_id', 'user_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
     */

    /**
     * @param string $shortUtl
     * @return bool
     */
    public static function shortUrlExists(string $shortUtl): bool
    {
        return static::query()->where('short_url', $shortUtl)->count() !== 0;
    }

    /**
     * @param string $originUrl
     * @return int
     */
    public static function originUrlsCount(string $originUrl): int
    {
        return static::query()->where([
            'origin_url' => $originUrl,
            'owner_id'   => auth()->user()->getAuthIdentifier(),
        ])->count();
    }
}
