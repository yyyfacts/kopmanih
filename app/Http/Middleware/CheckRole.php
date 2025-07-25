<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();
        
        if (!$user->is_active) {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Akun Anda tidak aktif.');
        }

        if ($user->role !== $role) {
            // Redirect ke dashboard sesuai role user
            $roleRoutes = [
                'admin' => 'admin.dashboard',
                'bendahara' => 'bendahara.dashboard',
                'pengurus' => 'pengurus.dashboard'
            ];

            if (isset($roleRoutes[$user->role])) {
                return redirect()->route($roleRoutes[$user->role])
                    ->with('error', 'Anda tidak memiliki akses ke halaman tersebut. Dialihkan ke halaman dashboard Anda.');
            }

            return redirect()->route('login')
                ->with('error', 'Role tidak valid.');
        }

        return $next($request);
    }
}
