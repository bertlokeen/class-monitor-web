<!doctype html>

<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Class Monitor') }}</title>

    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons"
    />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">

    <link href="{{ asset('css/material-dashboard.css') }}" rel="stylesheet" />

    <link href="{{ asset('assets/css/material-kit.min.css') }}" rel="stylesheet" />

    <link href="{{ asset('assets/css/Chart.min.css') }}" rel="stylesheet" />

    <style>
        .footer-bottom {
            color: white;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
        }

        .main {
            background-color: #eeeeee;
        }

        .reset-card-header {
            box-shadow: none !important;
            background: none !important;
            padding: 0 !important;
            margin-top: 0 !important;
        }

        .reset-card-footer {
            padding: 0 !important;
            padding-top: 10px !important;
        }
    </style>
</head>

<body>
    <div class="main">
    @include('partials.nav')
        <div class="main">
            <div class="container">
                <div class="row">
                    <h3>
                        @yield('breadcrumbs')
                    </h3>
                </div>
                <div class="row">
                    @yield('content')
                </div>
            </div>
        </div>

        <footer class="footer">
            <div class="container-fluid">
                <div class="copyright float-center">
                    © 2019 Class Monitor
                </div>
            </div>
        </footer>
    </div>


    <script src="{{ asset('assets/js/core/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/core/bootstrap-material-design.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/material-kit.js?v=2.0.5') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/Chart.min.js') }}" type="text/javascript"></script>
    @yield('js')
</body>

</html>