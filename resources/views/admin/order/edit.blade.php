@extends('layouts.admin')

@section('title', 'Edit Pesanan')

@push('custom-css')
    <link rel="stylesheet" href="{{ asset('core/node_modules/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('core/node_modules/codemirror/lib/codemirror.css') }}">
    <link rel="stylesheet" href="{{ asset('core/node_modules/codemirror/theme/duotone-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('core/node_modules/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('core/node_modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('core/node_modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <form method="post" action="{{ route('admin.order.update', ['id' => $order->id]) }}"
                    class="needs-validation" enctype="multipart/form-data" novalidate="">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <h4>Tambah Pesanan</h4>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="container">
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
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label>Nama</label>
                                <input type="text" class="form-control" value="{{ $order->orderDetail->name }}"
                                    name="name">
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>No Handphone</label>
                                <input type="number" class="form-control" value="{{ $order->orderDetail->phone }}"
                                    name="phone">
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Email</label>
                                <input type="email" class="form-control" value="{{ $order->orderDetail->email }}"
                                    name="email">
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Alamat</label>
                                <textarea class="form-control" rows="30" cols="30" id="address" required name="address"
                                    placeholder="Alamat">{{ $order->orderDetail->address }}</textarea>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Layanan</label>
                                <select class="form-control selectric" name="service_id">
                                    <option value="">Pilih Layanan</option>
                                    @foreach ($services as $service)
                                        {{-- <option value="{{ $service->id }}">{{ $service->name }}</option> --}}
                                        {{-- If $order->service_id , selected --}}
                                        <option value="{{ $service->id }}"
                                            @if ($order->service_id == $service->id) selected @endif>{{ $service->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Harga</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Rp.
                                        </div>
                                    </div>
                                    <input required type="number" value="{{ $order->service->price }}" readonly
                                        value="" class="form-control" id="price" name="price"
                                        placeholder="Harga">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            / Meter
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Luas Area</label>
                                <div class="input-group">
                                    <input required type="number" value="{{ $order->orderDetail->area }}"
                                        class="form-control" id="area" name="area" placeholder="Luas Area">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Meter
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Total</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Rp.
                                        </div>
                                    </div>
                                    <input required type="number" readonly value="{{ $order->orderDetail->total }}"
                                        class="form-control" id="total" name="total" placeholder="Total Harga">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            / Meter
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Date Time Picker</label>
                                <input type="datetime-local" value="{{ $order->orderDetail->schedule }}" name="schedule"
                                    class="form-control">
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Catatan</label>
                                <textarea class="form-control" id="description" required name="message" placeholder="Catatan">{{ $order->orderDetail->message }}</textarea>
                            </div>
                            {{-- Proof of Payment --}}
                            <div class="form-group col-md-6 col-12">
                                <label>Bukti Pembayaran</label>
                                <input type="file" class="form-control" name="proof_of_transfer"
                                    onchange="document.getElementById('image-preview').src = window.URL.createObjectURL(this.files[0])">
                                {{-- Max 2 MB --}}
                                <span class="text-muted">Max 2MB</span>
                                <br>
                                <br>

                                @if ($order->orderDetail->proof_of_transfer)
                                    <img src="{{ asset('storage/' . $order->orderDetail->proof_of_transfer) }}"
                                        alt="Bukti Pembayaran" style="width: 200px; height: 200px; object-fit: cover;">

                                    <br>

                                    {{-- Button Download --}}
                                    <a href="{{ asset('storage/' . $order->orderDetail->proof_of_transfer) }}"
                                        class="btn btn-primary btn-sm mt-2" download>Download</a>
                                @endif

                                {{-- Image Preview --}}
                                <img src="" alt="Bukti" id="image-preview"
                                    style="width: 100px; height: 100px; object-fit: cover;">
                            </div>

                            {{-- Status --}}
                            <div class="form-group col-md-6 col-12">
                                <label>Status</label>
                                <select class="form-control selectric" name="status">
                                    <option value="">Pilih Status</option>
                                    <option value="pending" @if ($order->status == 'pending') selected @endif>Pending
                                    </option>
                                    <option value="wait_payment" @if ($order->status == 'wait_payment') selected @endif>Menunggu
                                        Pembayaran</option>
                                    <option value="confirmed" @if ($order->status == 'confirmed') selected @endif>
                                        Dikonfirmasi</option>
                                    <option value="on_progress" @if ($order->status == 'on_progress') selected @endif>Dalam
                                        Pengerjaan
                                    <option value="done" @if ($order->status == 'done') selected @endif>Selesai
                                    </option>
                                    <option value="canceled" @if ($order->status == 'canceled') selected @endif>Dibatalkan
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('custom-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="{{ asset('core/assets/js/stisla.js') }}"></script>
    <!-- JS Libraies -->
    <script src="{{ asset('core/node_modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('core/node_modules/summernote/dist/summernote-bs4.js') }}"></script>
    <script src="{{ asset('core/node_modules/codemirror/lib/codemirror.js') }}"></script>
    <script src="{{ asset('core/node_modules/codemirror/mode/javascript/javascript.js') }}"></script>
    <script src="{{ asset('core/node_modules/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('core/node_modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('core/assets/js/page/forms-advanced-forms.js') }}"></script>

    <script>
        // Get all value of service
        $(document).ready(function() {
            $('select[name="service_id"]').on('change', function() {
                var serviceID = $(this).val();
                if (serviceID) {
                    $.ajax({
                        url: '/admin/order/getService/' + serviceID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            // Ubah value dari input price dengan data yang diambil dari ajax
                            $('input[name="price"]').empty();
                            $('input[name="price"]').val(data.price);
                        },
                        error: function() {
                            $('input[name="price"]').empty();
                            console.log('error');
                        }
                    });
                } else {
                    $('input[name="price"]').val('');
                }
            });
        });
    </script>

    <script>
        // Total 
        $(document).ready(function() {
            $('input[name="area"]').on('keyup', function() {
                var area = $(this).val();
                var price = $('input[name="price"]').val();
                if (area >= 50) {
                    // Diskon 10%
                    var total = (area * price) - ((area * price) * 10 / 100);
                    $('input[name="total"]').empty();
                    $('input[name="total"]').val(total);
                } else {
                    var total = area * price;
                    $('input[name="total"]').empty();
                    $('input[name="total"]').val(total);
                }
            });
        });
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
