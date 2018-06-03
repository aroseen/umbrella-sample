<?php
/**
 * Created by PhpStorm.
 * User: aRosen_LN
 * Date: 03.06.2018
 * Time: 13:03
 */

namespace App\Components;

use App\Models\Url;
use App\Models\User;
use stdClass;

/**
 * Class Table.
 *
 * @package App\Components
 */
class Table
{
    public const OWN_LINKS_TABLE    = 'own_links_table';
    public const SHARED_LINKS_TABLE = 'shared_links_table';
    public const GET_SHARED_TABLE   = 'get_shared_table';

    /**
     * @var User
     */
    private $user;

    /**
     * Table constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return array
     */
    public function ownLinksTableData(): array
    {
        /** @var array $headings */
        $headings = __('home.ownLinksTableHeading');
        if ($this->user->can_share) {
            $content    = $this->user->ownUrls()->get(['id', 'origin_url', 'short_url', 'created_at']);
            $headings[] = null;
            /** @var Url $row */
            foreach ($content as $row) {
                $row->setAttribute('shareButton', view('elements.share-table-button', [
                    'buttonText' => __('home.shareButtonText'),
                    'urlId'      => $row->id,
                ])->render());
                $row->setHidden(['id']);
            }
        } else {
            $content = $this->user->ownUrls()->get(['origin_url', 'short_url', 'created_at']);
        }

        return [
            'tableName' => static::OWN_LINKS_TABLE,
            'headings'  => $headings,
            'data'      => $content->toArray(),
        ];
    }

    /**
     * @return array
     */
    public function sharedLinksTableData(): array
    {
        /** @var array $headings */
        $headings = __('home.sharedLinksTableHeading');
        $content  = $this->user->getSharedWithUrls([
            'shares.url_id',
            'shares.user_id',
            'urls.short_url',
            'users.name',
        ])->map(function (stdClass $item) {
            $item->rejectButton = view('elements.reject-share-button', [
                'buttonText' => __('home.stopShareButtonText'),
                'urlId'      => $item->url_id,
                'userId'     => $item->user_id,
            ])->render();
            unset($item->url_id, $item->user_id);

            return $item;
        });

        return [
            'tableName' => static::SHARED_LINKS_TABLE,
            'headings'  => $headings,
            'data'      => $content->toArray(),
        ];
    }

    /**
     * @return array
     */
    public function getSharedTableData(): array
    {
        /** @var array $headings */
        $headings = __('home.getSharedTableHeading');
        $content  = $this->user->sharedUrls()->with('owner')->get(['urls.owner_id', 'urls.short_url']);

        return [
            'tableName' => static::GET_SHARED_TABLE,
            'headings'  => $headings,
            'data'      => $content->map(function (Url $item) {
                return [
                    'short_url'  => $item->short_url,
                    'owner_name' => $item->owner->name,
                ];
            })->toArray(),
        ];
    }
}