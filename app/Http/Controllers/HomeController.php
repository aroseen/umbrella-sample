<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUrlRequest;
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
}
