<div class="text-center my-4 p-4">
    <div class="row d-flex justify-content-center">
        <div class="col-6">
            <h1 class="text-primary fw-bolder"> Laravel Consultants</h1>
            <h1>for every size project</h1>
            <p class="my-4 fw-bold">
                Outsource a project or embed Laravel experts into your existing team.
            </p>

            @if (session('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{session('message')}}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>
</div>
