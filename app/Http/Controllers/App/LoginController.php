<?php

namespace App\Http\Controllers\App;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request) {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['message' => 'Email ou mot de passe incorrectes'], 401);
        }

            $user = User::where('email', $request->email)->firstOrFail();
            $token = $user->createToken('ADMIN_AUTH_TOKEN')->plainTextToken;
            return response()->json(['access_token' => $token]);
    }
}
