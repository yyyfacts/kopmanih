<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use App\Models\User;

class DashboardController extends Controller
{
    protected $auth;

    public function __construct()
    {
        $firebase = (new Factory)->withServiceAccount(base_path('firebase.json'));
        $this->auth = $firebase->createAuth();
    }

    public function index(Request $request)
    {
        $idToken = $request->bearerToken() ?? $request->cookie('firebase_token');

        if (!$idToken) {
            return redirect('/login')->withErrors(['msg' => 'Token not provided']);
        }

        try {
            $verifiedIdToken = $this->auth->verifyIdToken($idToken);
            $uid = $verifiedIdToken->claims()->get('sub');
            $firebaseUser = $this->auth->getUser($uid);

            $user = User::where('firebase_uid', $uid)->first();
            if (!$user || $user->role !== 'user') {
                return redirect('/login')->withErrors(['msg' => 'Unauthorized']);
            }

            return view('dashboard.index', [
                'email' => $firebaseUser->email,
                'uid' => $uid,
            ]);

        } catch (\Throwable $e) {
            return redirect('/login')->withErrors(['msg' => 'Invalid or expired token']);
        }
    }

    public function admin(Request $request)
    {
        $idToken = $request->bearerToken() ?? $request->cookie('firebase_token');

        if (!$idToken) {
            return redirect('/login')->withErrors(['msg' => 'Token not provided']);
        }

        try {
            $verifiedIdToken = $this->auth->verifyIdToken($idToken);
            $uid = $verifiedIdToken->claims()->get('sub');
            $firebaseUser = $this->auth->getUser($uid);

            $user = User::where('firebase_uid', $uid)->first();
            if (!$user || $user->role !== 'admin') {
                return redirect('/login')->withErrors(['msg' => 'Unauthorized']);
            }

            return view('admin.dashboard', [
                'email' => $firebaseUser->email,
                'uid' => $uid,
            ]);

        } catch (\Throwable $e) {
            return redirect('/login')->withErrors(['msg' => 'Invalid or expired token']);
        }
    }
}
