<?php
/**
 * Created by PhpStorm.
 * User: aRosen_LN
 * Date: 02.06.2018
 * Time: 22:56
 */

namespace App\Components;

use App\Helpers\Helper;
use GuzzleHttp\Client;

/**
 * Class Api.
 *
 * @package App\Components
 */
class Api
{
    public const GET_SHORT_METHOD = 'getShort';

    /**
     * @var string
     */
    private $apiUrl;

    /**
     * Api constructor.
     * @param string $apiUrl
     */
    public function __construct(string $apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

    /**
     * @param string $originUrl
     * @return string
     */
    public function getShortUrl(string $originUrl): string
    {
        $requestUrl = $this->makeRequestUrl(static::GET_SHORT_METHOD, [
            'url'    => $originUrl,
            'prefix' => Helper::getShortUrlPrefix().'/',
        ]);

        $response = (new Client([
            'verify' => false,
        ]))->get($requestUrl);

        return json_decode((string) $response->getBody()->getContents())->short;
    }

    /**
     * @param string $method
     * @param array  $params
     * @return string
     */
    private function makeRequestUrl(string $method, array $params = []): string
    {
        $params['api_token'] = auth()->user()->api_token;

        return $this->apiUrl.'/'.$method.'?'.http_build_query($params);
    }
}