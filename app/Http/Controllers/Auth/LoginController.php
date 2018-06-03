<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        logout as public logoutTrait;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @param Request $request
     * @param         $user
     */
    protected function authenticated(Request $request, $user): void
    {
        event('log:event:userLogin', [
            'user' => $user,
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function logout(Request $request): RedirectResponse
    {
        event('log:event:userLogout', [
            'user' => auth()->user(),
        ]);

        return $this->logoutTrait($request);
    }
}
