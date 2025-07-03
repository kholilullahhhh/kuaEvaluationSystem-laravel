<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login()
    {
        return view('pages.auth.login', ['menu' => 'login']);
    }

    public function login_action(Request $request)
    {
        if ($request->role == null && $request->username == 'admin') {
            $request->role = 'admin';
        }

        if ($request->role == null) {
            return redirect()->back()->with('message', 'gagal login');
        }
        // dump($request->all());
        // dump(Auth::attempt(['username' => $request->username, 'password' => $request->password, 'role' => $request->role]));
        // dump(Admin::where('username', $request->username)->where('role', $request->role)->first());

        $user = Admin::where('username', $request->username)->where('role', $request->role)->first();
        $user1 = User::where('username', $request->username)->where('role', $request->role)->first();

        // dump($user);
        // dump($user1);
        // dump(Auth::attempt(['username' => $user->username, 'password' => $user->password, 'role' => $user->role]));

        $cek = Auth::attempt(['username' => $request->username, 'password' => $request->password, 'role' => $request->role]);
        // $cek = Auth::attempt(['username' => $user->username, 'password' => $user->password, 'role' => $user->role]);
        // dd($cek);
        if ($cek) {
            // dd($user);
            Session::put('user_id', $user->id);
            Session::put('name', $user->name);
            Session::put('username', $user->username);
            Session::put('role', $user->role);
            Session::put('cek', true);

            if ($user->role == 'admin')
                return redirect()->route('dashboard')->with('message', 'sukses login');
            return redirect()->route('dashboard')->with('message', 'sukses login');

        } else {
            return redirect()->back()->with('message', 'gagal login');
        }
    }

}
