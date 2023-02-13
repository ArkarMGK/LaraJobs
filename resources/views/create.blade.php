@extends('../layouts/master');
@section('title', 'The official larajob board')
@include('../partials/_navLogo')
@section('content')
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-center">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-8 mb-4">
                        @unless(Auth::user())
                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                {{-- <x-jet-validation-errors class="mb-2 text-danger" /> --}}
                                <div class="mx-1 row p-2 rounded" style="background:#eee">
                                    <div class="col-sm-5 col-12 my-1">
                                        <input type="email" name="email" class="p-2 w-100" placeholder="email">
                                    </div>
                                    <div class="col-sm-5 col-12 my-1">
                                        <input type="password" name="password" class="p-2 w-100" placeholder="password">
                                    </div>
                                    <div class="col-sm-2 col-8 my-1">
                                        <input type="submit" class="btn btn-outline-danger p-2 px-3 w-100" value="Login">
                                    </div>
                                </div>
                            </form>
                            <div class="d-flex justify-content-between mb-4">
                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none" href="{{ route('password.request') }}">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                @endif

                                <a class="text-muted" href="#register">No account? We'll set one up below.</a>
                            </div>
                        @endunless
                        <form method="POST" action="{{ route('storeJob') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user">
                            @error('user')
                                <small class="text-danger mb-3">Please Login or Register below to create job</small>
                            @enderror
                            <div class="mb-3">
                                <label for="jobTitle" class="form-label">Job Title</label>
                                <input type="text" class="form-control" id="jobTitle" name="jobTitle"
                                    value="{{ old('jobTitle') }}">
                                <div class="form-text">Example: "Senior Laravel Developer", "Software Engineer"</div>
                                @error('jobTitle')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="jobLocation" class="form-label">Job Location</label>
                                <input type="text" class="form-control" id="jobLocation" name="jobLocation"
                                    value="{{ old('jobLocation') }}">
                                <div class="form-text">Example: "Remote", "Remote / USA", "New York City", "Remote GMT-5",
                                    etc.</div>
                                @error('jobLocation')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="jobUrl" class="form-label">URL to Description/Application</label>
                                <input type="text" class="form-control" id="jobUrl" name="jobUrl"
                                    value="{{ old('jobUrl') }}">
                                <div class="form-text">https://yourcompany.com/careers</div>
                                @error('jobUrl')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="employmentType" class="form-label">Employment Type</label>
                                <select name="employmentType" id="employmentType" class="form-select">
                                    @foreach ($employments as $employment)
                                        <option value="{{$employment->id}}">{{$employment->employment_type}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="companyName" class="form-label">Company Name</label>
                                <input type="text" class="form-control" id="companyName" name="companyName"
                                    value="{{ old('companyName') }}">
                                @error('companyName')
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
                                    @error('image')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="hidden" id="allTags" value="{{ $allTags }}">
                                @php
                                    $tags = explode(',', $allTags);
                                @endphp

                                <label for="jobTag" class="form-label">Tags</label>
                                <div id="listOfSelectedTags" class="form-control"></div>
                                <select name="jobTag" id="jobTag" class="form-select">
                                    <option disabled selected hidden></option>
                                    @foreach ($tags as $tag)
                                        <option value="{{ $tag }}">{{ $tag }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="selectedTags" id="selectedValues">
                                <div class="form-text">Max of five tags</div>
                                @error('selectedTags')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            @if (Auth::user())
                                <input type="submit" value="Checkout" class="btn btn-primary">
                            @endif

                            {{-- Register Form --}}
                            @unless(Auth::user())
                                <div class="row mx-1 p-2 rounded" style="background:#c8e7ff">
                                    <h6 class="text-center mt-2">Create an Account</h6>
                                    <p class="text-muted ms-4">To login and edit the listing later.</p>
                                    <div class="col-12">
                                        <h5>Your Name</h5>
                                        <input type="text" name="name" class="form-control w-100"
                                            value="{{ old('name') }}">
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-12 mt-2">
                                        <h5>Your Email</h5>
                                        <input type="email" name="email" class="form-control w-100"
                                            value="{{ old('email') }}">
                                    </div>
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <div class="col-12 mt-2">
                                        <h5>Password</h5>
                                        <input type="password" name="password" class="form-control w-100">
                                    </div>
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <div class="col-12 mt-2">
                                        <h5>Confirm Password</h5>
                                        <input type="password" name="password_confirmation" class="form-control w-100">
                                    </div>
                                </div>
                                <div class="text-center mt-2">
                                    <input type="submit" value="Checkout" class="btn btn-info text-white">
                                </div>
                            @endunless
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
            $('#listOfSelectedTags').hide();
            // keep selected tags in an array
            $selectedTags = [];
            $tags = $('#allTags').val();

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
                    }
                    // Appends to HTML to show user selected tags
                    $('#listOfSelectedTags').html($tagList);

                    $selectedTagsStr = $selectedTags + '';
                    console.log($selectedTagsStr);

                    $unSelectedTagsStr = $tags.replace($selectedTagsStr, '');
                    console.log($tags);
                    console.log($unSelectedTagsStr);


                    $('#selectedValues').val($selectedTagsStr);

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
