<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Jadwal;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransactionController extends Controller
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

    public function createTransaction(Request $request){
        $id_kodeBayar = Str::random(8);
        $detail = Jadwal::where('id_jadwal', $request->id_jadwal)->with(['film', 'studio'])->first();
        $pelanggan = Pelanggan::findorfail($request->id_pelanggan);
        $transaction = Transaction::create([
            'kode_booking' => $id_kodeBayar,
            'id_pelanggan' => $request->id_pelanggan,
            'judul_film' => $detail->film->judul,
            'studio' => $detail->studio->id_studio,
            'kelas' => $detail->studio->kelas->nama_kelas,
            'tanggal'=> $detail->tanggal,
            'jam'=> $detail->jam,
            'harga_tiket' => $detail->studio->kelas->harga,
            'jumlah_tiket' => $request->jumlah_tiket,
            'total_harga' => $request->jumlah_tiket * $detail->studio->kelas->harga
        ]);
        $bill = Transaction::find($transaction->kode_booking);
        return response()->json([
            'status'=>'success',
            'message'=>'Reservation has been added.',
            'data'=> $bill
        ]);
    }
    public function getAll(){
        $bills = Transaction::with('pelanggan')->get();
        $transactionList = [];
        foreach($bills as $bill){
            $transactionList[] = [
            'kode_booking' => $bill->kode_booking,
            'nama_pelanggan' => $bill->pelanggan->nama,
            'judul_film' => $bill->judul_film,
            'studio' => $bill->studio,
            'kelas' => $bill->kelas,
            'tanggal'=> $bill->tanggal,
            'jam'=> $bill->jam,
            'harga_tiket' => $bill->harga_tiket,
            'jumlah_tiket' => $bill->jumlah_tiket,
            'total_harga' => $bill->total_harga,
            'created_at' => $bill->created_at
            ];
        }
        return response()->json([
            'status'=>'success',
            'message'=>'Reservation has been added.',
            'data'=> $transactionList
        ]);
    }

    public function getHistory($id){
        $bills = Transaction::where('id_pelanggan', 'like', $id)->with("pelanggan")->get();
        $transactionList = [];
        foreach($bills as $bill){
            $transactionList[] = [
            'kode_booking' => $bill->kode_booking,
            'nama_pelanggan' => $bill->pelanggan->nama,
            'judul_film' => $bill->judul_film,
            'studio' => $bill->studio,
            'kelas' => $bill->kelas,
            'tanggal'=> $bill->tanggal,
            'jam'=> $bill->jam,
            'harga_tiket' => $bill->harga_tiket,
            'jumlah_tiket' => $bill->jumlah_tiket,
            'total_harga' => $bill->total_harga  
            ];
        }
        return response()->json([
            'status'=>true,
            'message'=>'Riwayat pemesanan ditampikan.',
            'data'=> $transactionList
        ]);
    }
}
