<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Classes;
use Illuminate\Http\Request;
use App\Models\Admin;
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
        $currentMonth = date('n');

        // Get monthly payments data
        $monthlyPayments = array_fill(1, 12, 0); // Initialize all months with 0
        $paymentsData = Payment::selectRaw('MONTH(paid_at) as month, SUM(amount) as total')
            ->whereYear('paid_at', $selectedYear)
            ->groupBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        // Merge with actual data
        foreach ($paymentsData as $month => $total) {
            $monthlyPayments[$month] = $total;
        }

        // Get class progress data
        // $classProgress = Classes::withCount([
        //     'students',
        //     'payment' => function ($query) use ($selectedYear) {
        //         $query->where('status', 'paid')
        //             ->whereYear('paid_at', $selectedYear); // Filter payments for the selected year
        //     }
        // ])->get()->map(function ($class) {
        //     $class->paid_count = $class->payments_count; // Count of paid students
        //     $class->total_students = $class->students_count; // Total number of students
        //     $class->percentage = $class->total_students > 0 ?
        //         ($class->paid_count / $class->total_students) * 100 : 0; // Calculate percentage
        //     return $class;
        // });

        return view('pages.admin.dashboard.index', [
            'menu' => 'dashboard',

            'totalStudents' => User::where(
                'role',
                'siswa'
            )->count(),
            'currentMonthPayments' => Payment::whereYear('paid_at', $selectedYear)
                ->whereMonth('paid_at', $currentMonth)
                ->sum('amount'),
            'currentYearPayment' => Payment::whereYear('paid_at', $selectedYear)
                ->sum('amount'),
            'paidPayments' => Payment::where('status', 'paid')->whereYear('paid_at', $selectedYear)->count(),
            'pendingPayments' => Payment::where('status', 'pending')->whereYear('paid_at', $selectedYear)->count(),
            'unpaidngPayments' => Payment::where('status', 'unpaid')->whereYear('paid_at', $selectedYear)->count(),
            'monthlyPayments' => $monthlyPayments,
            'paidPercentage' => $this->getPaymentPercentage('paid'),
            'pendingPercentage' => $this->getPaymentPercentage('pending'),
            'overduePercentage' => $this->getPaymentPercentage('overdue'),
            'recentPayments' => Payment::with('siswa')->latest()->take(5)->get(),
            // 'classProgress' => $classProgress, // Pass class progress data
            'selectedYear' => $selectedYear
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
