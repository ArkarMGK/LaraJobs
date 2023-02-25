@extends('../layouts/master')
@section('title', 'Laravel Consultants & FreeLancers')
@include('../partials/_nav')
@include('../partials/_consultants')
@section('content')
    <div class="col-3 px-4 fixed-top offset-9 mt-5">
        {{-- <button class="btn btn-outline-info text-secondary me-4">Hire a Consultant</button> --}}
        <a
            href=" @if (Auth::user()) {{ route('createCompany') }} @else
        {{ route('register') }} @endif">
            <button class="btn btn-outline-primary">List Your Agency</button>
        </a>

    </div>
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-center">
            <div class="col-9 mx-auto">
                <div class="row">
                    <div class="col-3 filter mt-5">
                        <div class="form-group">
                            <label>Your Budget</label>
                            <select name="Budget" id="" class="form-select">
                                <option value="all">Please Select</option>
                                <option value="0-10000">Less than $10000</option>
                                <option value="10000-25000">$10000 - $25000</option>
                                <option value="25000-50000">$25000 - $50000</option>
                                <option value="50000-100000">$50000 - $100000</option>
                            </select>
                        </div>
                        <div class="form-group mt-4">
                            <label for="">Location</label>
                        </div>
                        @foreach ($regions as $region)
                            <div class="form-check region">
                                <input class="form-check-input" type="checkbox" value="{{ $region }}"
                                    id="{{ $region }}">
                                <label class="form-check-label" for="{{ $region }}">
                                    {{ $region }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-9">
                        <h1>Featured</h1>
                        <hr>
                        <div class="row shadow pb-5" id="companyList">
                            @foreach ($randomCompanies as $company)
                                <div class="col-lg-6 mt-4">
                                    <div class="card" style="max-height: 60vh">
                                        <div class="img-container p-2 shadow" style="width: 100%;height:10rem">
                                            <img src="{{ $company->logo ? asset('storage/images/logo/' . $company->logo) : asset('images/default/logo.png') }}"
                                                alt="" style="height: 100%;width:100%;object-fit:cover">
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $company->name }}</h5>
                                            <p class="card-text">{{ $company->details }}</p>
                                            <div class="d-flex justify-content-between">
                                                <p>Projects From : {{ $company->min_budget }}</p>
                                                <a href="{{ route('contactCompany', $company->id) }}"
                                                    class="text-decoration-none contactLink">
                                                    <button class="btn btn-outline-primary"> <i
                                                            class="fa fa-plus-circle text-dark"></i> Contact</button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!--No Jobs in Filter-->
                        <div id="noCompany" style="display: none">
                            <h4 class="text-danger p-4 text-center">
                                No Company .....!
                            </h4>
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
            $filterValues = [];
            $projectBudget = 'all';
            $filterValues[0] = $projectBudget;

            // Filter by Project region
            $('.form-select').change(function() {
                $projectBudget = $('.form-select').val();
                console.log($projectBudget);
                $filterValues[0] = ($projectBudget);

                // console.log($filterValues);

                $.ajax({
                    type: 'get',
                    url: '/ajax/filterCompanies',
                    data: {
                        'data': $filterValues,
                    },
                    dataType: 'json',
                    success: function(response) {
                        // console.log(response);

                        if (response.length < 1) {
                            $("#noCompany").show();
                            $("#companyList").hide();
                        } else {
                            $('#noCompany').hide();
                            $("#companyList").show();
                        }

                        $list = '';
                        for ($i = 0; $i < response.length; $i++) {
                            $route = '/laravel-consultant/contact/'+response[$i].id;
                            $list += `
                                <div class="col-lg-6 mt-4">
                                    <div class="card">
                                        <div class="img-container p-2 shadow" style="width: 100%;height:10rem">
                                            <img src="${response[$i].logo}"
                                                alt="" style="height: 100%;width:100%;object-fit:cover">
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">${response[$i].name}</h5>
                                            <p class="card-text">${response[$i].details}</p>
                                            <div class="d-flex justify-content-between">
                                                <p>Projects From : ${response[$i].min_budget }</p>
                                                <a href="${$route}"
                                                    class="text-decoration-none contactLink">
                                                    <button class="btn btn-outline-primary"> <i
                                                            class="fa fa-plus-circle text-dark"></i> Contact</button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        }

                        $('#companyList').html($list);
                    }
                })

            })

            // Filter By Project Budget
            $('.form-check-input').change(function() {
                let ischecked = $(this).is(':checked');
                if (ischecked) {
                    $parentNode = $(this).parents('.region');
                    $value = $parentNode.find('.form-check-input').val();
                    $filterValues.push($value);
                }
                if (!ischecked) {
                    $parentNode = $(this).parents('.region');
                    $value = $parentNode.find('.form-check-input').val();
                    $filterValues = $filterValues.filter(function(item) {
                        return item !== $value
                    })
                }

                // console.log($filterValues);
                $.ajax({
                    type: 'get',
                    url: '/ajax/filterCompanies',
                    data: {
                        'data': $filterValues,
                    },
                    dataType: 'json',
                    success: function(response) {
                        // console.log(response);
                        if (response.length < 1) {
                            $("#noCompany").show();
                            $("#companyList").hide();
                        } else {
                            $('#noCompany').hide();
                            $("#companyList").show();
                        }

                        $list = '';
                        for ($i = 0; $i < response.length; $i++) {
                            $route = '/laravel-consultant/contact/'+response[$i].id;
                            $list += `
                                <div class="col-lg-6 mt-4">
                                    <div class="card">
                                        <div class="img-container p-2 shadow" style="width: 100%;height:10rem">
                                            <img src="${response[$i].logo}"
                                                alt="" style="height: 100%;width:100%;object-fit:cover">
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">${response[$i].name}</h5>
                                            <p class="card-text">${response[$i].details}</p>
                                            <div class="d-flex justify-content-between">
                                                <p>Projects From : ${response[$i].min_budget }</p>
                                                <a href="${$route}"
                                                    class="text-decoration-none contactLink">
                                                    <button class="btn btn-outline-primary"> <i
                                                            class="fa fa-plus-circle text-dark"></i> Contact</button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        }

                        $('#companyList').html($list);
                    }
                })


            })

        })
    </script>
@endsection
