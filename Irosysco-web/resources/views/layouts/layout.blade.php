<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title') - Arceniter Web</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets') }}/img/favicon.png">
    <link href="{{ asset('assets') }}/css/nucleo-icons.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/nucleo-svg.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/style.css" rel="stylesheet" />
    <link id="pagestyle" href="{{ asset('assets') }}/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

    @stack('style')

</head>

<body class="g-sidenav-show bg-gray-100">
    <div class="min-height-300 position-absolute w-100" style="background: #4C7E81;"></div>

    @include('partials.sidebar')

    <main class="main-content position-relative border-radius-lg ">

        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur"
            data-scroll="false">
            <div class="container-fluid py-1 px-3 pt-3" style="padding-left: 0 !important; padding-right: 0 !important;">

                @yield('breadcrumb-content')

                <div class="collapse navbar-collapse mt-sm-0 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                        <div class="input-group">
                            <span class="input-group-text text-body"><i class="fas fa-search"
                                    aria-hidden="true"></i></span>
                            <input type="text" class="form-control" placeholder="Type here...">
                        </div>
                    </div>
                    <ul class="navbar-nav justify-content-end">
                        <li class="nav-item d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white font-weight-bold px-0">
                                <img src="{{ asset('assets') }}/img/team-3.jpg"
                                    style="width: 35px; height: 35px; border-radius: 50px; margin-right: 10px">
                                <span class="d-sm-inline d-none">Angga Gemilang</span>
                            </a>
                        </li>
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item px-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0">
                                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                            </a>
                        </li>
                        <li class="nav-item dropdown pe-2 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-bell cursor-pointer"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid py-2">

            @yield('content')

            @include('partials.footer')

        </div>
    </main>

    <script type="text/javascript" src="{{ asset('assets') }}/landing-page/js/jquery-3.4.1.min.js"></script>
    <script src="{{ asset('assets') }}/js/core/popper.min.js"></script>
    <script src="{{ asset('assets') }}/js/core/bootstrap.min.js"></script>
    <script src="{{ asset('assets') }}/js/argon-dashboard.min.js?v=2.0.4"></script>
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @stack('js')
</body>

</html>
