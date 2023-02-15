@extends('../layouts/master');
@section('title', 'The official larajob board')
@include('../partials/_nav')
@include('../partials/_hero_job')
@section('content')
    <div class="col-3 px-4 fixed-top offset-9 mt-5">
        {{-- <button class="btn btn-outline-info text-secondary me-4">Hire a Consultant</button> --}}
        <a href="{{ route('createJob') }}">
            <button class="btn btn-outline-primary">Post a job</button>
        </a>

    </div>
    <div class="container-fluid">
        <div class="d-flex justify-content-center px-2">
            <div class="col-lg-6">
                <!--FILTER BY TAGS-->
                <div class="row d-flex justify-content-end">
                    <div class="col-3">
                        @php
                            $allTags = explode(',', $allTags);
                        @endphp
                        <form action="{{ route('home') }}" method="GET">
                            <select class="form-select" aria-label="form-select-lg example" name="tags"
                                id="searchByTags">
                                <option selected>Filter</option>
                                <option value="all">All Jobs</option>
                                @foreach ($allTags as $tag)
                                    <option value="{{ $tag }}">{{ $tag }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
                <!--ACTIVE JOB LIST-->
                <div id="jobList">
                    @foreach ($jobs as $job)
                        <div class="row my-4 border border-2  border-opacity-50 rounded p-4">
                            <div class="col-2 d-flex flex-column justify-content-center">
                                <div class="img-container" style="width: 100%;height:3rem">
                                    <img src=" {{ $job->logo ? asset('storage/images/logo/' . $job->logo) : asset('images/default/logo.png') }}"
                                        alt="" style="height: 100%;width:100%;object-fit:contain">
                                </div>
                            </div>
                            <div class="col-10">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="row">
                                            <p>{{ $job->company_name }}</p>
                                        </div>
                                        <div class="row">
                                            <h4>
                                                {{ $job->title }}
                                            </h4>
                                        </div>
                                        <div class="row">
                                            <h6>
                                                {{ $job->employment_type }} - {{ $job->salary }}
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row d-flex">
                                            <div class="col-6">
                                                <span><i class="fa-solid fa-globe"></i> {{ $job->job_location }}</span>
                                            </div>
                                            <div class="col-6">
                                                <span><i class="fa-solid fa-calendar-days"></i>
                                                    {{ $job->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                        <div class="">
                                            @php
                                                $tags = explode(',', $job->tags);
                                            @endphp
                                            @foreach ($tags as $tag)
                                                <button class="btn btn-sm btn-outline-dark my-1">
                                                    {{ $tag }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!--No Jobs in Filter-->
                <div id="noJob" style="display: none">
                    <h4 class="text-danger">
                        No Jobs are Found .....!
                    </h4>
                </div>
                <!--All Tags-->
                <div>
                    @foreach ($allTags as $tag)
                        <button value="{{ $tag }}" style="background:#ddd"
                            class="px-3 py-2 mt-4 border-0 me-4">{{ $tag }}</button>
                    @endforeach
                </div>

                <!--Older Jobs-->
                <div id="oldJobList">
                    <div class="d-flex justify-content-between mt-4">
                        <h4>Older Jobs</h4>
                        <p>Note, these jobs may no longer be available</p>
                    </div>
                    @foreach ($oldJobs as $job)
                        <div class="row my-4 border border-2  border-opacity-50 rounded p-4">
                            <div class="col-2 d-flex flex-column justify-content-center">
                                <div class="img-container" style="width: 100%;height:3rem">
                                    <img src=" {{ $job->logo ? asset('storage/images/logo/' . $job->logo) : asset('images/default/logo.png') }}"
                                        alt="" style="height: 100%;width:100%;object-fit:contain">
                                </div>
                            </div>
                            <div class="col-10">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="row">
                                            <p>{{ $job->company_name }}</p>
                                        </div>
                                        <div class="row">
                                            <h4>
                                                {{ $job->title }}
                                            </h4>
                                        </div>
                                        <div class="row">
                                            <h6>
                                                {{ $job->employment_type }} - {{ $job->salary }}
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row d-flex">
                                            <div class="col-6">
                                                <span><i class="fa-solid fa-globe"></i> {{ $job->job_location }}</span>
                                            </div>
                                            <div class="col-6">
                                                <span><i class="fa-solid fa-calendar-days"></i>
                                                    {{ $job->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                        <div class="">
                                            @php
                                                $tags = explode(',', $job->tags);
                                            @endphp
                                            @foreach ($tags as $tag)
                                                <button class="btn btn-sm btn-outline-dark my-1">
                                                    {{ $tag }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    @include('../partials/_footer')
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#searchByTags').change(function() {

                $('#oldJobList').hide();

                $tagName = $('#searchByTags').val();
                console.log($tagName);
                $.ajax({
                    type: 'get',
                    url: '/ajax/filterTags',
                    data: {
                        'tagName': $tagName,
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response.length);
                        // No Jobs
                        if (response.length < 1) {
                            $("#noJob").show();
                        }
                        else{
                            $('#noJob').hide();
                        }

                        $list = '';
                        for ($i = 0; $i < response.length; $i++) {

                            $tags = response[$i].tags.split(',');
                            console.log($tags);
                            $tagList = '';
                            for ($j = 0; $j < $tags.length; $j++) {
                                $tagList += `
                                <button class="btn btn-sm btn-outline-dark my-1">
                                    ${ $tags[$j] }
                                </button>
                                `;
                            }
                            $list +=
                                `
                                <div class="row my-4 border border-2  border-opacity-50 rounded p-4">
                                    <div class="col-2 d-flex flex-column justify-content-center">
                                        <div class="img-container" style="width: 100%;height:3rem">
                                            <img src="${response[$i].logo}"
                                                alt="" style="height: 100%;width:100%;object-fit:contain">
                                        </div>
                                    </div>
                                    <div class="col-10">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <p>${response[$i].company_name}</p>
                                                </div>
                                                <div class="row">
                                                    <h4>
                                                        ${response[$i].title}
                                                    </h4>
                                                </div>
                                                <div class="row">
                                                    <h6>
                                                        ${response[$i].employment_type } - ${response[$i].salary }
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row d-flex">
                                                    <div class="col-6">
                                                        <span><i class="fa-solid fa-globe"></i> ${response[$i].job_location }</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <span><i class="fa-solid fa-calendar-days"></i>
                                                            ${response[$i].createdAt}</span>
                                                    </div>
                                                </div>
                                                <div class="">
                                                    ${$tagList}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                `;
                        }
                        $('#jobList').html($list);
                    }

                })
            });
        });
    </script>
@endsection
