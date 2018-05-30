<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Share.
 *
 * @property int       $id
 * @property int       $url_id
 * @property int       $user_id
 *
 * @property-read User $user
 * @property-read Url  $url
 *
 * @package App\Models
 */
class Share extends Model
{
    /**
     * @var string
     */
    protected $table = 'shares';

    /**
     * @var array
     */
    protected $fillable = [
        'url_id',
        'user_id',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
     */

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function url(): BelongsTo
    {
        return $this->belongsTo(Url::class, 'url_id', 'id');
    }
}
