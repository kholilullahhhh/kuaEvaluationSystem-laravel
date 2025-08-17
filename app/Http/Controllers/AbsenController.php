<?php

namespace App\Http\Controllers;
use App\Models\Agenda;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class AbsenController extends Controller
{
    private $menu = 'absensi';
    public function userIndex()
    {
        // $datas = Absensi::with('agenda')->get();
        $datas = Absensi::whereHas('user', function ($query) {
            $query->where('nip', auth()->user()->nip);
        })->with(['user', 'agenda'])->latest()->get();
        $menu = $this->menu;

        return view('pages.user.absen.index', compact('menu', 'datas'));
    }
    public function userCreate()
    {
        $menu = $this->menu;
        $agendas = Agenda::where('status', 'publish')->get();
        return view('pages.user.absen.create', compact('agendas', 'menu'));
    }
    public function userStore(Request $request)
    {
        $user = Auth::user();

        $r = $request->all();
        $r['user_id'] = $user->id;

        // dd($r);
        $file = $request->file('dokumentasi');

        // dd($file->getSize() / 1024);
        // if ($file->getSize() / 1024 >= 512) {
        //     return redirect()->route('modul.create')->with('message', 'size gambar');
        // }

        $foto = $request->file('dokumentasi');
        $ext = $foto->getClientOriginalExtension();
        // $r['pas_foto'] = $request->file('pas_foto');

        $nameFoto = date('Y-m-d_H-i-s_') . "." . $ext;
        $destinationPath = public_path('upload/dokumentasi');

        $foto->move($destinationPath, $nameFoto);

        $fileUrl = asset('upload/dokumentasi/' . $nameFoto);
        // dd($destinationPath);
        $r['dokumentasi'] = $nameFoto;
        // dd($r);
        Absensi::create($r);
        return redirect()->route('user.absensi.index')->with('success', 'Data absensi berhasil disimpan');
    }
}