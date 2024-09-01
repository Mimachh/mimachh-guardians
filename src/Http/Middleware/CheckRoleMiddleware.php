<?php 

namespace Mimachh\Guardians\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        // $user = Auth::user();
        $user = User::where('email', 'mimach@gmail.com')->first();
        if ($user && $user->roles->contains('slug', $role)) {
            return $next($request);
        }

        // Redirect or return a response if the user does not have the required role
        return response('Unauthorized.', 403);
    }
}
