<div class="container-fluid shadow pb-2">
    <div class="col-11 offset-1 d-flex">
        <div class="col-4">
            <a class="navbar-brand text-info fs-1" href="{{ route('home') }}">Larajobs</a>
        </div>

        @if (Auth()->user())
            <div class="col-8 mt-4">
                <div class="row">
                    <div class="col-lg-8 col-6">
                        <a href="{{route('dashboard')}}" class="text-decoration-none text-dark">My Account</a>
                        <a href="{{route('history')}}" class="text-decoration-none text-dark">Order history</a>
                    </div>
                    <div class="col-lg-4 col-6">
                        <form action="{{route('logout')}}" method="POST">
                        @csrf
                        <div class="text-secondary p-1">{{Auth::user()->name}}</div>
                        <input type="submit" value="Logout" class="btn btn-secondary btn-sm">
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="col-8 mt-4">
                <a href="{{route('login')}}" class="fs-5">Login</a>
            </div>
        @endif
    </div>
</div>
