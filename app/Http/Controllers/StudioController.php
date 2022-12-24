<?php

namespace App\Http\Controllers;

use App\Models\Studio;
use Illuminate\Http\Request;

class StudioController extends Controller
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
        $studio = Studio::create([
            'id_kelas' => $request->id_kelas
        ]);

        return response()->json([
            'status' => 'Berhasil',
            'pesan' => 'Studio berhasil ditambahkan'
        ], 200);
    }

    public function getAll(){
        $studios = Studio::with('kelas')->get(['id_studio', 'id_kelas']);
        $studioList = [];
        foreach($studios as $studio){
            $studioList[] = [
                'id_studio' => $studio->id_studio,
                'kelas' => $studio->kelas->nama_kelas,
                'harga' => $studio->kelas->harga
            ];
        }
        return response()->json([
            'status' => 'Berhasil',
            'pesan' => 'Menampilkan semua studio',
            'studio' => $studioList
        ], 200);
    }
}
