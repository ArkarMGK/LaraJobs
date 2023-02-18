@extends('admin.layouts.master')
@section('title', 'User Info')
@section('content')
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header p-2 d-flex">
                <legend class="text-center"><span class="text-primary text-capitalize">{{ $user->name }}</span> Information
                </legend>
                <div class="w-25">
                    <button onclick="history.back()" class="btn btn-secondary w-100"><i
                            class="fas fa-arrow-left"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="row p-2">
                    <div class="col-6">
                        <h5> ID</h5>
                    </div>
                    <div class="col-6">
                        <h5> {{ $user->id }} </h5>
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col-6">
                        <h5> Email</h5>
                    </div>
                    <div class="col-6">
                        <h5> {{ $user->email }} </h5>
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col-6">
                        <h5> Registered Date</h5>
                    </div>
                    <div class="col-6">
                        <h5> {{ $user->created_at->format('d.M.Y')}} </h5>
                    </div>
                </div>

                <div class="row p-2">
                    <div class="col-6">
                        <h5>Jobs Vacancy Count</h5>
                    </div>
                    <div class="col-6">
                        <h5> {{ $activeJobsCount }} </h5>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
