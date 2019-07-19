<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Hash;
use App\User;
use Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('90Days')->accessToken;
            return response()->json(['success' => $success], 200);
        } else {
            return response()->json(['errors' => 'unauthorized'], 401);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:190',
            'email' => 'required|unique:users|max:190',
            'password' => 'required|min:6|max:36'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        $response['token'] = $user->createToken('90days')->accessToken;
        $response['name'] = $user->name;
        return response()->json(['success' => $response], 201);
    }

    public function details(Request $request)
    {
        $user = Auth::user();
        return response()->json(['success' => $user], 200);
    }
}
