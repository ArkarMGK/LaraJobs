<div class="container-fluid">
    <div class="col-11 offset-1 d-flex">
        <div class="col-4">
            <a class="navbar-brand text-info fs-1" href="{{ route('home') }}">Larajobs</a>
        </div>

        <div class="col-8 mt-4">
            <div class="row">
                <div class="col-md-8 col-6">

                </div>
                <div class="col-md-4 col-6">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <div class="text-secondary">{{ Auth::user()->name }}</div>
                        <input type="submit" value="Logout">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
