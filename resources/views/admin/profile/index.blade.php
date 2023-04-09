@extends('admin.layouts.master')
@section('title', 'Admin-Profile')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header p-2">
                <legend class="text-center">Admin Account Info</legend>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 mb-2">
                        <h5 class="mt-2">
                            Profile Information
                        </h5>
                    </div>
                    <div class="col-lg-6">
                        <form class="form-horizontal" action="{{ route('admin#updateProfile') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <label for="inputName" class="col-lg-4">Name</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="name" id="inputName"
                                        placeholder="Name" value="{{ old('name', $user->name) }}">
                                    @error('name')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail" class="col-lg-4">Email</label>
                                <div class="col-lg-8">
                                    <div class="text-muted form-control">{{ $user->email }}</div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <input type="submit" value="Save" class="btn-sm btn-info w-25">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <h5>
                            Update Password
                        </h5>
                    </div>
                    <div class="col-lg-6">
                        <form class="form-horizontal" action="{{ route('admin#updatePassword') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <label for="oldPassword" class="col-lg-4">Old Password</label>
                                <div class="col-lg-8">
                                    <input type="password" class="form-control" name="oldPassword" id="oldPassword">
                                    @error('oldPassword')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="newPassword" class="col-lg-4">New Password</label>
                                <div class="col-lg-8">
                                    <input type="password" class="form-control" name="newPassword" id="newPassword">
                                    @error('newPassword')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="confirmPassword" class="col-lg-4">Confirm Password</label>
                                <div class="col-lg-8">
                                    <input type="password" class="form-control" name="confirmPassword" id="confirmPassword">
                                    @error('confirmPassword')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-4">
                                <input type="submit" class="btn-sm btn-info w-25" value="Save">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
