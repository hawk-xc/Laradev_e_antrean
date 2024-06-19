<?php

namespace App\Http\Controllers\apis;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthApisController extends Controller
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

        switch (User::where('email', $request->email)->first()->role_id) {
            case 1:
                $ability = ['get-statistic', 'get-proces', 'update-proces', 'create-proces', 'remove-proces'];
                break;
            case 2:
                $ability = ['get-proces', 'update-proces'];
                break;
            case 3:
                $ability = ['get-proces', 'update-proces'];
                break;
            default:
                $ability = ['get-profile', 'get-device', 'get-ticket', 'create-device', 'upate-device', 'delete-device', 'create-ticket', 'update-ticket', 'delete-ticket'];
                break;
        }

        if (Auth::attempt($data)) {
            return response()->json([
                'status' => 200,
                'data' => 'user successfull auth',
                'username'=> Auth::user()->username,
                'token' => $request->user()->createToken('api-auth', $ability)->plainTextToken
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'data' => 'user not found'
            ]);
        }
    }

    public function register(Request $request)
    {
        $data = $request->only(['username', 'name', 'email', 'password']);

        $rules = [
            'username' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => true,
                'data' => $validator->errors()
            ]);
        } else {
            $data['password'] = bcrypt($request['password']);
            User::create($data);

            return response()->json([
                'status' => true,
                'data' => 'user successfull saved!'
            ]);
        }
    }
}
