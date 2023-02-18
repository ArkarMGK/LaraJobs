@extends('admin.layouts.master')
@section('title', 'List of Users')
@section('content')
<div class="col-lg-8 mx-auto">
    <div class="card">
        <div class="card-header p-2">
            <legend class="text-center">Lists of all Users</legend>
        </div>
        <div class="card-body">
            <div class="table-responsive p-0">
                <table class="table table-hover text-nowrap text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('admin#userInfo', $user) }}">
                                            <button class="btn btn-sm bg-dark text-white"><i class="fas fa-info"></i>
                                                <span>Details</span></button>
                                        </a>
                                        <form method="POST"
                                            action="{{ route('admin#deleteUser', $user->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm bg-danger text-white"><i class="fas fa-trash-alt"></i>
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
    <div class="col-lg-8 offset-lg-3 fixed-bottom">
        {{ $users->appends(request()->query())->links() }}
    </div>
</div>
@endsection
