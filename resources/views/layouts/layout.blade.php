<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Guest Book</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets') }}/images/logo/favicon.png">
    <link rel="stylesheet" href="{{ asset('assets') }}/css/app.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/extensions/DataTables/datatables.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>

<body>
    <div id="app">

        @include('partials.sidebar')

        <div id="main" style="background: #EDF8EE;">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            @yield('content')

            @include('partials.footer')

        </div>
    </div>

    <script src="{{ asset('assets') }}/js/bootstrap.js"></script>
    <script src="{{ asset('assets') }}/js/app.js"></script>
    <script src="{{ asset('assets') }}/js/mazer.js"></script>
    <script src="{{ asset('assets') }}/extensions/jquery/jquery.js"></script>
    <script src="{{ asset('assets') }}/extensions/DataTables/datatables.js"></script>
    <script src="{{ asset('assets') }}/extensions/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @stack('js')

</body>

</html>
