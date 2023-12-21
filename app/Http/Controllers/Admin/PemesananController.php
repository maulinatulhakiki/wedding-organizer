<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class PemesananController extends Controller
{
    // CRUDS TAMPIL
    // method untuk tampilkan data
    public function index()
    {
        $pemesanan1 = Pemesanan::latest()->when(request()->q, function ($query) {
            $query->where("tanggal_pemesanan", "like", "%" . request()->q . "%");
        })->paginate(10);

        return view("admin.pemesanan.index", compact("pemesanan1"));
    }

    // CRUDS INPUT
    // method untuk panggil form input data
    public function create()
    {
        $pelanggan1 = Pelanggan::all();
        return view('admin.pemesanan.create', compact('pelanggan1'));
    }

    // method untuk kirim data dari inputan form ke tabel siswa di database
    public function store(Request $request)
    {
        // validasi inputan
        $this->validate($request, [
            'id_pelanggan' => 'required|exists:pelanggans,id_pelanggan',
            'tanggal_pemesanan' => 'required',
            'tanggal_pernikahan' => 'required',
            'total_pemesanan' => 'required|min:3',
            'status_pemesanan' => 'required|min:3',
        ]);

        // kode untuk menyimpan data input di database
        $pemesanan = Pemesanan::create([
            'id_pelanggan' => $request->id_pelanggan,
            'tanggal_pemesanan' => $request->tanggal_pemesanan,
            'tanggal_pernikahan' => $request->tanggal_pernikahan,
            'total_pemesanan' => $request->total_pemesanan,
            'status_pemesanan' => $request->status_pemesanan,
        ]);

        // kondisi sekaligus redirect tampilkan pesan
        if ($pemesanan) {
            return redirect()->route('admin.pemesanan.index')->with(['success' => 'Data Berhasil Diubah Kedalam Tabel pemesanan']);
        } else {
            return redirect()->route('admin.pemesanan.index')->with(['error' => 'Data Tidak Berhasil Diubah Kedalam Tabel pemesanan']);
        }
    }

    // CRUDS UBAH
    // method untuk tampilkan data yang mau diubah
    public function edit(Pemesanan $pemesanan)
    {
        $pemesanan = Pemesanan::findOrFail($pemesanan->id_pemesanan);
        $pelanggan1 = Pelanggan::all();
        return view('admin.pemesanan.edit', compact('pemesanan', 'pelanggan1'));
    }

    // buat method untuk kirimkan data yang diubah di form inputan
    public function update(Request $request, Pemesanan $pemesanan)
    {
        // validasi inputan karena metode yang menyimpan data ke database
        $request->validate([
            'id_pelanggan' => 'required|exists:pelanggans,id_pelanggan',
            'tanggal_pemesanan' => 'required',
            'tanggal_pernikahan' => 'required',
            'total_pemesanan' => 'required|min:3',
            'status_pemesanan' => 'required|min:3',

        ]);

        $pemesanan = Pemesanan::findOrFail($pemesanan->id_pemesanan);

        // kode update database
        $pemesanan->update([
            'id_pelanggan' => $request->id_pelanggan,
            'tanggal_pemesanan' => $request->tanggal_pemesanan,
            'tanggal_pernikahan' => $request->tanggal_pernikahan,
            'total_pemesanan' => $request->total_pemesanan,
            'status_pemesanan' => $request->status_pemesanan,
        ]);

        // kondisi sekaligus redirect tampilkan pesan
        if ($pemesanan) {
            return redirect()->route('admin.pemesanan.index')->with(['success' => 'Data Berhasil Diubah Kedalam Tabel pemesanan']);
        } else {
            return redirect()->route('admin.pemesanan.index')->with(['error' => 'Data Tidak Berhasil Diubah Kedalam Tabel pemesanan']);
        }
    }

    // method untuk menghapus data
    public function destroy($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        // hapus dulu sebelumnya
        $pemesanan->delete();

        // kondisi berhasil atau tidak menghapus data
        if ($pemesanan) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error']);
        }
    }
}
