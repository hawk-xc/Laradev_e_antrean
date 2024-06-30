<?php

namespace App\Http\Controllers\apis;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Proces;
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
        // Validasi input dari request
        $validated = $request->validate([
            'device_name' => 'required|string',
            // 'device_id' => 'required|integer',
            'description' => 'required|min:3',
            'image_link' => 'nullable|min:3',
            // 'device_image' => 'nullable|image|max:1024|mimes:jpg,png,jpeg',
        ]);

        try {
            // Proses upload gambar jika ada
            // if ($request->hasFile('device_image')) {
            //     $image = $request->file('device_image');
            //     $name = md5($image->getClientOriginalName() . microtime()) . '.' . $image->getClientOriginalExtension();
            //     $image->storeAs('public/ticket_assets', $name);
            //     $validated['image_link'] = $name;
            // }

            // Tambahkan tanggal pembuatan dan tanggal penutupan default

            $device_id = Device::where('device_name', $request->device_name)->pluck('id')->first();

            // $validated['device_id'] = Device::where('device_name', $request->device_name)->pluck('id')->first();
            // return ($device_id);
            $validated['device_id'] = $device_id;
            $validated['created_at'] = now()->format('Y-m-d H:i:s');
            $validated['closed_at'] = now()->addDay(3)->format('Y-m-d H:i:s');

            // return ($validated['device_id']);
            // Generate ID tiket berdasarkan tanggal dan nomor urut hari itu
            $today = now()->format('Y-m-d');
            $count = Ticket::whereDate('created_at', $today)->count();
            $validated['id_ticket'] = now()->format('ymd') . ($count + 1);

            // Simpan data tiket baru
            // dd($validated);
            $ticket = Ticket::create($validated);

            // Buat entri proses untuk tiket yang baru dibuat
            $processData = [
                'status_id' => 1, // Status default untuk proses baru
                'ticket_id' => $ticket->id,
            ];
            Proces::create($processData);

            // Kirim respons sukses
            return response()->json([
                'status' => 'success',
                'message' => 'Ticket created successfully!',
                'ticket' => $ticket,
            ], 200);
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi saat menyimpan data
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create ticket: ' . $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     // Validasi input dari request

    //     $validated = $request->validate([
    //         'device_id' => 'required|numeric',
    //         'description' => 'required|min:3',
    //         'image_link' => 'nullable|min:3', // Jika memungkinkan ada gambar baru
    //     ]);

    //     try {
    //         // Mencari tiket berdasarkan ID
    //         $ticket = Ticket::find($id);

    //         if (!$ticket) {
    //             return response()->json(['success' => false, 'message' => 'Data Tiket Tidak Ditemukan'], 404);
    //         }

    //         // Proses upload gambar jika ada


    //         // Event logging untuk interaksi pengguna
    //         event(new \App\Events\UserInteraction($request->user(), "Ticket => update ticket " . $ticket->id));

    //         $device_id = Device::where('device_name', $request->device_name)->pluck('id')->first();
    //         // dd($device_id);
    //         $validated['device_id'] = $device_id;


    //         // Mengupdate data tiket
    //         $ticket->update($validated);
    //         if ($ticket->update($validated)) {
    //             return response()->json([
    //                 'success' => true,
    //                 'message' => 'Data Tiket Berhasil Diperbarui!',
    //                 'ticket' => $ticket
    //             ]);
    //         }

    //         return response()->json(['success' => false, 'message' => 'Gagal Memperbarui Data Tiket'], 500);
    //     } catch (\Exception $e) {
    //         return response()->json(['success' => false, 'message' => 'Terjadi Kesalahan: ' . $e->getMessage()], 500);
    //     }
    // }
    public function update(string $id, Request $request)
    {
        // Validasi input dari request
        $validated = $request->validate([
            // 'device_id' => 'required|numeric',
            'description' => 'required|min:3',
            'image_link' => 'nullable|min:3', // Jika memungkinkan ada gambar baru
        ]);

        try {
            // Mencari tiket berdasarkan ID
            $ticket = Ticket::find($id);

            if (!$ticket) {
                return response()->json(['success' => false, 'message' => 'Data Tiket Tidak Ditemukan'], 404);
            }

            // Proses upload gambar jika ada (tidak disertakan dalam contoh saat ini)

            // Event logging untuk interaksi pengguna
            // event(new \App\Events\UserInteraction($request->user(), "Ticket => update ticket " . $ticket->id));
            // $validated['device_id'] = $request->device_name;
            $validated['device_id'] = Device::where('device_name', $request->device_name)->pluck('id')->first();
            // Perbarui data tiket
            $ticket->update($validated);
            // Ticket::where('id', $ticket->id)->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Data Tiket Berhasil Diperbarui!',
                'ticket' => $ticket
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi Kesalahan: ' . $e->getMessage()], 500);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            // Mencari tiket berdasarkan ID
            $ticket = Ticket::find($id);

            if (!$ticket) {
                return response()->json(['success' => false, 'message' => 'Data Tiket Tidak Ditemukan'], 404);
            }

            // Mengupdate status pada model Proces
            $update = Proces::where('ticket_id', $ticket->id)->update(['status_id' => 5]);

            if ($update) {
                // Event logging untuk interaksi pengguna
                event(new \App\Events\UserInteraction($request->user(), "Ticket => closed ticket " . $ticket->id));

                // Menghapus tiket setelah status diperbarui
                $ticket->delete();

                return response()->json(['success' => true, 'message' => 'Data Tiket Berhasil Dihapus']);
            }

            return response()->json(['success' => false, 'message' => 'Gagal Mengupdate Status Tiket'], 500);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi Kesalahan: ' . $e->getMessage()], 500);
        }
    }
}
