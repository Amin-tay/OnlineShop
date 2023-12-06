@php use Illuminate\Support\Facades\Auth; @endphp


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous" defer>
    </script>
    {{-- <script
        type="text/javascript"
        src={{ asset('/assets/js/admin.js') }}
        defer
         ></script> --}}
    <meta name="_token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/custom.js') }}" defer></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .back-tester {
            background-color: #d2d2d2;
        }
    </style>
    {{--    @vite(['/resources/js/app.js']) --}}

</head>

<body class="back-tester">

    {{-- <!-- Page Heading --> --}}
    {{-- @if (isset($header)) --}}
    {{--    <header class="bg-white dark:bg-gray-800 shadow"> --}}
    {{--        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8"> --}}
    {{--            {{ $header }} --}}
    {{--        </div> --}}
    {{--    </header> --}}
    {{-- @endif --}}
    <!-- Page Content -->
    <main>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">Shop</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('admin.index') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.categories.index') }}">Categories</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.products.index') }}">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.orders.index') }}">Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.discountCodes.index') }}">Discount Codes</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
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



        {{ $slot }}
    </main>

    {{-- <script>
    $(document).ready(function () {
        $('.order_status').change(function () {
            var selectedOption = $(this).find('option:selected');

            var data = {
                _token: '{{ csrf_token() }}', // Add the CSRF token
                order_id: $(this).data('order-id'), // Assuming you have an order ID associated with each select element
                status: selectedOption.val(),
                status_label: selectedOption.text()
            };

            $.post('/admin/change-order-status', data, function (response) {
                // Handle the response from the controller
                selectedOption.parent().removeClass().addClass(response.css_class);

            }, 'json');
        });
    });
</script> --}}

</body>

</html>
