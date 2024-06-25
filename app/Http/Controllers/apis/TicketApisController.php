<?php

namespace App\Http\Controllers\apis;

use App\Http\Controllers\Controller;
use App\Models\Device;
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
        try {
            // Ambil ID pengguna yang sedang login
            $userId = $request->user()->id;

            // Query untuk mendapatkan semua perangkat yang dimiliki oleh pengguna
            $userDevices = Device::where('user_id', $userId)->get();

            // Array untuk menyimpan semua tiket dari semua perangkat
            $tickets = [];

            // Loop melalui setiap perangkat pengguna
            foreach ($userDevices as $device) {
                // Query untuk mendapatkan semua tiket dari perangkat ini
                $deviceTickets = Ticket::where('device_id', $device->id)->get();

                // Loop melalui setiap tiket dari perangkat ini
                foreach ($deviceTickets as $ticket) {
                    $ticket['created_at_diff'] = $ticket->created_at->diffForHumans();
                    // Anda mungkin ingin menambahkan informasi tambahan lainnya di sini

                    // Tambahkan tiket ke dalam array $tickets
                    $tickets[] = $ticket;
                }
            }

            // Kirim respons JSON yang berisi semua tiket
            return response()->json([
                $tickets,
            ]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }




    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $id = $request->user()->id;

    //     $request->only(['device_id', 'description', 'image_link']);

    //     if ($validator = Validator::make($request->all(), [
    //         'device_id' => 'required|int',
    //         'description' => 'required|string|min:5',
    //         'image_link' => 'nullable|url:http,https'
    //     ])) {
    //         return response()->json([
    //             'status' => 200,
    //             'data' => $request->all()
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status' => 404,
    //             'data' => $validator->errors()
    //         ]);
    //     }
    // }

    public function store(Request $request)
    {
        // Validasi input yang diterima dari request
        $validated = $request->validate([
            'user_id' => 'required|int',
            'device_name' => 'required|string',
            'device_year' => 'required|string',
            'drive_link' => 'nullable|string',
        ]);

        try {
            // Buat tiket baru berdasarkan data yang divalidasi
            $ticket = Ticket::create([
                'user_id' => $validated['user_id'],
                'device_name' => $validated['device_name'],
                'device_year' => $validated['device_year'],
                'drive_link' => $validated['drive_link'],
            ]);

            // Kirim respons JSON berhasil dengan data tiket yang baru dibuat
            return response()->json([
                'status' => 200,
                'data' => $ticket,
                'message' => 'Ticket created successfully.'
            ], 200);
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi saat penyimpanan
            return response()->json([
                'status' => 500,
                'error' => 'Failed to store ticket: ' . $e->getMessage()
            ], 500);
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
