<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use DateTime;
use Illuminate\Http\Request;

class JadwalController extends Controller
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
        $jadwals = Jadwal::with(['film', 'studio'])->get(['id_jadwal', 'id_film', 'id_studio', 'tanggal', 'jam']);
        $jadwalList = [];
        foreach($jadwals as $jadwal){
                $jadwalList[] = [
                    'id_jadwal' => $jadwal->id_jadwal,
                    'judul' => $jadwal->film->judul,
                    'tanggal' => $jadwal->tanggal,
                    'jam' => $jadwal->jam,
                    'id_studio' => $jadwal->id_studio,
                    'kelas' => $jadwal->studio->kelas->nama_kelas,
                    'harga' => $jadwal->studio->kelas->harga
                ];
        }
        return response()->json([
            'status' => 'Berhasil',
            'pesan' => 'Seluruh jadwal film ditampilkan.',
            'data' => $jadwalList
        ], 200);
    }

    public function getSearch($title){
        $jadwals = Jadwal::with(['film', 'studio'])->get(['id_jadwal', 'id_film', 'id_studio', 'tanggal', 'jam']);
        $jadwalList = [];
        foreach($jadwals as $jadwal){
            if(str_contains($jadwal->film->judul, $title)){
                $jadwalList[] = [
                    'id_jadwal' => $jadwal->id_jadwal,
                    'judul' => $jadwal->film->judul,
                    'tanggal' => $jadwal->tanggal,
                    'jam' => $jadwal->jam,
                    'id_studio' => $jadwal->id_studio,
                    'kelas' => $jadwal->studio->kelas->nama_kelas,
                    'harga' => $jadwal->studio->kelas->harga
                ];
            }
        }
        return response()->json([
            'status' => true,
            'pesan' => "Jadwal film $title ditampilkan.",
            'data' => $jadwalList
        ], 200);
    }

    public function add(Request $request){
        for ($x = new DateTime($request->tanggal_awal); $x <= new DateTime($request->tanggal_akhir); $x->modify('+1 day')) {
            $jadwal = Jadwal::create([
                'id_film' => $request->id_film,
                'id_studio' => $request->id_studio,
                'tanggal' => $x->format("Y-m-d"),
                'jam' => $request->jam
            ]);
        }
        return response()->json([
            'status' => 'Berhasil',
            'pesan' => 'Jadwal berhasil ditambahkan'
        ], 200);
    }

    public function getByFilm($id){
        $jadwals = Jadwal::where('id_film', 'like', $id)->with(['studio', 'film'])->get(['id_jadwal', 'id_film', 'id_studio', 'tanggal', 'jam']);
        $jadwalList = [];
        foreach($jadwals as $jadwal){
                $jadwalList[] = [
                    'id_jadwal' => $jadwal->id_jadwal,
                    'judul' => $jadwal->film->judul,
                    'tanggal' => $jadwal->tanggal,
                    'jam' => $jadwal->jam,
                    'studio' => $jadwal->id_studio,
                    'kelas' => $jadwal->studio->kelas->nama_kelas,
                    'harga' => $jadwal->studio->kelas->harga
                ];
        }
        return response()->json([
            'status' => 'Berhasil',
            'pesan' => "Seluruh jadwal film ditampilkan.",
            'data' => $jadwalList
        ], 200);
    }
    public function getDetail($id){
        $jadwal = Jadwal::where('id_jadwal', 'like',$id)->with(['studio', 'film'])->first(['id_jadwal', 'id_film', 'id_studio', 'tanggal', 'jam']);
        return response()->json([
            'status' => 'Berhasil',
            'pesan' => 'Detail jadwal ditampilkan.',
            'data' => [
                'id_jadwal' => $jadwal->id_jadwal,
                'judul' => $jadwal->film->judul,
                'tanggal' => $jadwal->tanggal,
                'jam' => $jadwal->jam,
                'studio' => $jadwal->id_studio,
                'kelas' => $jadwal->studio->kelas->nama_kelas,
                'harga' => $jadwal->studio->kelas->harga
            ]
        ], 200);
    }

    public function delete($id){
        $jadwal = Jadwal::destroy($id);
        return response()->json([
            'status' => 'Berhasil',
            'pesan' => 'Jadwal telah dihapus.'
        ], 200);
    }
}
