@extends('layouts.admin')

@section('title', 'Pesanan')

@push('custom-css')
    {{-- Datatable --}}
    <link rel="stylesheet" href="{{ asset('core/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('core/node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Layanan</h4>
                    {{-- Right button --}}
                    <div class="ml-auto">
                        {{-- Add Order Button --}}
                        <a href="{{ route('admin.order.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Pesanan
                        </a>
                    </div>
                </div>
                <div class="card-body">
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
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        #
                                    </th>
                                    <th>Nama</th>
                                    <th>Tipe Layanan</th>
                                    <th>Alamat</th>
                                    <th>Luas Area</th>
                                    <th>Harga (Per meter)</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Foreach --}}
                                @foreach ($orders as $item)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->service->name }}</td>
                                        <td>{{ $item->orderDetail->address }}</td>
                                        <td>{{ $item->orderDetail->area }}</td>
                                        <td>Rp. {{ number_format($item->service->price, 0, ',', '.') }}</td>
                                        <td>Rp. {{ number_format($item->orderDetail->total, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($item->status == 'pending')
                                                <span class="badge badge-warning">Menunggu Konfirmasi</span>
                                            @elseif($item->status == 'confirmed')
                                                <span class="badge badge-info">Dikonfirmasi</span>
                                            @elseif($item->status == 'on_progress')
                                                <span class="badge badge-info">Diproses</span>
                                            @elseif($item->status == 'done')
                                                <span class="badge badge-success">Selesai</span>
                                            @elseif($item->status == 'canceled')
                                                <span class="badge badge-danger">Dibatalkan</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{-- Show Button --}}
                                            <a href="{{ route('admin.order.show', ['id' => $item->id]) }}"
                                                class="btn btn-success btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            {{-- Edit --}}
                                            <a href="{{ route('admin.order.edit', ['id' => $item->id]) }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            {{-- Form --}}
                                            <form action="{{ route('admin.order.destroy', ['id' => $item->id]) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                {{-- Delete --}}
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-modal')
    <div class="modal fade" tabindex="-1" role="dialog" id="addSparepartModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Layanan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.service.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Nama layanan" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea class="form-control" id="description" required name="description" placeholder="Deskripsi"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        Rp.
                                    </div>
                                </div>
                                <input required type="number" class="form-control" id="price" name="price"
                                    placeholder="Harga">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        / Meter
                                    </div>
                                </div>
                                {{-- Input grup --}}
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
    <script src="{{ asset('core/node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('core/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('core/assets/js/page/modules-datatables.js') }}"></script>

    <script>
        function delete() {
            confirm("Apakah anda yakin ingin menghapus data ini?");
        }
    </script>
@endpush
