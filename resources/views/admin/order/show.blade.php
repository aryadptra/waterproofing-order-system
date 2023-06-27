@extends('layouts.admin')

@section('title', 'Faktur Pesanan')

@push('custom-css')
    <style>
        @media print {
            .print-only {
                display: none;
            }
        }
    </style>
@endpush

@section('content')
    <div class="invoice" id="invoice-print">
        <div class="invoice-print">
            <div class="row">
                <div class="col-lg-12">
                    <div class="invoice-title">
                        <h2>Faktur</h2>
                        <div class="invoice-number">Faktur #{{ $order->id }}</div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <address>
                                <strong>Customer :</strong><br>
                                {{ $order->orderDetail->name }}<br>
                                {{ $order->orderDetail->phone }}
                            </address>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <address>
                                <strong>Layanan :</strong><br>
                                Water Proofing {{ $order->service->name }}<br>
                                Rp. {{ number_format($order->service->price, 0, ',', '.') }} / meter<br>
                            </address>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <address>
                                <strong>Status :</strong><br>
                                {{-- order Status with Badge --}}
                                @if ($order->status == 'pending')
                                    <div class="badge badge-warning">{{ ucfirst($order->status) }}</div>
                                @elseif ($order->status == 'wait_payment')
                                    <div class="badge badge-info">Menunggu Pembayaran</div>
                                @elseif ($order->status == 'process')
                                    <div class="badge badge-primary">{{ ucfirst($order->status) }}</div>
                                @elseif ($order->status == 'done')
                                    <div class="badge badge-success">{{ ucfirst($order->status) }}</div>
                                @elseif ($order->status == 'canceled')
                                    <div class="badge badge-danger">{{ ucfirst($order->status) }}</div>
                                @endif
                            </address>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <ad4dress>
                                <strong>Jadwal :</strong><br>
                                {{ $order->orderDetail->schedule }}<br><br>
                            </ad4dress>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="section-title">Rincian layanan</div>
                    <p class="section-lead">Berikut ini adalah detail layanan Anda.</p>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-md">
                            <thead>
                                <tr>
                                    <th>Layanan</th>
                                    <th>Luas Area</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($order as $item) --}}
                                <tr>
                                    <th>{{ $order->service->name }}</th>
                                    <th>{{ $order->orderDetail->area }}</th>
                                    <th>Rp. {{ number_format($order->orderDetail->total, 0, ',', '.') }}</th>
                                </tr>
                                {{-- @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-8">
                            <div class="section-title">Catatan</div>
                            <div class="d-flex">
                                {!! $order->message !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="text-md-right print-only">
            {{-- If Status != 'cancel', show button --}}
            @if ($order->status === 'pending')
                <div class="float-lg-left mb-lg-0 mb-3">
                    <form method="POST" action="{{ route('admin.order.updateStatus', ['id' => $order->id]) }}">
                        @csrf
                        @method('PUT')
                        <button type="submit" name="button" value="wait_payment"
                            class="btn btn-success btn-icon icon-left"><i class="fas fa-check"></i> Terima
                            Tawaran</button>
                        <button type="submit" name="button" value="cancelled" class="btn btn-danger btn-icon icon-left"><i
                                class="fas fa-times"></i> Tolak
                            Tawaran</button>
                    </form>
                </div>
            @endif
            <button class="btn btn-warning btn-icon icon-left" onclick="printInvoice()"><i class="fas fa-print"></i>
                Print</button>
        </div>
    </div>
@endsection

@push('custom-js')
    <script>
        function printInvoice() {
            var printContents = document.getElementById("invoice-print").innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
@endpush
