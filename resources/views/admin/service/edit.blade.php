@extends('layouts.admin')

@section('title', 'Profile')

@section('content')
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <form method="post" action="{{ route('admin.service.update', $service->id) }}" class="needs-validation"
                    novalidate="">
                    @csrf
                    @method('PUT')

                    <div class="card-header">
                        <h4>Edit Layanan</h4>
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
                                <input type="text" class="form-control" value="{{ $service->name }}" name="name">
                            </div>

                            <div class="form-group col-md-6 col-12">
                                <label>Harga</label>
                                {{-- <input type="text" class="form-control" value="{{ $service->name }}" name="name"> --}}
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Rp.
                                        </div>
                                    </div>
                                    <input required type="number" value="{{ $service->price }}" class="form-control"
                                        id="price" name="price" placeholder="Harga">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            / Meter
                                        </div>
                                    </div>
                                    {{-- Input grup --}}
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Deskripsi</label>
                                <textarea class="form-control" id="description" required name="description" placeholder="Deskripsi">{{ $service->description }}</textarea>
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
