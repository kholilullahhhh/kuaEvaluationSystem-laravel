<?php

namespace App\Http\Controllers;

use App\Models\Indicator_levels;
use App\Models\Payment;
use App\Models\Agenda;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Absensi;
use Spatie\Activitylog\Models\Activity;
use App\Models\User;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index(Request $request)
    {
        $selectedYear = $request->year ?? date('Y');
        $selectedMonth = $request->month ?? date('n');

        // User statistics
        $totalUsers = User::count();
        $adminCount = User::where('role', 'admin')->count();
        $kepalaKuaCount = User::where('role', 'kepala_kua')->count();
        $pegawaiCount = User::where('role', 'user')->count();

        // Agenda statistics
        $totalAgendas = Agenda::count();
        $agendasThisMonth = Agenda::whereYear('tgl_kegiatan', $selectedYear)
            ->whereMonth('tgl_kegiatan', $selectedMonth)
            ->count();

        // Attendance statistics
        $totalAttendances = Absensi::count();
        $hadirCount = Absensi::where('status', 'hadir')->count();
        $tidakHadirCount = Absensi::where('status', 'tidak hadir')->count();
        $izinCount = Absensi::where('status', 'izin')->count();
        $sakitCount = Absensi::where('status', 'sakit')->count();
        $terlambatCount = Absensi::where('status', 'terlambat')->count();

        // Performance assessment statistics
        $totalAssessments = Indicator_levels::count();
        $averageScore = Indicator_levels::avg('score') ?? 0;

        // Recent data
        $recentAgendas = Agenda::orderBy('tgl_kegiatan', 'desc')
            ->take(5)
            ->get();

        $recentAttendances = Absensi::with(['user', 'agenda'])
            ->latest()
            ->take(5)
            ->get();

        $recentAssessments = Indicator_levels::with(['user', 'indikator'])
            ->latest()
            ->take(5)
            ->get();

        // Monthly attendance data for chart
        $monthlyAttendance = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyAttendance[$i] = [
                'hadir' => Absensi::where('status', 'hadir')
                    ->whereHas('agenda', function ($q) use ($i, $selectedYear) {
                        $q->whereYear('tgl_kegiatan', $selectedYear)
                            ->whereMonth('tgl_kegiatan', $i);
                    })
                    ->count(),
                'tidak_hadir' => Absensi::where('status', 'tidak hadir')
                    ->whereHas('agenda', function ($q) use ($i, $selectedYear) {
                        $q->whereYear('tgl_kegiatan', $selectedYear)
                            ->whereMonth('tgl_kegiatan', $i);
                    })
                    ->count(),
                'izin' => Absensi::where('status', 'izin')
                    ->whereHas('agenda', function ($q) use ($i, $selectedYear) {
                        $q->whereYear('tgl_kegiatan', $selectedYear)
                            ->whereMonth('tgl_kegiatan', $i);
                    })
                    ->count(),
            ];
        }

        return view('pages.admin.dashboard.index', [
            'menu' => 'dashboard',
            'selectedYear' => $selectedYear,
            'selectedMonth' => $selectedMonth,

            // User stats
            'totalUsers' => $totalUsers,
            'adminCount' => $adminCount,
            'kepalaKuaCount' => $kepalaKuaCount,
            'pegawaiCount' => $pegawaiCount,

            // Agenda stats
            'totalAgendas' => $totalAgendas,
            'agendasThisMonth' => $agendasThisMonth,

            // Attendance stats
            'totalAttendances' => $totalAttendances,
            'hadirCount' => $hadirCount,
            'tidakHadirCount' => $tidakHadirCount,
            'izinCount' => $izinCount,
            'sakitCount' => $sakitCount,
            'terlambatCount' => $terlambatCount,

            // Performance stats
            'totalAssessments' => $totalAssessments,
            'averageScore' => round($averageScore, 2),

            // Recent data
            'recentAgendas' => $recentAgendas,
            'recentAttendances' => $recentAttendances,
            'recentAssessments' => $recentAssessments,

            // Chart data
            'monthlyAttendance' => $monthlyAttendance,
        ]);
    }


    private function getPaymentPercentage($status)
    {
        $total = Payment::count();
        if ($total == 0)
            return 0;

        return round((Payment::where('status', $status)->count() / $total) * 100, 2);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function profile($id)
    {
        $data = Admin::find($id);
        return view('pages.admin.profile.index', ['menu' => 'profile', 'data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function profile_update(Request $request)
    {
        $r = $request->all();
        // $update_nik = Pegawai::where('nama_lengkap', $r['name'])->first();
        // $update->nik();


        // dd( $r['id']);
        $admin = Admin::find($r['id']);
        $user = User::find($r['id']);
        if ($r['password'] != null) {
            $r['password'] = bcrypt($r['password']);
            // dump('ubah password');
        } else {
            unset($r['password']);
        }
        // dd(true);

        $admin->update($r);
        $user->update($r);

        return redirect()->route('dashboard')->with('message', 'update profile');
    }

}
