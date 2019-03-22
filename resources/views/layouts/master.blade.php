<!doctype html>

<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Class Monitor') }}</title>

    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">

    <link href="{{ asset('assets/css/material-kit.min.css') }}" rel="stylesheet"/>

    <style>
        .page-bg {
            background-image: url({{ asset('assets/img/university.jpg') }});
            background-size: cover;
            background-position: top center;
        }

        .footer-bottom {
            color: white;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
        }
    </style>
</head>

<body>
<div class="page-header header-filter purple-filter page-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="card card-login">
                    <form class="form" method="" action="">
                        <div class="card-header card-header-warning text-center">
                            <h4 class="card-title">Login</h4>
                        </div>
                        <div class="card-body">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="material-icons">mail</i>
                                    </span>
                                </div>
                                <input type="email" class="form-control" placeholder="Email...">
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="material-icons">lock_outline</i>
                                    </span>
                                </div>
                                <input type="password" class="form-control" placeholder="Password...">
                            </div>
                        </div>
                        <div class="footer text-center">
                            <a href="#">Forgot password?</a>
                        </div>
                        <div class="footer text-center">
                            <button class="btn btn-warning">Sign In</button>
                            <button class="btn btn-warning">Sign Up</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer-bottom">
        <div class="container">
            <div class="copyright">
                &copy;
                <script>
                    document.write(new Date().getFullYear())
                </script> Class Monitor
            </div>
        </div>
    </footer>
</div>

<script src="{{ asset('assets/js/core/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/core/popper.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/core/bootstrap-material-design.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/plugins/nouislider.min.js') }}" type="text/javascript"></script>
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="{{ asset('assets/js/material-kit.js?v=2.0.5') }}" type="text/javascript"></script>

</body>

</html>
