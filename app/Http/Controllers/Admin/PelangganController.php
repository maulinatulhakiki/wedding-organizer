<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class PelangganController extends Controller
{
   // method untuk tampilkan data pelanggan
    public function index(){
        $pelanggans = Pelanggan::latest()->when(request()->q, function($pelanggans){
            $pelanggans = $pelanggans-> where ("nama_pelanggan", "like", "%". request()->q ."%");

        })->paginate(10);
        return view("admin.pelanggan.index", compact("pelanggans"));
    }

    // method untuk panggil form input data
    public function create(){
        return view('admin.pelanggan.create');
    }

    //method untuk kirim data dari inputan form ke tabel pelanggan di database
    public function store(Request $request){
        // validasi inputan
        $this->validate($request, [
        'nama_pelanggan' => 'required', 
        'alamat_pelanggan' => 'required',
        'telepon_pelanggan' => 'required',
        'email_pelanggan' => 'required',
        
        ]);

        //kode untuk menyimpan data input di database
 	  $pelanggan = Pelanggan::create([
        'nama_pelanggan' => $request->nama_pelanggan, 
        'alamat_pelanggan' => $request->alamat_pelanggan, 
        'telepon_pelanggan' => $request->telepon_pelanggan, 
        'email_pelanggan' => $request->email_pelanggan, 
     ]);

        //kondisi sekaligus redirect tampilkan pesan
        if($pelanggan){
            return redirect()->route('admin.pelanggan.index')->with(['success'=>'Data Berhasil Disimpan Kedalam Tabel Pelanggan']);
        }else{
            return redirect()->route('admin.pelanggan.index')->with(['error'=>'Data Tidak Berhasil Disimpan Kedalam Tabel Pelanggan']);
        }


    }

    // method untuk tampilkan data yang mau diubah
    public function edit(Pelanggan $pelanggan){
        return view('admin.pelanggan.edit', compact('pelanggan'));
    }

    // buat method untuk kirimkan data yang diubah di form inputan
    public function update(Request $request, Pelanggan $pelanggan){
        //validasi inputan karena methode yang menyimpan data ke database
        $this->validate($request, [
            'nama_pelanggan' => 'required', 
            'alamat_pelanggan' => 'required', 
            'telepon_pelanggan' => 'required', 
            'email_pelanggan' => 'required', 

        ]);

    //update data di tabel kategori dengan tabel baru
    $pelanggan= Pelanggan::findOrFail($pelanggan->id);
    $pelanggan->update([
        'nama_pelanggan' => $request->nama_pelanggan, 
        'alamat_pelanggan' => $request->alamat_pelanggan, 
        'telepon_pelanggan' => $request->telepon_pelanggan, 
        'email_pelanggan' => $request->email_pelanggan, 
        
    ]);

    //kondisi sekaligus redirect tampilkan pesan
    if($pelanggan){
        return redirect()->route('admin.pelanggan.index')->with(['success'=>'Data Berhasil Diubah Kedalam Tabel Pelanggan']);
    }else{
        return redirect()->route('admin.pelanggan.index')->with(['error'=>'Data Tidak Berhasil Diubah Kedalam Tabel Pelanggan']);
    }
    }


     // method untuk menghapus data
     public function destroy($id){
        $pelanggan = Pelanggan::findOrFail($id);
        
        $pelanggan->delete();

        // kondisi berhasil atau tidak menghapus data
        if($pelanggan){
            return response()->json(['status'=> 'success']);
        }else{
            return response()->json(['status'=> 'error']);
        }
    }

    // methode untuk tampilkan view data secara detail
    public function show(string $id): View
    {
    $pelanggan = Pelanggan::findOrFail($id);
    return view('admin.pelanggan.show', compact('pelanggan'));
    }
  }


