<?php

namespace App\Http\Controllers\apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginApisController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => false,
            'data' => 'unauthorized'
        ], 404);
    }

    public function login(Request $request)
    {
        $data = $request->only(['email', 'password']);
        $ability = [];

        switch (User::where('email', $request->email)->first()->role) {
            case 'admin':
                $ability = ['get-product', 'update-product', 'delete-product', 'create-product'];
                break;
            case 'user':
                $ability = ['get-product'];
                break;
            default:
                $ability = ['get-product'];
        }

        if (Auth::attempt($data)) {
            return response()->json([
                'status' => true,
                'data' => 'user successfull auth',
                'token' => $request->user()->createToken('api-auth', $ability)->plainTextToken
            ]);
        }
    }
}
