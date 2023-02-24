@extends('../layouts/master')
@section('title', 'Laravel Consultants & FreeLancers')
@include('../partials/_nav')
@include('../partials/_listAgency')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 mx-auto p-4 card">
                <form method="POST" action="{{ route('storeCompany') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Company Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="details" class="form-label">Details</label>
                        <textarea name="details" id="details" rows="5" class="form-control">{{ old('details') }}</textarea>
                        @error('details')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Company Email</label>
                        <input type="text" class="form-control" id="email" name="email"
                            value="{{ old('email') }}">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="website" class="form-label">Company Web Address</label>
                        <input type="text" class="form-control" id="website" name="website"
                            value="{{ old('website') }}">
                        <div class="text-muted"> https://yourcompany.com/</div>
                        @error('website')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Company Location</label>
                        <input type="text" class="form-control" id="location" name="location"
                            value="{{ old('location') }}">
                        @error('location')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="region" class="form-label">Region</label>
                        <select name="region" id="region" class="form-select">
                            <option value="">Please Select:</option>
                            @foreach ($regions as $region)
                                <option value="{{ $region }}">{{ $region }}</option>
                            @endforeach
                        </select>
                        @error('region')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Company Logo</label>
                        <div class="d-flex">
                            <div class="img-container" style="width:4rem;height:3rem">
                                <img src="{{ asset('images/default/logo.png') }}" alt=""
                                    style="height: 100%;width:100%;object-fit:contain">
                            </div>
                            <label for="image" class="border rounded px-3 py-2" style="width:8rem">Select
                                File</label>
                            <input type="file" name="image" id="image" style="display: none">
                        </div>
                        @error('image')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                    </div>
                    <div class="mb-3">
                        <label for="min_budget" class="form-label">Min Budget For a Project</label>
                        <input type="text" class="form-control" id="min_budget" name="min_budget"
                            value="{{ old('min_budget') }}">
                        @error('min_budget')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="max_budget" class="form-label">Max Budget For a Project</label>
                        <input type="text" class="form-control" id="max_budget" name="max_budget"
                            value="{{ old('max_budget') }}">
                        @error('max_budget')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-end">
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
