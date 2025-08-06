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

        $validated = $request->validate([
            'agenda_id' => 'required|exists:agendas,id',
            'status' => 'required|in:hadir,tidak hadir,izin,sakit,terlambat',
            'keterangan' => 'nullable|string'
        ]);

        $validated['user_id'] = $user->id;

        Absensi::create($validated);
        return redirect()->route('user.absensi.index')->with('success', 'Data absensi berhasil disimpan');
    }
}