@extends('admin.layouts.master')
@section('title', 'Older-Jobs')
@section('content')
    <div class="col-10 offset-1">
        <div class="col-lg-12 mx-auto">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <legend class="text-center">Older Jobs (Already Hired)</legend>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="activity">
                            @foreach ($jobs as $job)
                                <div class="d-lg-flex mt-4 border border-2  border-opacity-50 rounded p-4">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-2">
                                                <div class="d-flex flex-column align-items-center">
                                                    <h4># {{ $job->id }}</h4>
                                                    <div class="img-container" style="width: 100%;height:3rem">
                                                        <img src=" {{ $job->logo ? asset('storage/images/logo/' . $job->logo) : asset('images/default/logo.png') }}"
                                                            alt=""
                                                            style="height: 100%;width:100%;object-fit:contain">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-10">
                                                <p>{{ $job->company_name }}</p>
                                                <h4>
                                                    {{ $job->title }}
                                                </h4>
                                                <h6>
                                                    {{ $job->employment_type }} - {{ $job->salary }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-8">
                                                <span><i class="fas fa-globe"></i>
                                                    {{ $job->job_location }}</span>
                                            </div>
                                            <div class="col-4">
                                                <span><i class="fas fa-calendar"></i>
                                                    {{ $job->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-8">
                                                @php
                                                    $tags = explode(',', $job->tags);
                                                @endphp
                                                @foreach ($tags as $tag)
                                                    <button class="btn btn-outline-dark my-1">
                                                        {{ $tag }}
                                                    </button>
                                                @endforeach
                                            </div>

                                            <div class="col-4 jobStatus">
                                                <form action="{{ route('admin#vacantJob', $job) }}" method="POST">
                                                    @csrf
                                                    <select class="changeStatus form-control w-100 mt-4 "
                                                        name="jobCurrentStatus">
                                                        <option value="1"
                                                            @if ($job->available) selected @endif
                                                            style="color: blue">
                                                            Vacant
                                                        </option>
                                                        <option value="0"
                                                            @if ($job->available == 0) selected @endif
                                                            style="color: red">
                                                            Hired
                                                        </option>
                                                    </select>
                                                    <input type="submit" value="Confirm"
                                                        class="submitBtn btn-sm btn-danger mt-2 w-100" style="display: none">
                                                </form>

                                                <form method="POST" action="{{ route('admin#deleteJob', $job->id) }}" class="deleteJob">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm bg-danger text-white mt-2 w-100"><i
                                                            class="fas fa-trash-alt"></i>
                                                        <span>Delete</span></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 offset-lg-3 fixed-bottom">
                {{ $jobs->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            // Set selected status color on Select Box
            $currentStatus = [];

            $('.jobStatus').each(function(index, row) {
                $currentStatus.push(
                    $(row).find('.changeStatus').val(),
                );
            });

            // console.log($currentStatus);
            $('.jobStatus').each(function(index, row) {
                // console.log(row);
                if ($currentStatus[index] == '0') {
                    $(row).find('.changeStatus').css('color', 'red');
                } else if ($currentStatus[index] == '1') {
                    $(row).find('.changeStatus').css('color', 'blue');
                }
            });

            // Change Status Color on Each Row and Update Value to DB
            $('.changeStatus').change(function() {
                $parentNode = $(this).parents('.jobStatus');
                $current = $parentNode.find('.changeStatus').val();
                console.log($current);
                if ($current == '0') {
                    $($parentNode).find('.changeStatus').css('color', 'red');
                    $($parentNode).find('.submitBtn').hide();
                    $($parentNode).find('.deleteJob').show();
                } else if ($current == '1') {
                    $($parentNode).find('.changeStatus').css('color', 'blue');
                    $($parentNode).find('.submitBtn').show();
                    $($parentNode).find('.deleteJob').hide();
                }

            })

        })
    </script>
@endsection
