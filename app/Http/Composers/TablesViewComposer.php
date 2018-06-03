<?php
/**
 * Created by PhpStorm.
 * User: aRosen_LN
 * Date: 03.06.2018
 * Time: 14:17
 */

namespace App\Http\Composers;

use Illuminate\View\View;
use stdClass;

/**
 * Class TablesViewComposer.
 *
 * @package App\Http\Composers
 */
class TablesViewComposer
{
    /**
     * @param View $view
     * @return void
     */
    public function compose(View $view): void
    {
        $data = $view->getData();
        if ($rowsData = array_get($data, 'rowsData')) {
            $rowsData = array_map(function ($item) {
                if (!\is_array($item)) {
                    $item = (array) $item;
                }

                if (array_key_exists('origin_url', $item) && $item['origin_url']) {
                    $item['origin_url'] = $this->wrapLink($item['origin_url'], true);
                }

                if (array_key_exists('short_url', $item) && $item['short_url']) {
                    $item['short_url'] = $this->wrapLink($item['short_url']);
                }

                return $item;
            }, $rowsData);
            array_set($data, 'rowsData', $rowsData);
        }
        $view->with($data);
    }

    /**
     * @param string $url
     * @param bool   $limit
     * @return string
     */
    private function wrapLink(string $url, bool $limit = false): string
    {
        return "<a href='{$url}'>".($limit ? str_limit($url, 25) : $url).'</a>';
    }
}