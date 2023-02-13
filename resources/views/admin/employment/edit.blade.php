@extends('admin.layouts.master')
@section('title', 'Edit-employment')
@section('content')
    <div class="col-10 offset-1">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header p-2 d-flex">
                    <legend class="text-center">Create New Employment Type</legend>
                    <div class="w-25">
                        <a href="{{ route('admin#employmentType') }}" class="text-decoration-none btn btn-secondary w-100"><i
                                class="fas fa-arrow-left"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="activity">
                            <form action="{{ route('admin#updateEmploymentType',$employment) }}" method="POST">
                                @csrf
                                <div class="p-4">
                                    <label for="employmentType">New Employment Type</label>
                                    {{-- NOTE. name="employment_type" to be the same value as database Attribute --}}
                                    <input type="text" name="employmentType" id="employmentType" class="mt-4 form-control"
                                        value="{{ old('employmentType', $employment->employment_type) }}">
                                    @error('employmentType')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="p-4">
                                    <input type="submit" value="Update" class="ms-4 btn btn-success">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
