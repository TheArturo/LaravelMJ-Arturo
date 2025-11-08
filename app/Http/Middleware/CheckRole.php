<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     * Parameter can be role name (e.g. admin) or role id (e.g. 1)
     * Usage in routes: ->middleware('role:admin') or ->middleware('role:1')
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $role
     */
    public function handle(Request $request, Closure $next, ?string $role = null)
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('dashboard');
        }

        if (! $role) {
            // no role specified -> allow
            return $next($request);
        }

        // if numeric, compare by id
        if (is_numeric($role)) {
            if ((int) $user->role_id === (int) $role) {
                return $next($request);
            }
        } else {
            // compare by role name if relation exists
            $nombre = optional($user->role)->nombre;
            if ($nombre && strcasecmp($nombre, $role) === 0) {
                return $next($request);
            }
        }

        // not allowed
        // redirect to dashboard with message
        return redirect()->route('dashboard')->with('error', 'No tienes permiso para acceder a esa sección.');
    }
}
