@extends('layouts.user')

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

    <div class="row">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Sukses!</strong> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif
            {{-- Jika any error --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Whoops!</strong> Terjadi kesalahan saat input data, yaitu:
                    <ul class="pl-4 my-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                    Mohon periksa kembali :)
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>

                </div>
            @endif
        </div>
    </div>

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
                                @elseif($order->status == 'waiting_confirmation')
                                    <div class="badge badge-info">Menunggu Konfirmasi</div>
                                @elseif($order->status == 'confirmed')
                                    <div class="badge badge-success">Dikonfirmasi</div>
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
                                    <th>{{ $order->orderDetail->area }} Meter</th>
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
                    <form method="POST" action="{{ route('user.order.updateStatus', ['id' => $order->id]) }}">
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
            @if ($order->status === 'wait_payment')
                {{-- Modal Upload Bukti Pembayaran --}}
                <div class="float-lg-left mb-lg-0 mb-3">
                    <button type="button" class="btn btn-primary btn-icon icon-left" data-toggle="modal"
                        data-target="#uploadPaymentModal"><i class="fas fa-upload"></i> Upload Bukti Pembayaran</button>
                </div>
                {{-- Modal Upload Bukti Pembayaran --}}
            @endif
            <button class="btn btn-warning btn-icon icon-left" onclick="printInvoice()"><i class="fas fa-print"></i>
                Print</button>
        </div>
    </div>
@endsection

@push('custom-modal')
    {{-- Modal Input File  --}}
    <div class="modal fade"tabindex="-1" role="dialog" id="uploadPaymentModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Sparepart</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('user.order.uploadProof', $order->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <div class="form-group">
                            {{-- Foto --}}
                            <label for="foto">Foto</label>
                            <div class="custom-file">
                                <input type="file" class="form-control" name="proof_of_transfer"
                                    onchange="document.getElementById('image-preview').src = window.URL.createObjectURL(this.files[0])">
                                {{-- Max 2 MB --}}
                                <span class="text-muted">Max 2MB</span>
                            </div>
                        </div>
                        <div class="form-group">
                            {{-- Foto Preview --}}
                            <label for="foto-preview">Foto Preview</label>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <img src="" alt="Bukti" id="image-preview"
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush

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
    <script>
        // Image Preview
        function previewImage() {
            document.getElementById("image-preview").style.display = "block";
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("image").files[0]);

            oFReader.onload = function(oFREvent) {
                document.getElementById("image-preview").src = oFREvent.target.result;
            };
        };
    </script>
@endpush
