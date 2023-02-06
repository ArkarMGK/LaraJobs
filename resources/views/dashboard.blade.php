<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-jet-welcome />
            </div>
        </div>
    </div> --}}
    <div class="container-fluid">
        <div class="d-flex justify-content-center px-2">
            <div class="col-md-6">
                <h1 class="fs-1 mt-2 underline">Active Jobs</h1>
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
                                @php
                                    $tags = explode(',', $job->tags);
                                @endphp
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
    @include('partials/_footer')
</x-app-layout>
