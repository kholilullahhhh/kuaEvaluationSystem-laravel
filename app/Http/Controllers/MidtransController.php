<?php

namespace App\Http\Controllers;
use App\Models\Payment;
use App\Models\Spp;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransController extends Controller
{

    public function index()
    {
        $datas = Payment::whereHas('siswa', function ($query) {
            $query->where('nisn', auth()->user()->nisn);
        })->with(['siswa', 'spp'])->latest()->get();

        return view('pages.siswa.payment.index', [
            'menu' => 'midtrans',
            'datas' => $datas
        ]);
    }

    public function create($id)
    {
        $payment = Payment::with(['siswa', 'spp'])->findOrFail($id);

        // Verifikasi status pembayaran
        if ($payment->status == 'paid') {
            return redirect()->back()
                ->with('error', 'Pembayaran ini sudah lunas');
        }

        // Verifikasi order_id
        if (empty($payment->order_id)) {
            $payment->order_id = 'PYMT-' . now()->format('YmdHis') . '-' . $payment->id;
            $payment->save();
        }

        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $params = [
            'transaction_details' => [
                'order_id' => $payment->order_id,
                'gross_amount' => $payment->amount,
            ],
            'customer_details' => [
                'first_name' => $payment->siswa->name,
                'email' => auth()->user()->email,
                'phone' => $payment->siswa->n0_hp ?? '081234567890',
            ],
            'expiry' => [
                'start_time' => now()->format('Y-m-d H:i:s O'),
                'unit' => 'hours',
                'duration' => 2, // Kadaluarsa dalam 24 jam
            ],
            'callbacks' => [
                'finish' => route('midtrans.callback')
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        // Update payment data
        $payment->update([
            'snap_token' => $snapToken,
            'status' => 'pending' // Set status ke pending
        ]);

        return view('pages.siswa.payment.checkout', [
            'menu' => 'checkout',
            'snapToken' => $snapToken,
            'payment' => $payment
        ]);
    }



    public function callback(Request $request)
    {
        // Mendapatkan server key dari konfigurasi
        $serverKey = config('midtrans.server_key');
        $order_id = $request->input('order_id');

        // Cek apakah order_id ada dalam request
        if (!$order_id) {
            return redirect()->route('midtrans.index')->with('error', 'Order ID tidak ditemukan.');
        }

        // Mencari pembayaran berdasarkan order_id
        $payment = Payment::where('order_id', $order_id)->first();

        if ($payment) {
            $payment->status = 'pending';
            $payment->paid_at = now();
            $payment->save();

            // Kirim notifikasi sukses ke pengguna
            return redirect()->route('midtrans.index')->with('success', 'Pembayaran berhasil');
        } else {
            // Jika pembayaran tidak ditemukan
            return redirect()->route('midtrans.index')->with('error', 'Pembayaran gagal, order ID tidak ditemukan.');
        }
    }


    public function notificationHandler(Request $request)
    {
        // Untuk handle notifikasi server-to-server dari Midtrans
        $notif = new \Midtrans\Notification();

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $orderId = $notif->order_id;
        $fraud = $notif->fraud_status;

        $payment = Payment::where('order_id', $orderId)->first();

        // Pastikan pembayaran ditemukan berdasarkan order_id
        if (!$payment) {
            return response()->json(['status' => 'error', 'message' => 'Payment not found'], 404);
        }

        // Mengupdate status pembayaran berdasarkan transaksi yang diterima dari Midtrans
        switch ($transaction) {
            case 'capture':
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $payment->status = 'challenge'; // Status untuk transaksi yang dicegah
                    } else {
                        $payment->status = 'paid'; // Pembayaran berhasil
                        $payment->paid_at = now(); // Set waktu pembayaran
                    }
                }
                break;
            case 'settlement':
                $payment->status = 'paid'; // Pembayaran berhasil
                $payment->paid_at = now(); // Set waktu pembayaran
                break;
            case 'pending':
                $payment->status = 'pending'; // Pembayaran tertunda
                break;
            case 'deny':
                $payment->status = 'denied'; // Pembayaran ditolak
                break;
            case 'expire':
                $payment->status = 'expired'; // Pembayaran kadaluarsa
                break;
            case 'cancel':
                $payment->status = 'canceled'; // Pembayaran dibatalkan
                break;
        }

        // Simpan perubahan status
        $payment->save();

        // Mengembalikan respons sukses
        return response()->json(['status' => 'success']);
    }
}