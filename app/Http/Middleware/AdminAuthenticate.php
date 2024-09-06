<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class AdminAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function postLogon(Request $request)
{
    \Log::info('Login attempt for email: ' . $request->email);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        \Log::info('Login successful, user ID: ' . $user->id . ', role: ' . $user->role);

        if ($user->role == 1) {
            \Log::info('Redirecting to admin.index');
            return redirect()->route('admin.index');
        } else {
            Auth::logout();
            \Log::info('User is not admin, logging out.');
            return redirect()->route('logon')->with('err', 'Access denied.');
        }
    }

    \Log::info('Login failed for email: ' . $request->email);
    return redirect()->back()->with('err', 'Sai thông tin');
}


}

