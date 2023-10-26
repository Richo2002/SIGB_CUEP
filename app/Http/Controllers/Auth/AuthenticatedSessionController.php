<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Login;
use OwenIt\Auditing\Models\Audit;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Facades\Auditor;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $this->addLoginAudit(Auth::user());

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function addLoginAudit($user)
    {
        $audit = new Audit();
        $audit->event = 'login';
        $audit->auditable_type = get_class($user);
        $audit->auditable_id = $user->id;
        $audit->url = request()->fullUrl();
        $audit->ip_address = request()->ip();
        $audit->user_agent = request()->userAgent();
        $audit->save();
    }
}
