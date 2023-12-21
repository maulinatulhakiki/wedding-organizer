<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    // CRUDS TAMPIL
    // method untuk tampilkan data
    public function index()
    {
        $pembayaran1 = Pembayaran::latest()->when(request()->q, function ($query) {
            $query->where("nama_pembayaran", "like", "%" . request()->q . "%");
        })->paginate(10);

        return view("admin.pembayaran.index", compact("pembayaran1"));
    }

    // CRUDS INPUT
    // method untuk panggil form input data
    public function create()
    {
        $pemesanan1 = Pemesanan::all();
        return view('admin.pembayaran.create', compact('pemesanan1'));
    }

    // method untuk kirim data dari inputan form ke tabel siswa di database
    public function store(Request $request)
    {
        // validasi inputan
        $this->validate($request, [
            'id_pemesanan' => 'required|exists:pemesanans,id_pemesanan',
            'metode_pembayaran' => 'required|min:3',
            'tanggal_pembayaran' => 'required',
            'jumlah_pembayaran' => 'required',

        ]);

        // kode untuk menyimpan data input di database
        $pembayaran = Pembayaran::create([
            'id_pemesanan' => $request->id_pemesanan,
            'metode_pembayaran' => $request->metode_pembayaran,
            'tanggal_pembayaran' => $request->tanggal_pembayaran,
            'jumlah_pembayaran' => $request->jumlah_pembayaran,
        ]);

        // kondisi sekaligus redirect tampilkan pesan
        if ($pembayaran) {
            return redirect()->route('admin.pembayaran.index')->with(['success' => 'Data Berhasil Diubah Kedalam Tabel pembayaran']);
        } else {
            return redirect()->route('admin.pembayaran.index')->with(['error' => 'Data Tidak Berhasil Diubah Kedalam Tabel pembayaran']);
        }
    }

    // CRUDS UBAH
    // method untuk tampilkan data yang mau diubah
    public function edit(Pembayaran $pembayaran)
    {
        $pembayaran = Pembayaran::findOrFail($pembayaran->id_pembayaran);
        $pemesanan1 = Pemesanan::all();
        return view('admin.pembayaran.edit', compact('pembayaran', 'pemesanan1'));
    }

    // buat method untuk kirimkan data yang diubah di form inputan
    public function update(Request $request, Pembayaran $pembayaran)
    {
        // validasi inputan karena metode yang menyimpan data ke database
        $request->validate([
            'id_pemesanan' => 'required|exists:pemesanans,id_pemesanan',
            'metode_pembayaran' => 'required|min:3',
            'tanggal_pembayaran' => 'required',
            'jumlah_pembayaran' => 'required',
        ]);

        $pembayaran = Pembayaran::findOrFail($pembayaran->id_pembayaran);

        // kode update database
        $pembayaran->update([
            'id_pemesanan' => $request->id_pemesanan,
            'metode_pembayaran' => $request->metode_pembayaran,
            'tanggal_pembayaran' => $request->tanggal_pembayaran,
            'jumlah_pembayaran' => $request->jumlah_pembayaran,
        ]);

        // kondisi sekaligus redirect tampilkan pesan
        if ($pembayaran) {
            return redirect()->route('admin.pembayaran.index')->with(['success' => 'Data Berhasil Diubah Kedalam Tabel pembayaran']);
        } else {
            return redirect()->route('admin.pembayaran.index')->with(['error' => 'Data Tidak Berhasil Diubah Kedalam Tabel pembayaran']);
        }
    }

    // method untuk menghapus data
    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        // hapus dulu sebelumnya
        $pembayaran->delete();

        // kondisi berhasil atau tidak menghapus data
        if ($pembayaran) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error']);
        }
    }
}
