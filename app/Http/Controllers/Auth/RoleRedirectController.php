<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RoleRedirectController extends Controller
{
    public function redirect()
    {
        return match (Auth::user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'pengurus' => redirect()->route('pengurus.dashboard'),
            'bendahara' => redirect()->route('bendahara.dashboard'),
            default => abort(403, 'Role tidak valid.'),
        };
    }
}
