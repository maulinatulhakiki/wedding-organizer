<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    // protected $primaryKey = "id_pembayaran";
    protected $fillable = [
        'id_pemesanan',
        'metode_pembayaran',
        'tanggal_pembayaran',
        'jumlah_pembayaran',
    ];

        // Fix the relationship method
        // public function pemesanan()
        // {
        //     return $this->belongsTo(Pemesanan::class, 'id_pemesanan');
        // }
}
