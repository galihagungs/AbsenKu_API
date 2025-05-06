<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absen;
use Illuminate\Support\Facades\Auth;

class AbsenController extends Controller
{
    public function AbsenMasuk(Request $request)
    {
        $user = Auth::user();
        if(Absen::where('user_id', '=', $user->id)->where('created_at', '>=', now()->startOfDay())->where('created_at', '<=', now()->endOfDay())->exists()){
            return response()->json([
                'message' => 'Anda sudah absen hari ini'
            ]);
        } else{
            $absenMasuk = Absen::create([
                'user_id' => $user->id,
                'check_in' => now(),
                'check_in_location' => "[{$request['check_in_lat']}, {$request['check_in_lng']}]",
                'check_in_address' => $request['check_in_address'],
                'status' => $request['status'],

            ]);
            return response()->json([
                'message' => 'Absen Masuk Berhasil',
                'data' => $absenMasuk
            ]);

        }

    }

    public function AbsenKeluar(Request $request)
    {
        $user = Auth::user();
        if(Absen::where('user_id', '=', $user->id)->where('created_at', '>=', now()->startOfDay())->where('created_at', '<=', now()->endOfDay())->exists()){
            $absenKeluar = Absen::where('user_id', '=', $user->id)->where('created_at', '>=', now()->startOfDay())->where('created_at', '<=', now()->endOfDay())->first();
            $absenKeluar->update([
                'check_out' => now(),
                'check_out_location' => "[{$request['check_out_lat']}, {$request['check_out_lng']}]",
                'check_out_address' => $request['check_out_address'],
                'status' => $request['status'],
            ]);
            return response()->json([
                'message' => 'Absen Keluar Berhasil',
                'data' => $absenKeluar
            ]);
        } else{
            return response()->json([
                'message' => 'Anda belum absen hari ini'
            ]);
        }
    }

    public function checkAbsen()
    {
        $user = Auth::user();
        $absen = Absen::where('user_id', '=', $user->id)->where('created_at', '>=', now()->startOfDay())->where('created_at', '<=', now()->endOfDay())->first();
        if($absen){
            return response()->json([
                'message' => 'Anda sudah absen hari ini',
                'status' => true
            ]);
        } else{
            return response()->json([
                'message' => 'Anda belum absen hari ini',
                'status' => false
            ]);
        }
    }
}
