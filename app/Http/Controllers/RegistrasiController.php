<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\registrasi;
use App\Models\regis1;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class RegistrasiController extends Controller
{
    public function create()
    {
        return view('SignUp');
    }
     public function store(Request $req)
    {
        $this->validate($req, [
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        $user = new registrasi;
        $user-> username = $req -> username;
        $user-> email = $req -> email;
        $user-> password = $req -> password;
        $user -> save();
        
        return redirect()->to('/regis');
    }

    public function signin(Request $req)
    {
        $akun = registrasi::where('username', $req -> username)->first();
        if(!empty($akun))
        {
            if($akun ->password === $req ->password)
                {
                    return redirect('/dasboar1');
                }
            else
                {
                    return redirect('/signin')->with('message', 'Username atau Password salah');
                }

        }
        else
        {
            return redirect('/signin')->with('message', 'Akun belum terdaftar');
        }
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
        
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {
      
            $user = Socialite::driver('google')->user();
       
            $finduser = User::where('google_id', $user->id)->first();
       
            if($finduser){
       
                Auth::login($finduser);

     
                return redirect()->intended('dashboar');
       
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'password' => encrypt('123456dummy')
                ]);
      
                Auth::login($newUser);
      
                return redirect()->intended('dashboard');
            }
      
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

     public function handleFacebookCallback()
    {
        try {
        
            $user = Socialite::driver('facebook')->user();
         
            $finduser = User::where('facebook_id', $user->id)->first();
        
            if($finduser){
         
                Auth::login($finduser);
        
                return redirect()->intended('dashboard');
         
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'facebook_id'=> $user->id,
                    'password' => encrypt('123456dummy')
                ]);
        
                Auth::login($newUser);

                return redirect()->intended('dashboard');
            }
        
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

     public function showForgetPasswordForm()
      {
         return view('forgetPassword');
      }
       public function submitForgetPasswordForm(Request $req)
      {
        $akun = registrasi::where('username', $req -> username)->first();
        if(!empty($akun))
        {
            if($akun ->email === $req ->email)
                {

                    $akun = registrasi::where( 'username',$req -> username)->update(['password'=> ($req->password)]);   

                    return redirect('/signin')->with('message', 'Password berhasil di Ganti, silahkan SignIn Kembali !!');
                }
            else
                {
                    return redirect('/forgot-password')->with('message', 'Username atau email tidak sesuai');
                }

        }
        else
        {
            return redirect('/signin')->with('message', 'Akun belum terdaftar');
        }
      }


    public function regiss()
    {
        return view('Registrasi1');
    }
    public function saveregis1(Request $req)
    {
        $this->validate($req, [
            'picture' => 'required',
            'firstName' => 'required',
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'kategori' => 'required',
        ]);
        
        $gbr = $req->picture;
        $namafile = $gbr->getClientOriginalName();
        $user = new regis1;
        $user-> image = $namafile;
        $user-> nama = $req -> firstName;
        $user-> alamat = $req -> address;
        $user-> kota = $req -> country;
        $user-> kecamatan = $req -> state;
        $user-> kodepos = $req -> zip;
        $user-> kategori = $req -> kategori;
        $gbr->move(public_path().'/Image',$namafile);
        $user -> save();
        
        return redirect()->to('/regis-Menu');
    }


    public function tampilprofil()
    {
        $edit = regis1::find(1);
        return view('editProfile')-> with('profil', $edit);
    }

    public function updateprofilebaru(Request $req)
    {  
        $gbr = $req->picture;
        $namafile = $gbr->getClientOriginalName();
        $user = regis1::find(1);
        $user->update([
            'image'=> ( $namafile),
            'nama'=> ( $req -> firstName),
            'alamat'=> ($req -> address),
            'kota'=> ( $req -> country),
            'kecamatan'=> ( $req -> state),
            'kodepos'=> ( $req -> zip),
            'kategori'=> (  $req -> kategori)]);   
        $gbr->move(public_path().'/Image',$namafile);
        //$user -> save();
        
        return redirect()->to('/dasboar1');
    }  


}
