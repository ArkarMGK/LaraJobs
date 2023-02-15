@extends('../layouts/master');
@section('title', 'The official larajob board')
@include('../partials/_navLogo')
@section('content')
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-center">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-8 mb-4">
                        <form method="POST" action="{{ route('updateJob', $job->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="jobTitle" class="form-label">Job Title</label>
                                <input type="text" class="form-control" id="jobTitle" name="jobTitle"
                                    value="{{ old('jobTitle', $job->title) }}">
                                <div class="form-text">Example: "Senior Laravel Developer", "Software Engineer"</div>
                                @error('jobTitle')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="jobLocation" class="form-label">Job Location</label>
                                <input type="text" class="form-control" id="jobLocation" name="jobLocation"
                                    value="{{ old('jobLocation', $job->job_location) }}">
                                <div class="form-text">Example: "Remote", "Remote / USA", "New York City", "Remote GMT-5",
                                    etc.</div>
                                @error('jobLocation')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="jobUrl" class="form-label">URL to Description/Application</label>
                                <input type="text" class="form-control" id="jobUrl" name="jobUrl"
                                    value="{{ old('jobUrl', $job->job_url) }}">
                                <div class="form-text">https://yourcompany.com/careers</div>
                                @error('jobUrl')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="employmentType" class="form-label">Employment Type</label>
                                <select name="employmentType" id="employmentType" class="form-select">
                                    @foreach ($employments as $employment)
                                        <option value="{{$employment->id}}" @if ($employment->id == $job->employment_type_id)
                                            selected
                                        @endif>{{$employment->employment_type}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="salary" class="form-label">Salary (Optional)</label>
                                <input type="number" class="form-control" id="salary" name="salary"
                                    value="{{ old('salary',$job->salary) }}">
                            </div>
                            <div class="mb-3">
                                <label for="companyName" class="form-label">Company Name</label>
                                <input type="text" class="form-control" id="companyName" name="companyName"
                                    value="{{ old('companyName', $job->company_name) }}">
                                @error('companyName')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Company Logo</label>
                                <div class="d-flex">
                                    <div class="img-container" style="width:4rem;height:3rem">
                                        <img src="{{ $job->logo ? asset('storage/images/logo/' . $job->logo) : asset('images/default/logo.png') }}"
                                            alt="" style="height: 100%;width:100%;object-fit:contain">
                                    </div>
                                    <label for="image" class="border rounded px-3 py-2" style="width:8rem">Select
                                        File</label>
                                    <input type="file" name="image" id="image" style="display: none">
                                    @error('image')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="hidden" id="allTags" value="{{ $allTags }}">
                                {{-- All Values From selected tags --}}
                                <input type="hidden" name="selectedTags" id="selectedValues" value="{{ $job->tags }}">
                                @php
                                    $tags = explode(',', $allTags);
                                @endphp

                                <label for="jobTag" class="form-label">Tags</label>
                                <div id="listOfSelectedTags" class="form-control">
                                    @php
                                        $selectedJobTags = explode(',', $job->tags);
                                    @endphp
                                    @foreach ($selectedJobTags as $item)
                                        <button class="btn btn-outline-dark my-1">
                                            {{ $item }}
                                        </button>
                                    @endforeach
                                </div>
                                <select name="jobTag" id="jobTag" class="form-select">
                                    <option disabled selected hidden></option>
                                    @foreach ($tags as $tag)
                                        <option value="{{ $tag }}">{{ $tag }}</option>
                                    @endforeach
                                </select>

                                <div class="form-text">Max of five tags</div>
                                @error('jobTag')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <input type="submit" value="Checkout" class="btn btn-primary">
                        </form>

                    </div>
                    {{-- END OF LEFT SIDE --}}
                    @include('partials._rightArticle')
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
            // $('#listOfSelectedTags').hide();
            // keep selected tags in an array
            $allTags = $('#allTags').val();
            $unSelectedTags = $allTags.split(',')
            $selectedTags = [];

            $('#jobTag').change(function() {
                if ($selectedTags.length < 5) {
                    $tag = $('#jobTag').val();
                    $selectedTags.push($tag);
                    $('#listOfSelectedTags').show();
                    $tagList = [];
                    for ($j = 0; $j < $selectedTags.length; $j++) {
                        $tagList += `
                                <button class="btn btn-outline-dark my-1">
                                    ${ $selectedTags[$j] }
                                </button>
                                `;
                                $unSelectedTags = $.grep($unSelectedTags, function(value) {
                            return value != $selectedTags[$j];
                        });
                    }
                    // Appends to HTML to show user selected tags
                    $('#listOfSelectedTags').html($tagList);
                    $('#listOfSelectedTags').show();

                    // Set SELECTED VALUES to hidden field as a string
                    $selectedTagsStr = $selectedTags + '';
                    $('#selectedValues').val($selectedTagsStr);


                    console.log('all_tags => ' + $allTags);
                    console.log('selected tags =>' + $selectedTagsStr);
                    $unSelectedTagsStr = $unSelectedTags + '';
                    console.log('remaining tags=>' + $unSelectedTagsStr);

                    // str.replace(rem_substring, newSubstring);

                    // Filter selected tags
                    // $tags = $('#allTags').val().split(',');
                    // $unSelectedTags = $tags.filter(v => v != $selectedTags[$i]);
                    // $i= $i+1;
                    // console.log('increase count '+$i);
                    // console.log('unselected tags '+$unSelectedTags);

                    // Convert unselected tags to an array
                    // $unSelectedTagsArr = $unSelectedTags.split(',');
                    // console.log($unSelectedTagsArr);


                }
            })


        })
    </script>
@endsection
