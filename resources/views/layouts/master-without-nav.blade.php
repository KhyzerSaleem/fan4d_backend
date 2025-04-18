<!doctype html>
@php
    $dir = (app()->isLocale('ar')) ? 'rtl' : 'ltr';
@endphp

<html dir="{{ $dir }}" lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-topbar="light" data-sidebar-image="none">

    <head>
    <meta charset="utf-8" />
    <title>@yield('title') | {{ __('Low Calories - Dashboard') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="`TS`" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico')}}">
        @include('layouts.head-css')

    <style>
        .auth-one-bg {
            background-size: contain!important;
        }
    </style>
  </head>

<body>

    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg"  id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="#" class="d-inline-block auth-logo">
                                    <img src="{{ URL::asset('build/images/logo.png')}}" alt="" height="100">
{{--                                    <h1 style="color: white; font-weight: bolder">{{ __('FANN') }}</h1>--}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                    @yield('content')

                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">&copy; {{ date('Y') }} {{ __('Dashboard') }} . {{ __('Design & Develop by') }}
                                <i class="mdi mdi-heart text-danger"></i> Mo Nasser
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>

    @include('layouts.vendor-scripts')
    </body>
</html>
