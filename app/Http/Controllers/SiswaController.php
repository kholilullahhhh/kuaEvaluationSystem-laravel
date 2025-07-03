<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Classes;
use App\Models\User;
use App\Models\Admin;
use App\Models\Guru;

class SiswaController extends Controller
{
    private $menu = 'siswa';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = User::where('role', 'siswa')->with(['class', 'spp'])->latest()->get();
        $menu = $this->menu;
        return view('pages.admin.siswa.index', compact('menu', 'datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menu = $this->menu;
        $kelas = Classes::all();
        $user = User::where('role', 'siswa')->get();
        return view('pages.admin.siswa.create', compact('menu', 'kelas', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     */

    // public function store(Request $request)
    // {
    //     $r = $request->all();
    //     // dd($r);
    //     // Menyimpan data guru
    //     // dd($r);
    //     User::create($r);
    //     return redirect()->route('siswa.index')->with('message', 'Data guru berhasil ditambahkan.');
    // }

    public function store(Request $r)
    {
        $cek_username = Admin::where('username', $r->username)->where('role', $r->role)->first();
        if ($cek_username == null) {
            // dd($r);
            $r = $r->all();
            $r['password'] = bcrypt($r['password']);
            Admin::create($r);
            User::create($r);

            return redirect()->route('siswa.index')->with('message', 'store');
        } else {
            return redirect()->route('siswa.index')->with('message', 'username sudah ada');
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = User::findOrFail($id);
        $kelas = Classes::all();
        $menu = $this->menu;

        return view('pages.admin.siswa.edit', compact('data', 'kelas', 'menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $r = $request->all();
        $data = User::find($r['id']);

        // dd($r);
        $data->update($r);

        return redirect()->route('siswa.index')->with('message', 'Data guru berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $admin = Admin::findOrFail($id);

            $user->delete();
            $admin->delete();

            return redirect()->route('siswa.index')
                ->with('message', 'Data siswa dan admin berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->route('siswa.index')
                ->with('error', 'Gagal menghapus data siswa dan admin: ' . $e->getMessage());
        }
    }

}
