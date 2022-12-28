<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registrasi3;
use Illuminate\Database\QueryException;
 
class Registrasi3Controller extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('Registrasi3');
    }

    public function tampil()
    {
        $simpan = Registrasi3::select('*')->get();
        return view('Registrasi3-2', ['simpan' => $simpan]);
    }

    public function hapus($id)
    {
        $simpan = Registrasi3::where('id', $id)->delete();
        return redirect()->route('tampil');
    }

    public function simpan(Request $request)
    {
         $simpan = Registrasi3::create([
            'lokasi_meja' => $request->lokasi_meja,
            'jenis_meja' => $request->jenis_meja,
            'jumlah_meja' => $request->jumlah_meja,
         ]);
         $simpan -> save();
         return redirect()->route('tampil');
    }

    public function show_meja(Request $request)
    {
         $simpan = Registrasi3::all();
         return view('DasboardMeja')->with('simpan', $simpan);
    }

    public function simpan_db(Request $request)
    {
         $simpan = Registrasi3::create([
            'lokasi_meja' => $request->lokasi_meja,
            'jenis_meja' => $request->jenis_meja,
            'jumlah_meja' => $request->jumlah_meja,
         ]);
         $simpan -> save();
         return redirect('/dasboar3');
    }

    public function hapusMeja($id)
    {
        $simpan = Registrasi3::where('id', $id)->delete();
        return redirect('/dasboar3');
    }
}