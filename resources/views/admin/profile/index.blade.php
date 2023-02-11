@extends('admin.layouts.master')
@section('title', 'Index-Page')
@section('content')
    <div class="col-10 offset-1">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header p-2">
                    <legend class="text-center">Admin Account Info</legend>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="activity">
                            <!--ALERT MESSAGES-->
                            @if (session('updateSuccess'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('updateSuccess') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <!--End ALERT MESSAGES-->
                            <form class="form-horizontal" action="" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-4  text-center">Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="name" id="inputName"
                                            placeholder="Name" value="{{ old('name', $user->name) }}">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-4 text-center">Email</label>
                                    <div class="col-sm-8">
                                        <div class="text-muted form-control">{{ $user->email }}</div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn bg-dark text-white">Submit</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
