@php use Illuminate\Support\Facades\Auth; @endphp


    <!doctype html>
<html lang="en">

<head>
    <style>
        .back-tester {
            background-color: #f3f3fe;
            height: 100%;
        }


        .nav-color {
            position: fixed;
        }

        .footer_class {
            position: relative;
            margin-top: -150px;
            /* negative value of footer height */
            height: 150px;
            clear: both;
            padding-top: 20px;
        }

        .wrap_class {
            min-height: 100%;
        }

        .main_class {
            overflow: auto;
            padding-bottom: 150px;
            /* this needs to be bigger than footer height*/
        }

        #logo_img {
            width: 170px;
            height: auto;
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"
            defer>
    </script>
    <meta name="_token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/custom2.js') }}" defer></script>
</head>

<body class="back-tester min-vh-100 h-100">

<nav class="navbar navbar-expand-lg bg-body-tertiary nav-color">
    <div class="container-fluid">
        <a class="navbar-brand " href="/"><img id="logo_img" class="" src="/storage/Img/logoText.png"/></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                @if (Auth::user() && !Auth::user()->hasAnyRole('superAdmin', 'normalAdmin'))
                    <li class="nav-item">
                        <a class="nav-link" href="/viewCart">Cart</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/viewOrders">Orders</a>
                    </li>
                @endif
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            @if (Auth::user()->hasAnyRole('superAdmin', 'normalAdmin'))
                                <li class="">
                                    <a href="{{ route('admin.index') }}" class="dropdown-item">Panel</a>
                                </li>
                            @endif
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                       this.closest('form').submit();">Logout</a>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>

                @endauth
            </ul>
        </div>
    </div>
</nav>

@if (session()->has('success'))
    <div class="alert alert-success mt-5 text-center">
        {{ session()->get('success') }}
        {{--            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button> --}}
    </div>
@endif
@if (session()->has('warning'))
    <div class="alert alert-warning  mt-5 text-center">
        {{ session()->get('warning') }}
        {{--            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button> --}}
    </div>
@endif
@if (session()->has('danger'))
    <div class="alert alert-danger  mt-5 text-center">
        {{ session()->get('danger') }}
        {{--            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button> --}}
    </div>
@endif
<main class="warp_class">
    <div class="main_class">
        {{ $slot }}
        </div>
    </main>


</body>

</html>
{{-- <footer class='footer_class footer fixed-bottom'>
    <div class="container  ">
        <hr>
        <div class="py-3 my-4">
            <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                <li class="nav-item"><a href="/" class="nav-link px-2 text-muted">Home</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Features</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Pricing</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">FAQs</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">About</a></li>
            </ul>
            <p class="text-center text-muted">© 2023 OnlineShop, Inc</p>
        </div>
        </footer> --}}
