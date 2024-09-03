<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventTransaksi extends Model
{
    use HasFactory;
    protected $fillable = [
        'nominal',
        'tanggal',
        'deskripsi',
        'metode_pembayaran',
        'status',
        'event_id',
    ];

    // Jika kamu tidak memerlukan timestamps, kamu bisa menonaktifkan ini
    public $timestamps = false;
    public function eventAnyar(){
        return $this->belongsTo(EventAnyar::class, 'event_id');
    }
}
