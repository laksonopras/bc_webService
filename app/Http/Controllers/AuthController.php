<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        //
        $this->request = $request;
    }

    protected function jwt(Pelanggan $pelanggan){
        $payload = [
            'iss' => 'lumen-jwt', //issuer of the token
            'sub' => $pelanggan->id, //subject of the token
            'iat' => time(), //time when JWT was issued.
            'exp' => time() + 60 //time when JWT will expire
          ];
          return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }

    public function daftar(Request $Request){
        
        $pelanggan = Pelanggan::create([
            'nama' => $Request->nama,
            'email' => $Request->email,
            'password' => Hash::make($Request->password)
        ]);
        return response()->json([
            'status' => true,
            'pesan' => "$pelanggan->nama berhasil mendaftar",
        ], 200);
    }

    public function masuk(Request $request){
        $pelanggan = Pelanggan::where('email', $request->email)->first();
        if(!$pelanggan){
            return response()->json([
                'status' => false,
                'pesan' => 'Email tidak ditemukan'
            ], 400);
        }

        if(!Hash::check($request->password, $pelanggan->password)){
            return response()->json([
                'status' => false,
                'pesan' => 'Password salah' 
            ], 400);
        }

        $pelanggan->token = $this->jwt($pelanggan);
        $pelanggan->save();

        return response()->json([
            'status' => true,
            'pesan' => 'Berhasil masuk',
            'auth' => $pelanggan->id_pelanggan
            // 'data' => [
            //     'id_pelanggan' => $pelanggan->id_pelanggan,
            //     'nama' => $pelanggan->nama,
            //     'email' => $pelanggan->email,
            //     'token' => $pelanggan->token
            // ]
        ], 200);
    }
}
