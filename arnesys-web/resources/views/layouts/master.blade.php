<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title') - Arnesys Web</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets') }}/img/favicon.png">
    <link href="{{ asset('assets') }}/css/nucleo-icons.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/nucleo-svg.css" rel="stylesheet" />
    <link id="pagestyle" href="{{ asset('assets') }}/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

    @stack('style')

    <link href="{{ asset('assets') }}/css/style.css" rel="stylesheet" />

</head>

<body class="g-sidenav-show bg-gray-100">

    <div class="scroller-wrapper">

        @include('sweetalert::alert')

        <div class="loader">
            <img style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);"
                src="{{ asset('assets/img/loader/loader1.gif') }}" />
        </div>

        <div class="min-height-300 position-absolute w-100" style="background: #4C7E81;"></div>

        @include('components.master.sidebar')

        <main class="main-content position-relative border-radius-lg">

            <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur"
                data-scroll="false">

                <div class="container-fluid py-1 px-3 pt-3"
                    style="padding-left: 0 !important; padding-right: 0 !important;">

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
                                    <span class="d-sm-inline d-none">
                                        @hasrole('Operator')
                                            {{ Auth::user()->name }}
                                        @endrole

                                        @hasrole('Client')
                                            {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                                        @endrole
                                    </span>
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
                            <li class="nav-item dropdown pe-2 d-flex align-items-center" style="margin-top: 18px !important;">
                                <button class="btn btn-link text-white p-0 notif-btn" aria-expanded="false">
                                    <i class="fa fa-bell cursor-pointer"></i>
                                    <span class='badge badge-warning' id='lblCartCount'> 2 </span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container-fluid py-2">

                @yield('content')

            </div>

            @include('components.master.footer')
            <div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="modalSayaLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel">Notification</h5>
                            <span type="button" class="btnClose" style="font-size: 20px;">&times;</span>
                        </div>
                        <div class="modal-body">
                            <div class="box shadow-sm rounded bg-white mb-3">
                                <div class="box-body p-0">
                                    <div class="p-3 d-flex align-items-center osahan-post-header">
                                        <div class="font-weight-bold mr-3">
                                            <div class="mb-2">Curah hujan menurun !</div>
                                            <button type="button" class="btn btn-outline-success btn-sm">Cek Fields</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box shadow-sm rounded bg-white mb-3">
                                <div class="box-body p-0">
                                    <div class="p-3 d-flex align-items-center osahan-post-header">
                                        <div class="font-weight-bold mr-3">
                                            <div class="mb-2">Angin berhembus kencang !</div>
                                            <button type="button" class="btn btn-outline-success btn-sm">Cek Fields</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    </div>
    <script src="{{ asset('assets') }}/landing-page/js/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="{{ asset('assets') }}/js/core/popper.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets') }}/js/plugins/chartjs.min.js"></script>

    @stack('js')

    <script src="{{ asset('assets') }}/js/script.js"></script>
    <script>
        $('.notif-btn').click(function (){
            $("#notificationModal").modal("show")
        });

        $(".btnClose").click(function () {
            $("#notificationModal").modal("hide")
        })
    </script>

</body>

</html>
<style>
    .badge {
      padding-left: 9px;
      padding-right: 9px;
      -webkit-border-radius: 9px;
      -moz-border-radius: 9px;
      border-radius: 9px;
    }

    .label-warning[href],
    .badge-warning[href] {
      background-color: #c67605;
    }
    #lblCartCount {
        font-size: 12px;
        background: #ff0000;
        color: #fff;
        padding: 0 5px;
        vertical-align: top;
        margin-left: -10px;
    }
</style>
