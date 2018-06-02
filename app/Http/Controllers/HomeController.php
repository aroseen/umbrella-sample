<?php

namespace App\Http\Controllers;

use App\Components\Api;
use App\Http\Requests\CreateUrlRequest;
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
     * @return Response|View
     */
    public function index()
    {
        return view('home.index');
    }

    /**
     * @param CreateUrlRequest $request
     * @return Response|View
     */
    public function create(CreateUrlRequest $request)
    {
        dd($request, auth()->user());

        return redirect()->back();
    }

    /**
     * @param CreateUrlRequest $request
     * @param Api              $api
     * @return JsonResponse
     */
    public function generateShortUrl(CreateUrlRequest $request, Api $api): JsonResponse
    {
        if ($request->ajax()) {
            $urlWithSalt = $request->input('origin_url').auth()->user()->getAuthIdentifier();
            try {
                return new JsonResponse([
                    'status' => self::STATUS_SUCCESS,
                    'text'   => $api->getShortUrl($urlWithSalt),
                ], 200);
            } catch (ClientException | ConnectException | ServerException $exception) {
                return new JsonResponse([
                    'status' => self::STATUS_ERROR,
                    'errors' => $exception->getMessage(),
                ], 422);
            }
        }

        return new JsonResponse([
            'status' => self::STATUS_ERROR,
        ], 422);
    }
}
