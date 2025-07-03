@extends('layouts.app', ['title' => 'Checkout Pembayaran'])

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Checkout Pembayaran</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-8 offset-md-2">
                    <div class="card">
                        <div class="card-header">
                            <h4>Detail Pembayaran</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6>ID Pembayaran</h6>
                                    <p>{{ $payment->order_id }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Total Pembayaran</h6>
                                    <p>Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            
                            <div id="snap-container"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" 
        data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    window.snap.pay('{{ $snapToken }}', {
        onSuccess: function(result){
            window.location.href = "{{ route('midtrans.callback') }}?status=success&order_id={{ $payment->order_id }}";
        },
        onPending: function(result){
            window.location.href = "{{ route('midtrans.callback') }}?status=pending&order_id={{ $payment->order_id }}";
        },
        onError: function(result){
            window.location.href = "{{ route('midtrans.callback') }}?status=error&order_id={{ $payment->order_id }}";
        },
        onClose: function(){
            // Pengguna menutup popup tanpa menyelesaikan pembayaran
            window.location.href = "{{ route('midtrans.index') }}";
        }
    });
</script>
@endpush
@endsection