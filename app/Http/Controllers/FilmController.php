<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;

class FilmController extends Controller
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

    public function getAll() {
        $film = Film::all();
        return response()->json([
            'status' => true,
            'pesan' => 'Seluruh data film ditampilkan.',
            'data' => $film
        ], 200);
    }

    public function getSearch($title) {    
        $films = Film::all();
        $movie = [];
        foreach($films as $film){
            if(str_contains($film->judul, $title)){
                $movie[] = $film;
            }
        }
        return response()->json([
            'status' => true,
            'pesan' => "Film dengan judul $title ditampilkan.",
            'data' => $movie
        ], 200);
    }

    public function getDetailFilm(Request $request) {
        $detailFilm = Film::findorfail($request->id);
        return response()->json([
            'status' => true,
            'pesan' => "Detail Film $detailFilm->judul ditampilkan.",
            'detail' => $detailFilm
        ], 200);
    }

    public function addFilm(Request $request){
        $film = Film::create([
            'judul' => $request->judul,
            'rating' => $request->rating,
            'storyline' => $request->storyline,
            'poster' => $request->poster,
            'banner' => $request->banner
        ]);
        return response()->json([
            'status' => true,
            'pesan' => "Film $film->judul berhasil ditambahkan.",
            'data' => $film
        ], 200);
    }
    
    public function updateFilm(Request $request, $id){
        $detailFilm = Film::findorfail($id);

        if($request->judul != null){
            $detailFilm->update(['judul' => $request->judul]);
        }
        if($request->rating != null){
            $detailFilm->update(['rating' => $request->rating]);
        }
        if($request->storyline != null){
            $detailFilm->update(['storyline' => $request->storyline]);
        }
        if($request->poster != null){
            $detailFilm->update(['poster' => $request->poster]);
        }
        if($request->banner != null){
            $detailFilm->update(['banner' => $request->banner]);
        }
        return response()->json([
            'status' => true,
            'pesan' => 'Detail film berhasil diperbarui.',
            'detail' => $detailFilm
        ], 200);
    }

    public function deleteFilm($id){
        $film = Film::destroy($id);
        return response()->json([
            'status' => 'true',
            'pesan' => 'Film berhasil di hapus.',
        ], 200);
    }   
}
