<?php

namespace App\Policies;

use App\Models\Url;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class UrlPolicy.
 *
 * @package App\Policies
 */
class UrlPolicy
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

    /**
     * @param User $user
     * @param Url  $url
     * @return bool
     */
    public function redirect(User $user, Url $url): bool
    {
        if ($url->owner_id === $user->id) {
            return true;
        }

        return $url->shares()->where('user_id', $user->id)->count() !== 0;
    }
}
