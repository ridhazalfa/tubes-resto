<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\transaksi_masuk;
use App\Models\transaksi_berlangsung;
use App\Models\transaksi_riwayat;

class transaksi_controller extends Controller
{
    public function show_masuk(){
        $masuk = transaksi_masuk::all();
        return view('Transaksi-masuk')->with('masuk', $masuk);
    }

    public function show_current(){
        $current = transaksi_berlangsung::all();
        return view('Transaksi-berlangsung')->with('current', $current);
    }

    public function show_riwayat(){
        $riwayat = transaksi_riwayat::all();
        return view('Transaksi-riwayat')->with('riwayat', $riwayat);
    }

    public function batal_masuk($id){
        $delete = transaksi_masuk::where('idReservasi', $id)->delete();
        return redirect()->route('show_masuk');
    }

    public function konfirmasi_masuk($id){
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
        return redirect()->route('show_masuk');
    }

    public function selesai($id){
        $move = transaksi_berlangsung::find($id);
        $simpan = transaksi_riwayat::create([
            'idReservasi' => $move->idReservasi,
            'idResto' => $move->idResto,
            'idCust' => $move->idCust,
            'date_reservasi' => $move->date_reservasi,
            'time_reservasi' => $move->time_reservasi,
            'no_table' => $move->no_table
        ])->save();
        $delete = transaksi_berlangsung::where('idReservasi', $id)->delete();
        return redirect()->route('show_current');
    }
}
