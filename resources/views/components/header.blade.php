<nav class="navbar navbar-expand-lg navbar-light"
    style="background-color: rgb(239, 237, 237); box-shadow: 0 0 0.5em 0.1em gray">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">TDD - SOLID</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ str_starts_with(Route::currentRouteName(), 'app.home') ? 'active' : '' }}"
                        href="{{ route('app.home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ str_starts_with(Route::currentRouteName(), 'app.category') ? 'active' : '' }}"
                        href="{{ route('app.category.index') }}">Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ str_starts_with(Route::currentRouteName(), 'app.product') ? 'active' : '' }}"
                        href="{{ route('app.product.index') }}">Products</a>
                </li>
            </ul>
            <form action="{{ route('app.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
          </div>
    </div>
</nav>
