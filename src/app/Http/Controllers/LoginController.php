<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (!Auth::attempt([
            'username' => $request->username,
            'password' => $request->password,
        ])) {
            return response()->json([
                'errors' => 'Username dan Password anda salah'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = User::Where('username', $request->username)->first();
        $token = $user->createToken($user->username)->plainTextToken;

        $expiration = config('sanctum.expiration');;

        return response()->json([
            'token' => $token,
            'exp' => now()->addMinutes($expiration)->diffForHumans()
        ], Response::HTTP_OK);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Berhasil Logout'
        ], Response::HTTP_OK);
    }
}
