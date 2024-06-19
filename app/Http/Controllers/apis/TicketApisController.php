<?php

namespace App\Http\Controllers\apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\Ticket;
use Illuminate\Support\Facades\Validator;

class TicketApisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $id = $request->user()->id;

        return response()->json([
            'id' => $id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id = $request->user()->id;

        $request->only(['device_id', 'description', 'image_link']);

        if ($validator = Validator::make($request->all(), [
            'device_id' => 'required|int',
            'description' => 'required|string|min:5',
            'image_link' => 'nullable|url:http,https'
        ])) {
            return response()->json([
                'status' => 200,
                'data' => $request->all()
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'data' => $validator->errors()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }
}
