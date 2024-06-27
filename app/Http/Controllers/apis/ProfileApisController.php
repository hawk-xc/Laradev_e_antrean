<?php

namespace App\Http\Controllers\apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\{
    Device,
    Ticket,
    User,
    Proces
};

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
        $user = $request->user();

        $request->only(['username', 'name', 'email', 'b_password', 'n_password', 'c_password']);

        if (isset($request->b_password) && isset($request->n_password) && isset($request->c_password)) {
            $validator = Validator::make($request->all(), [
                'username' => 'nullable',
                'name' => 'nullable',
                'email' => 'nullable',
                'b_password' => 'required',
                'n_password' => 'required|min:6',
                'c_password' => 'required|same:n_password',
            ]);

            if (!Hash::check($request->b_password, $user->password)) {
                return response()->json(['error' => 'Old password is incorrect'], 400);
            }

            $user->password = Hash::make($request->n_password);
        } else {
            $validator = Validator::make($request->all(), [
                'username' => 'nullable',
                'name' => 'nullable',
                'email' => 'nullable',
            ]);
        }

        $user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        $status = $user->save();

        if ($status) {
            return response()->json([
                'status' => 200,
                'data' => 'data user berhasil diperbahrui!'
            ], 200);
        } else {
            return response()->json([
                'status' => 400,
                'data' => 'data user gagal diperbahrui!'
            ]);
        }
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
    public function destroy(Request $request)
    {
        $devices = Device::where('user_id', $request->user()->id);
        $ticket = Ticket::whereIn('device_id', $devices->pluck('id'));
        $proces = Proces::whereIn('ticket_id', $ticket->pluck('id'));

        try {
            if ($ticket->count() < 1) {
                // menghapus semua data device
                if ($devices->count() >= 0) {
                    $delete_device = $devices->get()->each->delete();
                    if ($delete_device) {
                        $request->user()->delete();
                        return response()->json([
                            'status' => 200,
                            'data' => 'user berhasil dihapus!',
                        ], 200);
                    }
                }
            } else {
                return response()->json([
                    'status' => 405,
                    'data' => 'user gagal dihapus!'
                ], 405);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'data' => $e
            ], 404);
        }
    }
}
