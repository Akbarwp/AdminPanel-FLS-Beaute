<?php

namespace App\Http\Controllers;

use App\Models\CashOpname;
use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// use Auth;
// use Session;
// use App\User;
use App\Models\UserPabrik;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\UserHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AuthManageController extends Controller
{
    public function viewLogin()
    {
        return view('login');
    }

    public function verifyLogin(Request $request)
    {
        $currentDate = Carbon::now()->toDateString();

        if (Auth::attempt($request->only('username', 'password'))) {
            // dd(auth()->user()->user_position != 'prospek_distributor');
            if (auth()->user()->user_position == 'prospek_distributor') {
                // dd("b");
                $this->logoutProcess();
            } else {

                // Buka Kasir Login
                // if (auth()->user()->user_position == 'cashier_pabrik') {
                //     $cek_buka = CashOpname::where('user_id', auth()->user()->id)->whereDate('created_at', $currentDate)->first();
                //     if ($cek_buka) {
                //         $newActivity['id_user'] = auth()->user()->id;
                //         $newActivity['id_group'] = auth()->user()->id_group;
                //         $newActivity['kegiatan'] = "Log In";

                //         UserHistory::create($newActivity);

                //         return redirect('/dashboard');
                //     }

                //     Auth::logout();
                //     request()->session()->invalidate();
                //     request()->session()->regenerateToken();
                //     return back()->with('login_failed', 'Maaf akun anda belum dibuka');
                // }


                $newActivity['id_user'] = auth()->user()->id;
                $newActivity['id_group'] = auth()->user()->id_group;
                $newActivity['kegiatan'] = "Log In";

                UserHistory::create($newActivity);

                return redirect('/dashboard');
            }
        }


        Session::flash('login_failed', 'Username atau password salah');

        return redirect('/login');


        // $credentials = $request->validate([
        //     'username' => 'required',
        //     'password' => 'required'
        // ]);

        // if(Auth::attempt($credentials)) {
        //     $request->session()->regenerate();
        //     return redirect()->intended('/dashboard');
        // }

        // return back()->with('loginError', 'Login failed');
        // return back();


        // pake type
        // $temp = User::where('user_type', $request->user_type)->where('username', $request->username)->first();

        // if($temp === null)
        // {
        //     return redirect('/login');
        // }
        // else{
        //     if(Hash::check($request->password, $temp->password, []))
        //     {
        //         Auth::loginUsingId($temp->id);
        //         return redirect('/dashboard');
        //     }
        // }

        // return Hash::check($suppliedPassword, Auth::user()->password, []);


        // if(Auth::attempt($request->only('username', 'password'))){

        //     $temp = User::firstWhere('username', request('username'));
        //     if($temp->user_type == $request->user_type){
        //         return redirect('/dashboard');
        //     }
        //     return redirect('/login');
        // }

        // return back()->with('loginError', 'Login Failed!');
        // return redirect('/login');

    }

    public function logoutProcess()
    {
        $newActivity['id_user'] = auth()->user()->id;
        $newActivity['id_group'] = auth()->user()->id_group;
        $newActivity['kegiatan'] = "Log Out";

        UserHistory::create($newActivity);
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }
}
