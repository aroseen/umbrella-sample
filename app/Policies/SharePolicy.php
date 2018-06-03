<?php

namespace App\Policies;

use App\Models\Url;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class SharePolicy.
 *
 * @package App\Policies
 */
class SharePolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Url  $url
     * @return bool
     */
    public function share(User $user, Url $url): bool
    {
        return $user->can_share && $user->id === $url->owner_id;
    }

    /**
     * @param User $user
     * @param Url  $url
     * @return bool
     */
    public function unshare(User $user, Url $url): bool
    {
        return $user->id === $url->owner_id;
    }
}
