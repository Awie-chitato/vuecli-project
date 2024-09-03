<?php

namespace App\Http\Controllers;

use App\Models\EventAnyar;
use App\Models\EventPengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventPengeluaranController extends Controller
{
    public function indexEvent_Pengeluaran()
    {
        // Ambil semua data EventPengeluaran dengan memuat relasi eventanyar
        $event_pengeluarans = EventPengeluaran::with('eventAnyar')->get();

        // Map data untuk memasukkan event_name ke dalam respon
        $event_pengeluarans_with_name = $event_pengeluarans->map(function ($pengeluaran) {
            return [
                'id' => $pengeluaran->id,
                'event_id' => $pengeluaran->event_id,
                'nama_event' => $pengeluaran->eventAnyar->nama_event,
                'tempat_event' => $pengeluaran->eventAnyar->tempat_event,
                'nominal' => $pengeluaran->nominal,
                'tanggal' => $pengeluaran->tanggal,
                'deskripsi' => $pengeluaran->deskripsi,
                'metode_pembayaran' => $pengeluaran->metode_pembayaran,
                'status' => $pengeluaran->status,
            ];
        });

        // Kembalikan respon dengan data yang sudah dimodifikasi
        return response()->json(['success' => true, 'data' => $event_pengeluarans_with_name], 200);
    }

    public function createEvent_Pengeluaran(Request $request)
    {
        $validatedData = $request->validate([
            'nominal' => 'required',
            'deskripsi' => 'required',
            'metode_pembayaran'=> 'required',
            'status' => 'required',
            'event_id'=> 'required',
        ]);

        $validatedData['tanggal'] = now();
        $event_anyar = EventPengeluaran::create($validatedData);

        return response()->json(['success' => true, 'message' => 'Pengeluaran berhasil disimpan', 'data' => $event_anyar], 201);
    }

    public function storeEvent_Pengeluaran(Request $request)
    {
        $validatedData = $request->validate([
            'nominal' => 'required|numeric',
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string',
            'metode_pembayaran' => 'required|string',
            'status' => 'required|string',
            'event_id' => 'required|exists:event_anyar,id',
        ]);

        $event_pengeluaran = EventPengeluaran::create($validatedData);

        return response()->json(['success' => true, 'message' => 'Pengeluaran berhasil disimpan', 'data' => $event_pengeluaran], 201);
    }

    public function showEvent_Pengeluaran(string $event_id)
    {
        $event_pengeluaran = EventPengeluaran::where('event_id', $event_id)->get();
        return response()->json(['success' => true, 'melihat data sukses' => $event_pengeluaran], 200);
    }

    public function editEvent_Pengeluaran(string $id)
    {
        $event_pengeluaran = EventPengeluaran::findOrFail($id);
        return response()->json(['success' => true, 'melihat data sukses' => $event_pengeluaran], 200);
    }

    public function updateEvent_Pengeluaran(Request $request, $id)
    {
        try {
            $eventPengeluaran = EventPengeluaran::findOrFail($id);

            $validatedData = $request->validate([
                'nominal' => 'required|numeric',
                'deskripsi' => 'nullable|string',
                'metode_pembayaran' => 'required|string',
                'status' => 'required|string',
                'event_id' => 'required|exists:event_anyar,id',
            ]);
            $validatedData['tanggal'] = now();
            $eventPengeluaran->update($validatedData);
            return response()->json([
                'success' => true,
                'message' => 'Pengeluaran event berhasil diperbarui',
                'data' => $eventPengeluaran
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pengeluaran event tidak ditemukan',
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui pengeluaran event',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function deleteEvent_Pengeluaran(string $id)
    {
        try {
            $event_pengeluaran = EventPengeluaran::findOrFail($id);

            $result = $event_pengeluaran->delete();

            if ($result) {
                return response()->json(['success' => true, 'message' => 'Pengeluaran event berhasil dihapus'], 200);
            } else {
                return response()->json(['success' => false, 'error' => 'Gagal menghapus pengeluaran event'], 500);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['success' => false, 'error' => 'Pengeluaran event tidak ditemukan'], 404);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Gagal menghapus pengeluaran event', 'message' => $e->getMessage()], 500);
        }
    }
}
