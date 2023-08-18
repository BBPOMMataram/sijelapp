<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SIJELAPP - BBPOM di Mataram</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet" />
    <!-- https://fonts.google.com/ -->
    <link href="{{ asset('vendor/front/css/bootstrap.min.css') }}" rel="stylesheet" />
    <!-- https://getbootstrap.com/ -->
    <link href="{{ asset('vendor/front/fontawesome/css/all.min.css') }}" rel="stylesheet" />
    <!-- https://fontawesome.com/ -->
    <link href="{{ asset('vendor/front/css/style.css') }}" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tippy.js/6.3.3/themes/light.min.css"
        integrity="sha512-zpbTFOStBclqD3+SaV5Uz1WAKh9d2/vOtaFYpSLkosymyJKnO+M4vu2CK2U4ZjkRCJ7+RvLnISpNrCfJki5JXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/animations/scale.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/dt/dt-1.11.3/r-2.2.9/sl-1.3.3/datatables.min.css" />
    <link rel="stylesheet" href="{{ asset('vendor/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    @stack('styles')

    {{-- HAPUS NANTI --}}
    <style>
        #logo_78 img {
            position: fixed;
            right: 100px;
            top: 50px;
            border-radius: 100%;
            border: 2px solid red;
            z-index: 99;
        }
    </style>
</head>

<body id="modal-open">
    {{-- HAPUS NANTI --}}
    <div id="logo_78">
        <img src="logo_78.gif" alt="logo 78" width="100px" height="100px">
    </div>
    <div class="tm-container">
        <div>
            <div class="tm-row pt-4">
                <div class="tm-col-left">
                    <div class="tm-site-header media">
                        <i class="mt-1 tm-logo">
                            <a href="admin"><img src="{{ Storage::url('logo.png') }}" alt="logo bpom" width="80px"></a>
                        </i>
                        <div class="media-body">
                            <h1 class="tm-sitename text-uppercase mb-0" style="-webkit-text-stroke:.5px #99cccc">
                                SIJELAPP</h1>
                            <p class="tm-slogon" style="-webkit-text-stroke:.1px #99cccc">Sistem Jejak Telusur Laporan
                                Pengujian Pihak Ketiga</p>
                        </div>
                    </div>
                </div>
                <div class="tm-col-right">
                    <nav class="navbar navbar-expand-lg" id="tm-main-nav">
                        <button class="navbar-toggler toggler-example mr-0 ml-auto" type="button" data-toggle="collapse"
                            data-target="#navbar-nav" aria-controls="navbar-nav" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <span><i class="fas fa-bars"></i></span>
                        </button>
                        <div class="collapse navbar-collapse tm-nav" id="navbar-nav">
                            <ul class="navbar-nav text-uppercase">
                                <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                                    <a class="nav-link tm-nav-link" href="{{ route('home') }}">Tracking Sampel <span
                                            class="sr-only">(current)</span></a>
                                </li>
                                <li class="nav-item {{ Request::is('tarif') ? 'active' : '' }}">
                                    <a class="nav-link tm-nav-link" href="{{ route('tarifpengujian') }}">Biaya
                                        Pengujian</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            @yield('content')
        </div>

        <div class="tm-row">
            <div class="tm-col-left text-center">
                <ul class="tm-bg-controls-wrapper">
                    <li class="tm-bg-control active" data-id="0"></li>
                    <li class="tm-bg-control" data-id="1"></li>
                    <li class="tm-bg-control" data-id="2"></li>
                    <li class="tm-bg-control" data-id="3"></li>
                </ul>
            </div>
            <div class="tm-col-right tm-col-footer">
                <footer class="tm-site-footer text-right">
                    <p class="mb-0">Copyright 2021 {{ now()->year == "2021" ? "" : " - " . now()->year }} <a
                            rel="nofollow" target="_parent" href="https://mataram.pom.go.id" class="tm-text-link"
                            style="color: #99cccc">BBPOM
                            di Mataram</a></p>
                </footer>
            </div>
        </div>

        <!-- Diagonal background design -->
        <div class="tm-bg">
            <div class="tm-bg-left"></div>
            <div class="tm-bg-right"></div>
        </div>
    </div>
    <script src="{{ asset('vendor/front/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('vendor/front/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/front/js/jquery.backstretch.min.js') }}"></script>
    <script src="{{ asset('vendor/front/js/script.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/r-2.2.9/sl-1.3.3/datatables.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    <script src="{{ asset('vendor/admin/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    @stack('scripts')
</body>

</html>