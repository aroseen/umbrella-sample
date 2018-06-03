<?php
/**
 * Created by PhpStorm.
 * User: aRosen_LN
 * Date: 03.06.2018
 * Time: 22:40
 */

namespace App\Components;

use App\Models\Url;
use App\Models\User;
use Carbon\Carbon;
use Psr\Log\LoggerInterface;

/**
 * Class EventsLogger
 * @package App\Components
 */
class EventsLogger
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * EventsLogger constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param User $user
     */
    public function userRegistered(User $user): void
    {
        $this->logger->info(__('logger_events.user.registered', [
            'id'   => $user->id,
            'name' => $user->name,
        ]));
    }

    /**
     * @param User $user
     */
    public function userLogin(User $user): void
    {
        $this->logger->info(__('logger_events.user.login', [
            'id'   => $user->id,
            'name' => $user->name,
        ]));
    }

    /**
     * @param User $user
     */
    public function userLogout(User $user): void
    {
        $this->logger->info(__('logger_events.user.logout', [
            'id'   => $user->id,
            'name' => $user->name,
        ]));
    }

    /**
     * @param User $user
     * @param Url  $url
     */
    public function urlCreated(User $user, Url $url): void
    {
        $this->logger->info(__('logger_events.url.created', [
            'id'        => $user->id,
            'name'      => $user->name,
            'url_id'    => $url->id,
            'short_url' => $url->short_url,
        ]));
    }

    /**
     * @param User $authUser
     * @param User $user
     * @param Url  $url
     */
    public function urlShared(User $authUser, User $user, Url $url): void
    {
        $this->logger->info(__('logger_events.url.shared', [
            'id'         => $authUser->id,
            'name'       => $authUser->name,
            'share_id'   => $user->id,
            'share_name' => $user->name,
            'url_id'     => $url->id,
            'short_url'  => $url->short_url,
        ]));
    }

    /**
     * @param User $authUser
     * @param User $user
     * @param Url  $url
     */
    public function urlUnshared(User $authUser, User $user, Url $url): void
    {
        $this->logger->info(__('logger_events.url.unshared', [
            'id'         => $authUser->id,
            'name'       => $authUser->name,
            'share_id'   => $user->id,
            'share_name' => $user->name,
            'url_id'     => $url->id,
            'short_url'  => $url->short_url,
        ]));
    }

    /**
     * @param User $authUser
     * @param bool $canShare
     */
    public function toggleSharing(User $authUser, bool $canShare): void
    {
        $this->logger->info(__('logger_events.user.'.($canShare ? 'sharingActivated' : 'sharingDeactivated'), [
            'id'   => $authUser->id,
            'name' => $authUser->name,
        ]));
    }

    /**
     * @param Url $url
     */
    public function oldUrlRemoved(Url $url): void
    {
        $this->logger->info(__('logger_events.url.oldUrlRemoved', [
            'id'         => $url->id,
            'short_url'  => $url->short_url,
            'created_at' => $url->created_at,
        ]));
    }
}