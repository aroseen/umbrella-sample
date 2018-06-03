<?php

namespace App\Http\Controllers;

use App\Components\Api;
use App\Components\Table;
use App\Http\Requests\CreateUrlRequest;
use App\Models\Share;
use App\Models\Url;
use App\Models\User;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

/**
 * Class HomeController.
 *
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Table $table
     * @return Response|View
     */
    public function index(Table $table)
    {
        return view('home.index', [
            'ownLinksTableContent'    => $table->ownLinksTableData(),
            'getSharedTableContent'   => $table->getSharedTableData(),
            'sharedLinksTableContent' => $table->sharedLinksTableData(),
        ]);
    }

    /**
     * @param CreateUrlRequest $request
     * @param Api              $api
     * @return Response|View
     */
    public function create(CreateUrlRequest $request, Api $api)
    {
        /** @var User $user */
        [$originUrl, $shortUrl, $user] = [$request->input('origin_url'), $request->input('short_url'), auth()->user()];
        if (!$shortUrl) {
            try {
                $urlWithSalt = $originUrl.$user->id;
                $shortUrl    = $api->getShortUrl($urlWithSalt);
                if (($count = Url::originUrlsCount($originUrl)) !== 0) {
                    $shortUrl = $api->getShortUrl($count.$urlWithSalt);
                }
            } catch (ClientException | ConnectException | ServerException $exception) {
                return redirect()->back()->withErrors($exception->getMessage());
            }
        } elseif (Url::shortUrlExists($shortUrl)) {
            return redirect()->back()->withErrors(__('home.shortUrlAlreadyExists', [
                'short_url' => $shortUrl,
            ]));
        }

        $user->ownUrls()->save(new Url([
            'owner_id'   => $user->id,
            'origin_url' => $originUrl,
            'short_url'  => $shortUrl,
        ]));

        $user->newQuery()->increment('short_urls_count');

        return redirect()->back()->with('success', __('home.createdSuccessfully', [
            'url' => $request->input('origin_url'),
        ]));
    }

    /**
     * @param CreateUrlRequest $request
     * @param Api              $api
     * @return JsonResponse
     */
    public function generateShortUrl(CreateUrlRequest $request, Api $api): JsonResponse
    {
        if ($request->ajax()) {
            $originUrl = $request->input('origin_url');
            try {
                $urlWithSalt = $originUrl.auth()->user()->getAuthIdentifier();
                $shortUrl    = $api->getShortUrl($urlWithSalt);
                if (($count = Url::originUrlsCount($originUrl)) !== 0) {
                    $shortUrl = $api->getShortUrl($count.$urlWithSalt);
                }

                return new JsonResponse([
                    'status' => self::STATUS_SUCCESS,
                    'short'  => trim(parse_url($shortUrl, PHP_URL_PATH), '/'),
                ], 200);
            } catch (ClientException | ConnectException | ServerException $exception) {
                return new JsonResponse([
                    'status'  => self::STATUS_ERROR,
                    'title'   => __('home.generatingUrlErrorHeader'),
                    'message' => $exception->getMessage(),
                ], 422);
            }
        }

        return new JsonResponse([
            'status'  => self::STATUS_ERROR,
            'title'   => __('home.errorTitle'),
            'message' => __('home.errorTitle'),
        ], 422);
    }

    /**
     * @param Request $request
     * @param Url     $url
     * @param User    $user
     * @return JsonResponse
     */
    public function shareUrl(Request $request, Url $url, User $user): JsonResponse
    {
        if ($request->ajax()) {
            /** @var User $authUser */
            $authUser = auth()->user();
            if ($authUser->can('share', $url)) {
                $user->shares()->firstOrCreate([
                    'url_id' => $url->id,
                ]);

                return new JsonResponse([
                    'status'  => self::STATUS_SUCCESS,
                    'title'   => __('home.successTitle'),
                    'message' => __('home.sharingSuccess', [
                        'url'      => $url->short_url,
                        'username' => $user->name,
                    ]),
                ], 200);
            }
        }

        return new JsonResponse([
            'status'  => self::STATUS_ERROR,
            'title'   => __('home.errorTitle'),
            'message' => __('home.sharingError', [
                'url' => $url->short_url,
            ]),
        ], 422);
    }

    /**
     * @param Request $request
     * @param Url     $url
     * @param User    $user
     * @return JsonResponse
     */
    public function unshareUrl(Request $request, Url $url, User $user): JsonResponse
    {
        if ($request->ajax()) {
            /** @var User $authUser */
            $authUser = auth()->user();
            if ($authUser->can('unshare', $url)) {
                Share::query()->where([
                    'url_id'  => $url->id,
                    'user_id' => $user->id,
                ])->delete();

                return new JsonResponse([
                    'status'  => self::STATUS_SUCCESS,
                    'title'   => __('home.successTitle'),
                    'message' => __('home.unsharingSuccess', [
                        'url'      => $url->short_url,
                        'username' => $user->name,
                    ]),
                ], 200);
            }
        }

        return new JsonResponse([
            'status'  => self::STATUS_ERROR,
            'title'   => __('home.errorTitle'),
            'message' => __('home.unsharingError', [
                'url' => $url->short_url,
            ]),
        ], 422);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function toggleCanShare(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            /** @var User $authUser */
            [$authUser, $canShare] = [auth()->user(), $request->input('canShare')];
            $authUser->update([
                'can_share' => $canShare,
            ]);

            return new JsonResponse([
                'status'  => self::STATUS_SUCCESS,
                'title'   => __('home.successTitle'),
                'message' => $canShare ? __('home.sharingActivated') : __('home.sharingDeactivated'),
            ], 200);
        }

        return new JsonResponse([
            'status'  => self::STATUS_ERROR,
            'title'   => __('home.errorTitle'),
            'message' => __('home.unknownError'),
        ], 422);
    }

    /**
     * @param Request $request
     * @param Table   $table
     * @return JsonResponse
     */
    public function reloadTables(Request $request, Table $table): JsonResponse
    {
        if ($request->ajax()) {
            [$tables, $response] = [$request->input('tables'), []];

            if (\in_array(Table::OWN_LINKS_TABLE, $tables, true)) {
                $tableContent                     = $table->ownLinksTableData();
                $response[Table::OWN_LINKS_TABLE] = view('elements.table', [
                    'tableName' => $tableContent['tableName'],
                    'header'    => __('home.selfLinksLabel'),
                    'headings'  => $tableContent['headings'],
                    'rowsData'  => $tableContent['data'],
                ])->render();
            }

            if (\in_array(Table::GET_SHARED_TABLE, $tables, true)) {
                $tableContent                      = $table->getSharedTableData();
                $response[Table::GET_SHARED_TABLE] = view('elements.table', [
                    'tableName' => $tableContent['tableName'],
                    'header'    => __('home.availableLinksLabel'),
                    'headings'  => $tableContent['headings'],
                    'rowsData'  => $tableContent['data'],
                ])->render();
            }

            if (\in_array(Table::SHARED_LINKS_TABLE, $tables, true)) {
                $tableContent                        = $table->sharedLinksTableData();
                $response[Table::SHARED_LINKS_TABLE] = view('elements.table', [
                    'tableName' => $tableContent['tableName'],
                    'header'    => __('home.sharedLinksLabel'),
                    'headings'  => $tableContent['headings'],
                    'rowsData'  => $tableContent['data'],
                ])->render();
            }

            return new JsonResponse([
                'status' => self::STATUS_SUCCESS,
                'tables' => $response,
            ], 200);
        }

        return new JsonResponse([
            'status'  => self::STATUS_ERROR,
            'title'   => __('home.errorTitle'),
            'message' => __('home.reloadTablesError'),
        ], 422);
    }

    /**
     * @param Request $request
     * @param Url     $url
     * @return JsonResponse
     */
    public function getUsersToShare(Request $request, Url $url): JsonResponse
    {
        if ($request->ajax()) {
            /** @var User $user */
            $user = auth()->user();

            return new JsonResponse([
                'status' => self::STATUS_SUCCESS,
                'users'  => $user->getUsersToShare($url)->toArray(),
            ], 200);
        }

        return new JsonResponse([
            'status'  => self::STATUS_ERROR,
            'title'   => __('home.errorTitle'),
            'message' => __('home.errorTitle'),
        ], 422);
    }
}
