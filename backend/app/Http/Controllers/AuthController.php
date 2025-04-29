<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'mdp');

        try {
            // Vérification avec le champ personnalisé 'mdp'
            if (!$token = JWTAuth::attempt([
                'email' => $credentials['email'],
                'password' => $credentials['mdp']
            ])) {
                return response()->json(['error' => 'Identifiants invalides'], 401);
            }

            $client = Auth::user();
            return response()->json([
                'token' => $token,
                'user' => $client,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60
            ]);
            
        } catch (JWTException $e) {
            return response()->json(['error' => 'Impossible de créer le token'], 500);
        }
    }
}