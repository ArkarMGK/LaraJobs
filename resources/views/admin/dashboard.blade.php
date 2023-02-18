@extends('admin.layouts.master')
@section('title', 'Dashboard')
@section('content')
    <div class="col-10 offset-1">
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="card py-4">
                    <i class="text-primary fas fa-list px-3 fa-2x"></i>
                    <h1 class="text-primary font-weight-bolder text-center"> {{ $totalJobsCount }} </h1>
                    <h2 class="text-center">Jobs Posted</h2>
                </div>
            </div>
            <div class="col-lg-6 mx-auto">
                <div class="card py-4">
                    <i class="text-danger fas fa-check px-3 fa-2x"></i>
                    <h1 class="text-danger font-weight-bolder text-center"> {{ $hiredJobsCount }} </h1>
                    <h2 class="text-center">Jobs Hired</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="card py-4">
                    <i class="text-primary fas fa-user px-3 fa-2x"></i>
                    <h1 class="text-primary font-weight-bolder text-center"> {{ $numberOfUsers }}</h1>
                    <h2 class="text-center">Registered Users</h2>
                </div>
            </div>
            <div class="col-lg-6 mx-auto">
                <div class="card py-4">
                    <i class="text-primary fas fa-building px-3 fa-2x"></i>
                    <h1 class="text-primary font-weight-bolder text-center"> {{ $numberOfCompanies }} </h1>
                    <h2 class="text-center">Companies</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mx-auto">
            <div class="card">
            </div>
        </div>
    </div>
@endsection
