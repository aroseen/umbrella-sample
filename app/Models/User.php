<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as BaseCollection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

/**
 * Class User.
 *
 * @property int             $id
 * @property string          $name
 * @property string          $email
 * @property bool            $can_share
 * @property int             $short_urls_count
 * @property Carbon          $created_at
 * @property Carbon          $updated_at
 *
 * @property-read Url        $ownUrls
 * @property-read Collection $shares
 * @property-read Collection $sharedUrls
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'can_share',
        'api_token',
        'short_urls_count',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'can_share' => 'bool',
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
     * @return HasMany
     */
    public function ownUrls(): HasMany
    {
        return $this->hasMany(Url::class, 'owner_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function shares(): HasMany
    {
        return $this->hasMany(Share::class, 'user_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function sharedUrls(): BelongsToMany
    {
        return $this->belongsToMany(Url::class, 'shares', 'user_id', 'url_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
     */

    /**
     * @param array $columns
     * @return BaseCollection
     */
    public function getSharedWithUrls(array $columns = ['*']): BaseCollection
    {
        return DB::table('shares')->join('urls', 'urls.id', '=', 'shares.url_id')->join('users', 'users.id', '=', 'shares.user_id')->where('urls.owner_id', $this->id)->get($columns);
    }

    /**
     * @param Url $url
     * @return Collection
     */
    public function getUsersToShare(Url $url): Collection
    {
        return $this->newQuery()->where('id', '!=', $this->id)->whereDoesntHave('shares', function (Builder $query) use ($url) {
            return $query->where('shares.url_id', $url->id);
        })->get(['users.id', 'users.name']);
    }
}
