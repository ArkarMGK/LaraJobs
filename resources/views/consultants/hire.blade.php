@extends('../layouts/master')
@section('title', 'Laravel Consultants & FreeLancers')
@include('../partials/_nav')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <h1 class="my-4 fs-2 fw-bolder">Get a quote</h1>
                <small class="text-muted">CONSULTANTS TO CONTACT</small>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="input-group d-flex">
                            <span class="input-group-text px-4 bg-success"><i
                                    class="fa fa-circle-check text-white"></i></span>
                            <span class="border rounded-right p-2">{{ $company->name }}</span>
                        </div>
                    </div>
                </div>

                <h1 class="mt-2 fs-2 fw-bolder">Your Project Details</h1>
                <form method="POST" action="{{ route('hireProject') }}">
                    @csrf
                    <input type="hidden" name="hiring_company_id" value="{{$company->id}}">
                    <div class="mb-3">
                        <label for="name" class="form-label">Your Name</label>
                        <input type="text" class="form-control rounded" id="name" name="name"
                            value="{{ old('name') }}">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Your Email</label>
                        <input type="text" class="form-control rounded" id="email" name="email"
                            value="{{ old('email') }}">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="companyName" class="form-label">Your Company Name</label>
                        <input type="text" class="form-control rounded" id="companyName" name="companyName"
                            value="{{ old('companyName') }}">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label>Your Budget</label>
                        <select name="budget" id="" class="form-select">
                            <option value="">Please Select</option>
                            <option value="0-10000">Less than $10000</option>
                            <option value="10000-25000">$10000 - $25000</option>
                            <option value="25000-50000">$25000 - $50000</option>
                            <option value="50000-10000">$50000 - $100000</option>
                        </select>
                        @error('budget')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description of your project</label>
                        <textarea name="description" id="description" rows="3" class="form-control rounded">{{ old('description') }}</textarea>
                        @error('description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-end mb-3">
                        <button class="btn btn-success px-5">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
