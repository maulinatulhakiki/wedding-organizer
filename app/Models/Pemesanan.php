<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;
    // protected $primaryKey = "id_pemesanan";
    protected $fillable = [
        'id_pelanggan',
        'tanggal_pemesanan',
        'tanggal_pernikahan',
        'total_biaya',
        'status_pemesanan',

    ];

        // // Fix the relationship method
        // public function pelanggan()
        // {
        //     return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
        // }

}
