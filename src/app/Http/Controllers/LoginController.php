<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

use function Illuminate\Support\now;

class LoginController extends Controller
{
    public function index() {
        return view('login.index');
    }

    public function login(Request $request) {
        $validator = Validator::make(
            $request->all(),
            [
                'username' => 'required',
                'password' => 'required'
            ], [
                'username.required' => 'Username tidak boleh kosong',
                'password.required' => 'Password tidak boleh kosong'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $ip = $request->ip();
        $cacheKey = 'login_attempts:' . $ip;
        $attempts = Cache::get($cacheKey, 0);
        if ($attempts >= 5) {
            return response()->json([
                'message' => 'Login gagal, coba lagi'
            ], Response::HTTP_TOO_MANY_REQUESTS);
        }

        if (!Auth::attempt([
            'username' => $request->username,
            'password' => $request->password,
        ])) {
            Cache::put($cacheKey, $attempts + 1, now()->addMinutes(5));
            return response()->json([
                'message' => 'Username dan Password anda salah'
            ], Response::HTTP_UNAUTHORIZED);
        }

        Cache::forget($cacheKey);

        $user = User::Where('username', $request->username)->first();
        Cache::put('user:', $user->id, $user, now()->addHour());

        $token = $user->createToken($user->username)->plainTextToken;

        $expiration = config('sanctum.expiration');;

        return response()->json([
            'token' => $token,
            'exp' => now()->addMinutes($expiration)->diffForHumans()
        ], Response::HTTP_OK);
    }

    public function logout(Request $request) {
        $user = $request->user();

        $request->user()->currentAccessToken()->delete();

        Cache::forget('user:'. $user->id);

        return response()->json([
            'message' => 'Berhasil Logout'
        ], Response::HTTP_OK);
    }
}
