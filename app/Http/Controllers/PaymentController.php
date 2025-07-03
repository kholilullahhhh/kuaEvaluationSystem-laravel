<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\SppPlan;

class PaymentController extends Controller
{
    private $menu = 'payment';
    public function index()
    {
        $datas = Payment::with(['siswa', 'spp'])->latest()->get();
        $menu = $this->menu;

        return view('pages.admin.payment.index', compact('menu', 'datas'));
    }
    public function create()
    {
        $siswa = User::where('role', 'siswa')->get();
        $spp = SppPlan::all();
        $menu = $this->menu;

        return view('pages.admin.payment.create', compact('menu', 'siswa', 'spp'));
    }
    public function konfirmasi($id)
    {
        $data = Payment::find($id);
        $data->status = 'paid';
        $data->paid_at = now();
        $data->save();

        return redirect()->route('payment.index')->with('success', 'Payment confirmed successfully');
    }

    public function store(Request $request)
    {
        $orderId = 'PYMT-' . time() . '-' . rand(1000, 9999);
        $data = $request->all();
        $data['order_id'] = $orderId;

        // Ensure that paid_year is set based on the selected SPP plan
        if ($request->has('spp_id')) {
            $sppPlan = SppPlan::find($request->spp_id);
            $data['paid_year'] = $sppPlan->year;  // Set paid_year from the selected SPP plan
        }
        // dd($data);

        // Save the payment data
        Payment::create($data);

        return redirect()->route('payment.index')->with('success', 'Payment created successfully');
    }

    public function destroy($id)
    {
        $data = Payment::find($id);
        $data->delete();

        return redirect()->route('payment.index')->with('message', 'Data guru berhasil dihapus.');
    }



}
