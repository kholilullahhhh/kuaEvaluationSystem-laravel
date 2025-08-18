<?php

namespace App\Http\Controllers;

use App\Models\Indicators;
use Illuminate\Http\Request;
use App\Models\performance_scores;
use App\Models\user;
use App\Models\Agenda;
use App\Models\Absensi;

class PerformanceScoreController extends Controller
{
    private $menu = 'indikator_level';

    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $datas = performance_scores::get();
    //     $menu = $this->menu;
    //     return view('pages.admin.indikator_level.index', compact('menu', 'datas'));
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function index()
    {
        // Ambil User
        $users = User::whereIn('role', ['user', 'penghulu'])->get();


        // Prepare data for each user
        $userData = [];

        foreach ($users as $user) {
            // Get absensi records for this user in current month
            $absensiRecords = Absensi::where('user_id', $user->id)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->get();

            // Calculate metrics
            $totalKehadiran = $absensiRecords->count();
            $totalLaporan = $absensiRecords->filter(fn($r) => !empty($r->dokumentasi))->count();
            $totalLaporanLengkap = $absensiRecords->filter(fn($r) => !empty($r->dokumentasi) && !empty($r->keterangan))->count();

            // Calculate scores
            $kehadiranScore = $this->calculateKehadiranScore($absensiRecords);
            $ketepatanWaktuScore = $this->calculateKetepatanWaktuScore($absensiRecords);
            $laporanKegiatanScore = $this->calculateLaporanKegiatanScore($absensiRecords);
            $kelengkapanLaporanScore = $this->calculateKelengkapanLaporanScore($absensiRecords);

            $totalSkor = $kehadiranScore + $ketepatanWaktuScore + $laporanKegiatanScore + $kelengkapanLaporanScore;
            $persentase = ($totalSkor / 16) * 100; // 16 is max possible score (4 indicators × 4)
            $keterangan = $this->determineKeterangan($persentase);

            $userData[] = [
                'user' => $user,
                'absensi_records' => $absensiRecords,
                'total_kehadiran' => $totalKehadiran,
                'total_laporan' => $totalLaporan,
                'total_laporan_lengkap' => $totalLaporanLengkap,
                'kehadiran_score' => $kehadiranScore,
                'ketepatan_waktu_score' => $ketepatanWaktuScore,
                'laporan_kegiatan_score' => $laporanKegiatanScore,
                'kelengkapan_laporan_score' => $kelengkapanLaporanScore,
                'total_skor' => $totalSkor,
                'persentase' => $persentase,
                'keterangan' => $keterangan,
            ];
        }

        $menu = $this->menu;
        return view('pages.admin.indikator_level.index', compact('menu', 'userData'));
    }

    private function calculateKehadiranScore($absensiRecords)
    {
        $total = $absensiRecords->count();
        if ($total == 0) {
            return 0; // atau 1, tergantung mau kasih nilai minimal
        }

        $hadir = $absensiRecords->where('status', 'hadir')->count();

        return ($hadir / $total) >= 0.9 ? 4 : 3;
    }

    private function calculateKetepatanWaktuScore($absensiRecords)
    {
        $scores = $absensiRecords->map(function ($record) {
            if ($record->terlambat_minutes === null)
                return 4; // Tepat waktu
            if ($record->terlambat_minutes < 15)
                return 4;
            if ($record->terlambat_minutes < 30)
                return 3;
            if ($record->terlambat_minutes < 45)
                return 2;
            return 1;
        });

        return $scores->avg(); // Average score
    }

    private function calculateLaporanKegiatanScore($absensiRecords)
    {
        $totalKegiatan = $absensiRecords->count();
        $totalLaporan = $absensiRecords->filter(fn($r) => !empty($r->dokumentasi))->count();

        if ($totalKegiatan == 0)
            return 0;

        $persentase = ($totalLaporan / $totalKegiatan) * 100;

        if ($persentase == 100)
            return 4;
        if ($persentase >= 75)
            return 3;
        if ($persentase >= 50)
            return 2;
        if ($persentase >= 25)
            return 1;
        return 0;
    }

    private function calculateKelengkapanLaporanScore($absensiRecords)
    {
        $totalLaporan = $absensiRecords->filter(fn($r) => !empty($r->dokumentasi))->count();
        $totalLengkap = $absensiRecords->filter(
            fn($r) =>
            !empty($r->dokumentasi) &&
            !empty($r->keterangan) &&
            !empty($r->laporan)
        )->count();

        if ($totalLaporan == 0)
            return 0;

        $persentase = ($totalLengkap / $totalLaporan) * 100;

        if ($persentase == 100)
            return 4;
        if ($persentase >= 75)
            return 3;
        if ($persentase >= 50)
            return 2;
        if ($persentase >= 25)
            return 1;
        return 0;
    }


    private function determineKeterangan($score)
    {
        if ($score >= 90) {
            return 'Sangat Baik';
        } elseif ($score >= 75) {
            return 'Baik';
        } elseif ($score >= 60) {
            return 'Cukup';
        } elseif ($score >= 50) {
            return 'Kurang';
        } else {
            return 'Sangat Kurang';
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'periode' => 'required|date',
            'kehadiran' => 'required|integer|between:1,4',
            'ketepatan_waktu' => 'required|integer|between:1,4',
            'laporan_kegiatan' => 'required|integer|between:1,4',
            'kelengkapan_laporan' => 'required|integer|between:1,4',
            'total_absensi' => 'required|integer|min:0',
            'total_laporan' => 'required|integer|min:0',
            'total_laporan_lengkap' => 'required|integer|min:0',
        ]);

        // Calculate derived fields
        $totalSkor = $validated['kehadiran'] + $validated['ketepatan_waktu'] +
            $validated['laporan_kegiatan'] + $validated['kelengkapan_laporan'];
        $persentase = ($totalSkor / 16) * 100;
        $keterangan = $this->determineKeterangan($persentase);

        // Create performance score
        performance_scores::create([
            'user_id' => $validated['user_id'],
            'periode' => $validated['periode'],
            'kehadiran' => $validated['kehadiran'],
            'ketepatan_waktu' => $validated['ketepatan_waktu'],
            'laporan_kegiatan' => $validated['laporan_kegiatan'],
            'kelengkapan_laporan' => $validated['kelengkapan_laporan'],
            'total_skor' => $totalSkor,
            'persentase' => $persentase,
            'keterangan' => $keterangan,
            'total_absensi' => $validated['total_absensi'],
            'total_laporan' => $validated['total_laporan'],
            'total_laporan_lengkap' => $validated['total_laporan_lengkap'],
        ]);

        return redirect()->route('indikator_level.index')
            ->with('success', 'Data penilaian kinerja berhasil disimpan.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = performance_scores::findOrFail($id);
        $indicators = Indicators::get();
        $menu = $this->menu;

        return view('pages.admin.indikator_level.edit', compact('data', 'indicators', 'menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $r = $request->all();
        $data = performance_scores::find($r['id']);

        // dd($r);
        $data->update($r);

        return redirect()->route('indikator_level.index')->with('message', 'Data guru berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = performance_scores::find($id);
        $data->delete();

        return redirect()->route('indikator_level.index')->with('message', 'Data guru berhasil dihapus.');
    }

}
