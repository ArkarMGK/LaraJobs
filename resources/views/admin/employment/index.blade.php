@extends('admin.layouts.master')
@section('title', 'Employment-type')
@section('content')
    <div class="col-10 offset-1">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header p-2 d-flex align-items-center">
                    <legend class="text-center">Employment Type</legend>
                    <div class="w-50">
                        <a href="{{ route('admin#createEmployment') }}" class="text-decoration-none btn btn-success w-100">Add
                            New Employment</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive p-0">
                        <table class="table table-hover text-nowrap text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employments as $employment)
                                    <tr>
                                        <td>{{ $employment->id }}</td>
                                        <td>{{ $employment->employment_type }}</td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-center">
                                                <a href="{{ route('admin#editEmploymentType', $employment) }}">
                                                    <button class="btn btn-sm bg-dark text-white"><i
                                                            class="fas fa-edit"></i> <span>Update</span></button>
                                                </a>
                                                <form method="POST"
                                                    action="{{ route('admin#deleteEmploymentType', $employment->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm bg-danger text-white"><i
                                                            class="fas fa-trash-alt"></i>
                                                        <span>Delete</span></button>
                                                </form>
                                            </div>
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
