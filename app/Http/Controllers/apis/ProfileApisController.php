<?php

namespace App\Http\Controllers\apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileApisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'status' => 200,
            'data' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = $request->user()->id;

        $request->only(['username', 'name', 'email', 'password']);
        //

        return response()->json([
            'data' => $request
        ]);
    }

    public function update_password(Request $request)
    {

        // Validasi input
        $validator = Validator::make($request->all(), [
            'b_password' => 'required',
            'n_password' => 'required|min:6',
            'c_password' => 'required|same:n_password',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Dapatkan user saat ini
        $user = $request->user();

        // Periksa apakah password lama cocok
        if (!Hash::check($request->b_password, $user->password)) {
            return response()->json(['error' => 'Old password is incorrect'], 400);
        }

        // Update password
        $user->password = Hash::make($request->n_password);
        $user->save();

        return response()->json(['message' => 'Password updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
