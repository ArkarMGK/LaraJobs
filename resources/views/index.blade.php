@extends('../layouts/master');
@section('title', 'The official larajob board')
@include('../partials/_nav')
@include('../partials/_hero_job')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-center">
            <div class="col-6">
                <div class="row d-flex">
                    <div class="col-10"></div>
                    <div class="col-2">
                        @php
                            $allTags = explode(',', $allTags['tags']);
                        @endphp
                        <select class="form-select" aria-label=".form-select-lg example">
                            <option selected>Filter</option>
                            <option value="all">All Jobs</option>
                            @foreach ($allTags as $tag)
                                <option value="{{ $tag }}">{{ $tag }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @foreach ($jobs as $job)
                    <div class="row my-4 border border-2  border-opacity-50 rounded p-4">
                        <div class="col-2">
                            <div class="img-container" style="width: 100%;height:3rem">
                                <img src="{{ asset('images/default/logo.png') }}" alt=""
                                    style="height: 100%;width:100%;object-fit:contain">
                            </div>
                        </div>
                        <div class="col-4">
                            <p>{{ $job->company_name }}</p>
                            <h4>
                                {{ $job->title }}
                            </h4>
                            <h6>
                                {{ $job->employment_type }} - {{ $job->salary }}
                            </h6>
                        </div>
                        @php
                            $tags = explode(',', $job->tags);
                        @endphp
                        <div class="col-6">
                            <div class="row d-flex">
                                <div class="col-6">
                                    <span><i class="fa-solid fa-globe"></i> {{ $job->job_location }}</span>
                                </div>
                                <div class="col-6">
                                    <span><i class="fa-solid fa-calendar-days"></i>
                                        {{ $job->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <div>
                                @foreach ($tags as $tag)
                                    <button class="btn btn-outline-dark my-1">
                                        {{ $tag }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
