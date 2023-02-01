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
            <div class="col-md-6">
                <!--FILTER BY TAGS-->
                <div class="row d-flex">
                    <div class="col-10"></div>
                    <div class="col-2">
                        @php
                            $allTags = explode(',', $allTags);
                        @endphp
                        <form action="/" method="GET">
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
                <!--JOB LIST-->
                <div id="jobList">
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

                <!--All Tags-->
                <div>
                    @foreach ($allTags as $tag)
                        <button value="{{ $tag }}" style="background:#ddd" class="px-3 py-2 mt-4 border-0 me-4">{{ $tag }}</button>
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
                        // console.log(response);
                        // $('#jobList').html('<h2>Success</h2>');

                        $list = '';
                        for ($i = 0; $i < response.length; $i++) {

                            $tags = response[$i].tags.split(',');
                            console.log($tags);
                            $tagList = '';
                            for ($j = 0; $j < $tags.length; $j++) {
                                $tagList += `
                                <button class="btn btn-outline-dark my-1">
                                    ${ $tags[$j] }
                                </button>
                                `;
                            }
                            $list +=
                                `
                                <div class="row my-4 border border-2  border-opacity-50 rounded p-4">
                                    <div class="col-2">
                                        <div class="img-container" style="width: 100%;height:3rem">
                                            <img src="{{ asset('images/default/logo.png') }}" alt=""
                                                style="height: 100%;width:100%;object-fit:contain">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <p>${response[$i].company_name}</p>
                                        <h4>
                                            ${response[$i].title}
                                        </h4>
                                        <h6>
                                            ${response[$i].employment_type } - ${response[$i].salary }
                                        </h6>
                                    </div>

                                    <div class="col-6">
                                        <div class="row d-flex">
                                            <div class="col-6">
                                                <span><i class="fa-solid fa-globe"></i> ${response[$i].job_location }</span>
                                            </div>
                                            <div class="col-6">
                                                <span><i class="fa-solid fa-calendar-days"></i>
                                                    ${response[$i].created_at}</span>
                                            </div>
                                        </div>
                                        <div>
                                            ${$tagList}
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
