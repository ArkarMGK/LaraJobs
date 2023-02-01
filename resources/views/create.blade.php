@extends('../layouts/master');
@section('title', 'The official larajob board')
@include('../partials/_navLogo')
@section('content')
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-center">
            <div class="col-8">
                <div class="row">
                    <div class="col-md-8 mb-4">
                        <form method="POST" action="{{ route('storeJob') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="jobTitle" class="form-label">Job Title</label>
                                <input type="text" class="form-control" id="jobTitle" name="jobTitle">
                                <div class="form-text">Example: "Senior Laravel Developer", "Software Engineer"</div>
                            </div>
                            <div class="mb-3">
                                <label for="jobLocation" class="form-label">Job Location</label>
                                <input type="text" class="form-control" id="jobLocation" name="jobLocation">
                                <div class="form-text">Example: "Remote", "Remote / USA", "New York City", "Remote GMT-5",
                                    etc.</div>
                            </div>
                            <div class="mb-3">
                                <label for="jobUrl" class="form-label">URL to Description/Application</label>
                                <input type="text" class="form-control" id="jobUrl" name="jobUrl">
                                <div class="form-text">https://yourcompany.com/careers</div>
                            </div>
                            <div class="mb-3">
                                <label for="employmentType" class="form-label">Employment Type</label>
                                <select name="employmentType" id="employmentType" class="form-select">
                                    <option value="1">Full Time</option>
                                    <option value="2">Part Time</option>
                                    <option value="3">Contractor</option>
                                    <option value="4">Intern</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="companyName" class="form-label">Company Name</label>
                                <input type="text" class="form-control" id="companyName" name="companyName">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Company Logo</label>
                                <div class="d-flex">
                                    <div class="img-container" style="width:4rem;height:3rem">
                                        <img src="{{ asset('images/default/logo.png') }}" alt=""
                                            style="height: 100%;width:100%;object-fit:contain">
                                    </div>
                                    <label for="logo" class="border rounded px-3 py-2" style="width:8rem">Select
                                        File</label>
                                    <input id="logo" type="file" name="photo" style="display: none;">
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
                            </div>
                            <input type="submit" value="Checkout" class="btn btn-primary">
                        </form>
                    </div>
                    <div class="col-md-4 text-center fs-4 text-secondary">
                        <div class="companies mt-4">
                            <p>The official Laravel job board since 2014. Trusted by thousands of companies.</p>
                            <h5 class="mt-4">
                                <div>
                                    <span>Adobe</span>
                                    <span class="text-secondary">HelloFresh</span>
                                    <span>World Trade Organization</span>
                                    <span class="text-secondary">USbancrop</span>
                                </div>
                            </h5>
                        </div>
                        <div class="border border-secondary border-bottom-2 mt-4">
                        </div>
                        <div class="laravelNews mt-4">
                            <p>
                                Exclusively syndicated across the <a class="text-decoration-none"
                                    href="https://laravel-news.com/" target="_blank">Laravel News</a> website/newsletter to
                                millions of readers
                            </p>
                        </div>
                        <div class="border border-secondary border-bottom-2 mt-4">
                        </div>
                        <div class="email mt-4">
                            <p>Emailed to 40,000+ Laravel developers</p>
                        </div>
                        <div class="border border-secondary border-bottom-2 mt-4"></div>
                        <div class="testimonial mt-4">
                            <div class="d-flex justify-content-center">
                                <div class="img-contaier d-" style="height: 8rem ;width:8rem">
                                    <img src="{{ asset('images/default/matt2.jpg') }}" alt=""
                                        style="border-radius: 50%;height: 100%;width:100%;object-fit:contain">
                                </div>
                            </div>
                            <p>“Listing our jobs through LaraJobs was simple, quick, and helped us find amazing candidates.
                            </p>
                            <p style="background: #ffff4f">We've now hired numerous times through LaraJobs and we'll
                                absolutely use it again!”</p>
                            <h6><a href="https://twitter.com/stauffermatt" target="_blank">Matt Stauffer</a>, Tighten Co.
                            </h6>
                        </div>
                    </div>
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
