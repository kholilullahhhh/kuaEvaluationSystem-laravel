<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Agenda;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    private $menu = 'absensi';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menu = $this->menu;
        $datas = Absensi::with(['agenda', 'user'])->get();
        return view('pages.admin.absensi.index', compact('datas', 'menu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menu = $this->menu;
        $agendas = Agenda::where('status', 'publish')->get();
        $users = User::where('role', 'user')->get();
        return view('pages.admin.absensi.create', compact('users', 'agendas', 'menu'));
    }
    // public function store(Request $request)
    // {
    //     $r = $request->all();
    //     Absensi::create($r);
    //     return redirect()->route('absensi.index')->with('message', 'store');
    // }
    public function store(Request $request)
    {
        $r = $request->all();

        // Upload dokumentasi (gambar)
        if ($request->hasFile('dokumentasi')) {
            $foto = $request->file('dokumentasi');
            $ext = $foto->getClientOriginalExtension();

            $nameFoto = date('Y-m-d_H-i-s_') . "." . $ext;
            $destinationPath = public_path('upload/dokumentasi');
            $foto->move($destinationPath, $nameFoto);

            $r['dokumentasi'] = $nameFoto;
        }

        // Upload laporan (PDF)
        if ($request->hasFile('laporan')) {
            $laporan = $request->file('laporan');
            $ext = $laporan->getClientOriginalExtension();

            if ($ext != 'pdf') {
                return redirect()->back()->with('message', 'File laporan harus dalam format PDF');
            }

            $nameLaporan = date('Y-m-d_H-i-s_') . "." . $ext;
            $destinationPath = public_path('upload/laporan');
            $laporan->move($destinationPath, $nameLaporan);

            $r['laporan'] = $nameLaporan;
        }

        Absensi::create($r);

        return redirect()->route('absensi.index')->with('message', 'Data berhasil disimpan');
    }


    public function edit($id)
    {
        $data = Absensi::find($id);
        $menu = $this->menu;
        $agendas = Agenda::where('status', 'publish')->get();
        $users = User::where('role', 'user')->get();
        return view('pages.admin.absensi.edit', compact('data', 'agendas', 'users', 'menu'));
    }
    public function update(Request $request)
    {
        $r = $request->all();
        $data = Absensi::find($r['id']);

        // Update dokumentasi (gambar)
        if ($request->hasFile('dokumentasi')) {
            $foto = $request->file('dokumentasi');
            $ext = $foto->getClientOriginalExtension();

            $nameFoto = date('Y-m-d_H-i-s_') . "." . $ext;
            $destinationPath = public_path('upload/dokumentasi');

            // hapus file lama jika ada
            if ($data->dokumentasi && file_exists($destinationPath . '/' . $data->dokumentasi)) {
                unlink($destinationPath . '/' . $data->dokumentasi);
            }

            $foto->move($destinationPath, $nameFoto);
            $r['dokumentasi'] = $nameFoto;
        }

        // Update laporan (PDF)
        if ($request->hasFile('laporan')) {
            $laporan = $request->file('laporan');
            $ext = $laporan->getClientOriginalExtension();

            if ($ext != 'pdf') {
                return redirect()->back()->with('message', 'File laporan harus dalam format PDF');
            }

            $nameLaporan = date('Y-m-d_H-i-s_') . "." . $ext;
            $destinationPath = public_path('upload/laporan');

            // hapus file lama jika ada
            if ($data->laporan && file_exists($destinationPath . '/' . $data->laporan)) {
                unlink($destinationPath . '/' . $data->laporan);
            }

            $laporan->move($destinationPath, $nameLaporan);
            $r['laporan'] = $nameLaporan;
        }

        // Update data selain file
        $data->update($r);

        return redirect()->route('absensi.index')->with('message', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $data = Absensi::find($id);
        $data->delete();
        return response()->json($data);
    }


    // For User
    public function userIndex()
    {
        $user = Auth::user();
        $datas = Absensi::with('agenda')
            ->where('user_id', $user->id)
            ->get();

        return view('pages.user.absensi.index', compact('datas'));
    }

    public function userCreate()
    {
        $agendas = Agenda::where('status', 'publish')->get();
        return view('pages.user.absensi.create', compact('agendas'));
    }

    public function userStore(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'agenda_id' => 'required|exists:agendas,id',
            'kehadiran' => 'required|in:hadir,tidak_hadir,izin',
            'keterangan' => 'nullable|string'
        ]);

        $validated['user_id'] = $user->id;

        Absensi::create($validated);
        return redirect()->route('user.absensi.index')->with('success', 'Data absensi berhasil disimpan');
    }




}
