@extends('layouts.admin')

@section('title', 'Tambah Pengguna')

@section('content')
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <form method="post" action="{{ route('admin.user.store') }}" class="needs-validation" novalidate="">
                    @csrf
                    @method('POST')

                    <div class="card-header">
                        <h4>Tambah Pengguna</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label>Name</label>
                                <input type="text" class="form-control" value="{{ old('name') }}" name="name">
                                <div class="invalid-feedback">
                                    Please fill in the first name
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                    required="">
                                <div class="invalid-feedback">
                                    Please fill in the email
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label>Phone</label>
                                <input type="number" class="form-control" value="{{ old('phone') }}" name="phone">
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Alamat</label>
                                <textarea class="form-control" name="address" id="" cols="20">{{ old('address') }}</textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label>Role</label>
                                <select name="role" class="form-control">
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                {{-- Password New --}}
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password">
                                <span class="text-danger">Kosongkan jika tidak ingin diubah</span>
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
