<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $admin_url;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['guest:admin'])->except('logout');
        $this->admin_url = config('app.admin_url');
    }

    public function showLoginForm()
    {
        $logo = File::exists(public_path('storage/app_logo.png'));

        return view('admin.auth.login', [
            'logo' => $logo,
        ]);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();

        return redirect('/'.$this->admin_url.'/login');
    }

    public function username()
    {
        return 'email';
    }

    /**
     * Where to redirect users after login.
     */
    protected function redirectTo()
    {
        return $this->admin_url;
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request),
            $request->filled('remember')
        );
    }

    protected function authenticated(Request $request, $user)
    {
        $user->last_login = now();
        $user->save();
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|email|string',
            'password' => 'required|string',
        ]);
    }
}
