<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
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

    public function add(Request $request){
        $kelas = Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'harga' => $request->harga
        ]);
        return response()->json([
            'status' => 'Berhasil',
            'pesan' => 'Kelas telah di tambahkan'
        ], 200);
    }

    public function getAll(){
        $kelas = Kelas::all('id_kelas', 'nama_kelas', 'harga');
        return response()->json([
            'status' => 'Berhasil',
            'pesan' => 'Semua kelas berhasil ditampilkan.',
            'kelas' => $kelas
        ], 200);
    }

    /**
     * nama = select * 
     * kelas = 1
     * 
     */

    public function update(Request $request){
        $kelas = Kelas::find($request->id);
        $kelas -> update($request->all());
        return response()->json([
            'status' => 'Berhasil',
            'pesan' => 'Semua kelas berhasil ditampilkan.',
            'kelas' => $kelas
        ], 200);
    }
}
