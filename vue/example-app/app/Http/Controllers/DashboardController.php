<?php

namespace App\Http\Controllers;

use App\Models\EventAnyar;
use App\Models\EventPengeluaran;
use App\Models\EventTransaksi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $eventAnyar = EventAnyar::all();
        $eventPengeluaran = EventPengeluaran::all();
        $eventTransaksi = EventTransaksi::all();

        return response()->json([
            'event_anyar' => $eventAnyar,
            'event_pengeluaran' => $eventPengeluaran,
            'event_transaksi' => $eventTransaksi
        ]);
    }

    public function getTotalSaldo()
    {
        // Mengambil semua pemasukan dan pengeluaran
        $pemasukan = EventTransaksi::sum('nominal');
        $pengeluaran = EventPengeluaran::sum('nominal');

        // Menghitung total saldo
        $totalSaldo = $pemasukan - $pengeluaran;

        return response()->json(['status' => 'sukses', 'total_saldo' => $totalSaldo]);
    }

    public function indexDua()
    {
        // Ambil data dari tabel event_transaksis
        $event_transaksis = EventTransaksi::with('eventAnyar')->get()->map(function ($transaksi) {
            $transaksi['jenis_transaksi'] = 'pemasukan';
            $transaksi['nama_event'] = $transaksi->eventAnyar->nama_event;
            return $transaksi;
        });
    
        // Ambil data dari tabel event_pengeluarans
        $event_pengeluarans = EventPengeluaran::with('eventAnyar')->get()->map(function ($pengeluaran) {
            $pengeluaran['jenis_transaksi'] = 'pengeluaran';
            $pengeluaran['nama_event'] = $pengeluaran->eventAnyar->nama_event;
            return $pengeluaran;
        });
    
        // Gabungkan data transaksi dan pengeluaran
        $combined_data = $event_transaksis->concat($event_pengeluarans);
    
        // Urutkan berdasarkan tanggal
        $sorted_data = $combined_data->sortByDesc('tanggal')->values();
    
        // Kembalikan respon dengan data yang sudah digabung
        return response()->json([
            'success' => true, 
            'data' => $sorted_data
        ], 200);
    }
public function getEventsForDashboard()
{
    // Ambil semua data event
    $events = EventAnyar::all();

    // Pisahkan event mendatang dan event selesai
    $currentDate = now();
    $upcomingEvents = [];
    $pastEvents = [];

    foreach ($events as $event) {
        $eventDate = new \DateTime($event->tanggal_event);
        if ($eventDate >= $currentDate) {
            $upcomingEvents[] = $event;
        } else {
            $pastEvents[] = $event;
        }
    }

    return response()->json([
        'success' => true,
        'upcoming_events' => $upcomingEvents,
        'past_events' => $pastEvents
    ], 200);
}
}