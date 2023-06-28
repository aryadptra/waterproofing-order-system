@extends('layouts.user')

@section('title', 'Profile')

@section('content')
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <form method="post" action="{{ route('user.user.profile.update') }}" class="needs-validation" novalidate="">
                    @csrf
                    @method('PUT')

                    <div class="card-header">
                        <h4>Edit Profile</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label>Name</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->name }}" name="name">
                                <div class="invalid-feedback">
                                    Please fill in the first name
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}"
                                    required="">
                                <div class="invalid-feedback">
                                    Please fill in the email
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label>Phone</label>
                                <input type="number" class="form-control" value="{{ Auth::user()->phone }}" name="phone">
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Alamat</label>
                                <textarea class="form-control" name="address" id="" cols="20">{{ Auth::user()->address }}</textarea>
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
