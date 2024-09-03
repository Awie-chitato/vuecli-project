<?php

namespace App\Http\Controllers;

use App\Models\event_anyar;
use App\Models\EventAnyar;
use App\Models\EventTransaksi;
use App\Models\events_fpti;
use Illuminate\Http\Request;

class EventFptiController extends Controller
{
      /**
     * Display a listing of the resource.
     */
    public function indexEvent_Anyar()
    {
        $event_anyar = EventAnyar::all();
        return response()->json(['success' => true, 'data' => $event_anyar], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createEvent_Anyar (Request $request)
    {
        $validatedData = $request->validate([
            'nama_event' => 'required',
            'tempat_event' => 'required',
            'tanggal_event' => 'required',
        ]);
        $event_anyar = EventAnyar::create($validatedData);

        // Kembalikan respons JSON
        return response()->json(['success' => true, 'message' => 'Event berhasil disimpan', 'data' => $event_anyar], 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeEvent_Anyar(Request $request)
    {
        $validatedData = $request->validate([
            'nama_event' => 'required',
            'tempat_event' => 'required',
            'tanggal_event' => 'required',
        ]);

        $event_anyar = EventAnyar::create($validatedData);

        return response()->json(['success' => true, 'message' => 'Event berhasil disimpan', 'data' => $event_anyar], 201);
    }

    /**
     * Display the specified resource.
     */
    public function showEvent_Anyar(string $id)
    {
        $event_anyar = EventAnyar::findOrFail($id);
        return response()->json(['success'=> true, 'melihat data sukses' => $event_anyar], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */

     public function editEvent_Anyar(string $id)
     {
         $event_anyar = EventAnyar::findOrFail($id);
         return response()->json(['success'=> true, 'melihat data sukses' => $event_anyar], 200);
     }
    /**
     * Update the specified resource in storage.
     */
    public function updateEvent_Anyar(Request $request, $id)
    {
       
        $event_anyar = EventAnyar::findOrFail($id);
    
        $validatedData = $request->validate([
            'nama_event' => 'required|string|max:255',
            'tempat_event' => 'required|string',
            'tanggal_event' => 'required|date',
        ]);
    
        $event_anyar->update($validatedData);
    
        return response()->json([
            'status' => 'success',
            'message' => 'Event berhasil diperbarui',
            'data' => $event_anyar
        ], 200);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function deleteEvent_Anyar(string $id)
    {
        try {
            // Temukan event
            $event_anyar = EventAnyar::findOrFail($id);
    
    
            // Hapus event
            $event_anyar->delete();
    
            return response()->json(['message' => 'Event deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete event', 'message' => $e->getMessage()], 500);
        }
    }
}
