<?php

namespace App\Http\Controllers;

use App\Models\EventAnyar;
use App\Models\EventTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventTransaksiController extends Controller
{
    public function indexEvent_Transaksi()
    {
        // Ambil semua data EventTransaksi dengan memuat relasi eventanyar
    $event_transaksis = EventTransaksi::with('eventAnyar')->get();

    // Map data untuk memasukkan event_name ke dalam respon
    $event_transactions_with_name = $event_transaksis->map(function ($transaction) {
        return [
            'id' => $transaction->id,
            'event_id' => $transaction->event_id,
            'nama_event' => $transaction->eventAnyar->nama_event, // Ambil nama_event dari relasi EventAnyar
            'tempat_event' => $transaction->eventAnyar->tempat_event, // Ambil nama_event dari relasi EventAnyar
            'nominal' => $transaction->nominal,
            'tanggal' => $transaction->tanggal,
            'deskripsi' => $transaction->deskripsi,
            'metode_pembayaran' => $transaction->metode_pembayaran,
            'status' => $transaction->status,
            // Tambahkan atribut lain yang diperlukan
        ];
    });

    // Kembalikan respon dengan data yang sudah dimodifikasi
    return response()->json(['success' => true, 'data' => $event_transactions_with_name], 200);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function createEvent_Transaksi (Request $request)
    {
        $validatedData = $request->validate([
            'nominal' => 'required',
            'deskripsi' => 'required',
            'metode_pembayaran'=> 'required',
            'status' => 'required',
            'event_id'=> 'required',
        
        ]);
        $validatedData['tanggal'] = now();
        $event_anyar = EventTransaksi::create($validatedData);

        // Kembalikan respons JSON
        return response()->json(['success' => true, 'message' => 'transaksi berhasil disimpan', 'data' => $event_anyar], 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeEvent_Transaksi(Request $request)
    {
        $validatedData = $request->validate([
            'nominal' => 'required',
            'tanggal' => 'required',
            'deskripsi' => 'required',
            'metode_pembayaran'=> 'required',
            'status' => 'required',
            'event_id'=> 'required',
        ]);

        $event_anyar = EventTransaksi::create($validatedData);

        return response()->json(['success' => true, 'message' => 'transaksi berhasil disimpan', 'data' => $event_anyar], 201);
    }

    /**
     * Display the specified resource.
     */
    public function showEvent_Transaksi(string $event_id)
    {
        $event_anyar = EventTransaksi::where('event_id', $event_id)->get();
        return response()->json(['success'=> true, 'melihat data sukses' => $event_anyar], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editEvent_Transaksi(string $id)
    {
        $event_transaksi = EventTransaksi::findOrFail($id);
        return response()->json(['success'=> true, 'melihat data sukses' => $event_transaksi], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateEvent_Transaksi(Request $request, $id)
    {
            try {
                // Mencari transaksi event berdasarkan ID
                $eventTransaksi = EventTransaksi::findOrFail($id);
            
                // Validasi data dari request
                $validatedData = $request->validate([
                    'nominal' => 'required|numeric',
                    'deskripsi' => 'nullable|string',
                    'metode_pembayaran' => 'required|string',
                    'status' => 'required|string',
                    'event_id' => 'required|exists:event_anyar,id', // Pastikan nama tabel dan kolom benar
                ]);
                // Memperbarui data transaksi event
                $validatedData['tanggal'] = now();
                $eventTransaksi->update($validatedData);
            
                return response()->json([
                    'success' => true,
                    'message' => 'Transaksi event berhasil diperbarui',
                    'data' => $eventTransaksi
                ], 200);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Transaksi event tidak ditemukan',
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
                    'message' => 'Terjadi kesalahan saat memperbarui transaksi event',
                    'error' => $e->getMessage(),
                ], 500);
            }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function deleteEvent_Transaksi(string $id)
    {
        try {
            // Temukan transaksi event
            $event_transaksi = EventTransaksi::findOrFail($id);
    
            // Hapus transaksi event
            $result = $event_transaksi->delete();
    
            if ($result) {
                return response()->json(['success' => true, 'message' => 'Transaksi event berhasil dihapus'], 200);
            } else {
                return response()->json(['success' => false, 'error' => 'Gagal menghapus transaksi event'], 500);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['success' => false, 'error' => 'Transaksi event tidak ditemukan'], 404);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Gagal menghapus transaksi event', 'message' => $e->getMessage()], 500);
        }
    }
}
