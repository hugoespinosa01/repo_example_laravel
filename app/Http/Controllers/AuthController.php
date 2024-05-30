<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{

public function login(Request $request){
    $credentials = $request->only('email', 'password');

    if ($token = auth() -> attempt($credentials)) {
        return $this -> respondWithToken($token);
    }else{
        return response() -> json([
            'message' => 'Credenciales incorrectas'
        ], 400);
    }
}

public function register(Request $request){
    
    $validator = Validator::make($request -> all(), [
        'name' => 'required|string',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:6'
    ]);

    if ($validator -> fails()){
        $data = [
            'message' => 'Error de validación',
            'errors' => $validator -> errors(),
            'status' => 400
        ];
        return response() -> json($data, 400);
    }

    $user = User::create([
        'name' => $request -> name,
        'email' => $request -> email,
        'password' => Hash::make($request -> password)
    ]);

    if (!$user) {
        return response() -> json([
            'message' => 'Error al crear el usuario'
        ], 500);
    }

    return response() -> json([
        'message' => 'Usuario creado exitosamente'
    ], 201);


}

public function respondWithToken($token){
    return response() -> json([
        'token' => $token,
        'token_type' => 'bearer',
        'expires_in' => Auth::factory() -> getTTL() * 60
    ]);


}

}
