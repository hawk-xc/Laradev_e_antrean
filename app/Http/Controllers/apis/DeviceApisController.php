<?php

namespace App\Http\Controllers\apis;

use App\Http\Controllers\Controller;
use App\Http\Resources\DeviceResource;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DeviceApisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return Device::where('user_id', Auth::user()->id)->get();
        $device =  Device::all();
        return new DeviceResource(true, 'List Data Posts', $device);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'device_name' => 'required|min:3',
            'device_year' => 'required|numeric|digits:4|min:1990|max:' . date('Y'),
            'drive_link' => 'nullable|url',
            'device_image' => 'nullable|image|max:1024|mimes:jpg,png,jpeg',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if ($request->hasFile('device_image')) {
            $image = $request->file('device_image');
            $image->storeAs('public/posts', $image->hashName());
        }

        $device = Device::create([
            // 'user_id' => Auth::user()->id,
            'user_id' => $request->user_id,
            'device_name' => $request->device_name,
            'device_year' => $request->device_year,
            'drive_link' => $request->drive_link,
            // 'image_link' => $image->hashName(),
        ]);
        return new DeviceResource(true, 'Data Perangkat Berhasil Ditambahkan', $device);
    }

    /**
     * Display the specified resource.
     */
    public function show(Device $device)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Device $device)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Device $device)
    {
        //
    }
}
