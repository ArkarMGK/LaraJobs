<nav class="navbar navbar-expand-lg ">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav col-lg-12">
                <a class="text-info col-lg-4 text-lg-center pt-2 fs-1 text-decoration-none"
                    href="{{ route('home') }}">Larajobs</a>
                <div class="col-lg-4 d-lg-flex justify-content-around fs-5 pt-lg-3">
                    <a class="nav-link" href="#">Jobs</a>
                    <a class="nav-link" href="#">Consultants</a>
                    <a class="nav-link" href="https://twitter.com/laraveljobs" target="_blank">Twitter</a>
                    @if (Auth::user())
                        <a class="nav-link" href="{{ route('dashboard')}}">My Account</a>
                    @else
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</nav>
