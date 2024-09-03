<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventAnyar extends Model
{
    protected $table = 'event_anyar';


    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'nama_event',
        'tempat_event',
        'tanggal_event',
    ];

    // Jika kamu tidak memerlukan timestamps, kamu bisa menonaktifkan ini
    public $timestamps = true;
    public function transactions(){
        return $this->hasMany(EventTransaksi::class, 'event_id');
    
    }
    public function pengeluaran()
    {
        return $this->hasMany(EventPengeluaran::class, 'event_id');
    }
}
