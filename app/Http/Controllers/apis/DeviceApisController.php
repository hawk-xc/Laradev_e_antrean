<?php

namespace App\Http\Controllers\apis;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeviceApisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $devices = [];

        foreach (Device::where('user_id', $request->user()->id)->get() as $device) {
            $devices[] = $device;
            $device['user_name'] = $device->User->name;
            $device['created_at_diff'] = $device->created_at->diffForHumans();
        }

        return response()->json([
            'status' => 200,
            'total' => Device::where('user_id', $request->user()->id)->count(),
            'data' => $devices
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request['user_id'] = $request->user()->id;

        $validated = $request->validate([
            'user_id' => 'required',
            'device_name' => 'required',
            'device_year' => 'required',
            'drive_link' => 'nullable',
        ]);

        try {
            // Masukkan data ke dalam database
            $device = Device::create($validated);

            // Kembalikan respons JSON
            return response()->json([
                'status' => 200,
                'data' => $device
            ], 200);
        } catch (\Exception $e) {
            // Log error
            // Log::error('Error creating device: ' . $e->getMessage());

            // Kembalikan respons error
            return response()->json([
                'status' => 500,
                'error' => 'Internal Server Error'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Device $device)
    {
        return response()->json([
            'data' => 'data',
            'status' => $device
        ], 200);
    }

    /**
     * Show the form for editing the sp
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Device $device)
    {
        $request['user_id'] = $request->user()->id;

        $validated = $request->validate([
            'user_id' => 'required',
            'device_name' => 'required',
            'device_year' => 'required',
            'drive_link' => 'nullable',
        ]);

        try {
            // Masukkan data ke dalam database
            $device = Device::find($device->id)->update($validated);

            // Kembalikan respons JSON
            return response()->json([
                'status' => 200,
                'data' => $device
            ], 200);
        } catch (\Exception $e) {
            // Log error
            // Log::error('Error creating device: ' . $e->getMessage());

            // Kembalikan respons error
            return response()->json([
                'status' => 500,
                'error' => 'Internal Server Error'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Device $device)
    {
        Device::destroy($device->id);
        return response()->json([
            'status' => 200,
            'data' => 'sukses',
        ], 200);
    }
}
