<?php

namespace App\Http\Controllers\apis;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProcessResource;
use App\Models\Device;
use App\Models\Proces;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProcessApisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $device = Device::where('user_id', Auth::user()->id)->get();
        // $ticket_id = Ticket::where('user_id', Auth::user()->id)->pluck('id');
        $ticket_id = Ticket::whereIn('device_id', $device->pluck('id'))->get()->pluck('id');
        $data = [
            'total_proces' => Proces::where('ticket_id', $ticket_id)->get()->count(),
            'total_ticket' => Ticket::whereIn('device_id', $device->pluck('id'))->get()->count(),
            'total_device' => Device::where('user_id', Auth::user()->id)->get()->count(),
        ];

        // $proces = Proces::where('user_id', Auth::user()->id)->get()->count();
        // $ticlet = Ticket::where('user_id', Auth::user()->id)->get()->count();
        // $device = Device::where('user_id', Auth::user()->id)->get()->count();
        return new ProcessResource(true, 'List Data Posts', $data);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'status_id' => 'required',
            'employe_id' => 'required',
        ]);

        $process = new Proces();
        $process->status_id = $request->status_id;
        $process->user_id = $request->employe_id;
        $process->save();

        return response()->json([
            'message' => 'Process created successfully',
            'process' => $process,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Proces $proces)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $process = Proces::findOrFail($id);

        return response()->json([
            'process' => $process,
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status_id' => 'required',
        ]);

        $process = Proces::findOrFail($id);
        $process->status_id = $request->status_id;
        $process->user_id = $request->employe_id ?? $process->user_id;
        $process->save();

        return response()->json([
            'message' => 'Process updated successfully',
            'process' => $process,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $proces = Proces::find($id);
        $proces->delete();
        if (!$proces) {
            return response()->json(['success' => false, 'message' => 'Data Proses Tidak Ditemukan'], 404);
        }
        $proces->delete();
        return response()->json(['success' => true, 'message' => 'Data Proses Berhasil Dihapus']);
    }
}
