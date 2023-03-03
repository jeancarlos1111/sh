<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use \stdClass;


class AuthController extends Controller
{
    public function register(Request $request): JsonResponse {

        $validator = Validator::make($request->all(), [
            'cedula' => 'required|string|unique:users,cedula|max:12',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|min:8|confirmed',
        ]);
 
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
 
        $user = User::create([
            'cedula' => $request->cedula,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);

    }

    public function login(Request $request): JsonResponse {

        if (!Auth::attempt($request->only(['cedula', 'password']))) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('cedula', $request->cedula)->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Hola '.$user->nombre.' '.$user->apellido,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    public function userProfile(Request $request): JsonResponse {

        return response()->json([
            'message' => 'Perfil del usuario',
            'user' => auth()->user()
        ]);

    }

    public function logout(): JsonResponse {

        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'A salido de la sesion con exito.'
        ]);
    }
}
