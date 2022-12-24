<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getAll(){
        $pelanggan = Pelanggan::All('id_pelanggan', 'nama', 'email');
        return response()->json([
            'status' => true,
            'pesan' => 'Seluruh data pelanggan ditampilkan.',
            'data' => $pelanggan
        ], 200);
    }
    public function getSearch($nama){
        $pelanggans = Pelanggan::all();
        $akun = [];
        foreach($pelanggans as $pelanggan){
            if(str_contains($pelanggan->nama, $nama)){
                $akun[] = $pelanggan;
            }
        }
        return response()->json([
            'status' => true,
            'pesan' => "Seluruh pelanggan dengan nama $nama ditampilkan.",
            'data' => $akun
        ], 200);
    }

    public function getProfil($id) {
        $profil = Pelanggan::find($id);
        return response()->json([
            'status' => true,
            'pesan' => 'Profil pengguna ditampilkan.',
            'data' => $profil
        ], 200);
    }

    public function update(){

    }

    public function delete(Request $request) {
        $pelanggan = Pelanggan::findorfail($request->id);
        $pelanggan->delete();
        //$pelanggan = Pelanggan::All('id_pelanggan', 'nama', 'email');
        return response()->json([
            'status' => 'Berhasil',
            'pesan' => 'Pelanggan telah dihapus.'
        //    'data' => $pelanggan
        ], 200);
    }
}
