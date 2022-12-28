<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\transaksi_masuk;
use App\Models\transaksi_berlangsung;
use App\Models\Registrasi3;

class dashboard_controller extends Controller
{
    public function show_dashboard(){
        $dasboar = transaksi_masuk::all();
        $meja = Registrasi3::all();
        $meja_tersedia = $meja->count();
        $meja_reservasi = transaksi_berlangsung::all()->count();
        return view('Dasboard')->with('dasboar', $dasboar)->with('meja_tersedia', $meja_tersedia)->with('meja_reservasi', $meja_reservasi);
    }

    public function konfirmasi_masuk_dash($id){
        $move = transaksi_masuk::find($id);
        $simpan = transaksi_berlangsung::create([
            'idReservasi' => $move->idReservasi,
            'idResto' => $move->idResto,
            'idCust' => $move->idCust,
            'date_reservasi' => $move->date_reservasi,
            'time_reservasi' => $move->time_reservasi,
            'no_table' => $move->no_table
        ])->save();
        $delete = transaksi_masuk::where('idReservasi', $id)->delete();
        return redirect()->route('show_dashboard');
    }

    public function batal_masuk_dash($id){
        $delete = transaksi_masuk::where('idReservasi', $id)->delete();
        return redirect()->route('show_dashboard');
    }
}
