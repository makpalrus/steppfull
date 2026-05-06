<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if ($user && $user->is_banned) {
            Auth::logout();
            return redirect('/login')->with('error', '🔒 Ваш аккаунт заблокирован администрацией.');
        }

        if (empty($roles)) {
            return $next($request);
        }

        if ($user && in_array($user->role, $roles)) {
            return $next($request);
        }

        abort(403, 'Доступ запрещён');
    }
}