<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;
    // protected $primaryKey = "id_pelanggan";
    protected $fillable = [
       'nama_pelanggan',
       'alamat_pelanggan',
       'telepon_pelanggan',
       'email_pelanggan',
    ];

        // // Fix the relationship method
        // public function pemesanans()
        // {
        //     return $this->hasMany(Pemesanan::class, 'id_pelanggan'); // Correct the foreign key to 'id_pelanggan'
        // }
    
}
