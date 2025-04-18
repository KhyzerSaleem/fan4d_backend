@php
    $rtlSuffix = (app()->isLocale('ar')) ? '.rtl' : '';
@endphp
@yield('css')
<!-- Layout config Js -->
<link href="{{ URL::asset('build/css/style.css') }}" id="app-style" rel="stylesheet" type="text/css" />
<script src="{{ URL::asset('build/js/layout.js') }}"></script>

<!-- Bootstrap Css -->
<link href="{{ URL::asset("build/css/bootstrap.min{$rtlSuffix}.css") }}" id="bootstrap-style" rel="stylesheet" type="text/css" />

<!-- Icons Css -->
<link href="{{ URL::asset('build/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

<!-- App Css-->
<link href="{{ URL::asset("build/css/app.min{$rtlSuffix}.css") }}" id="app-style" rel="stylesheet" type="text/css" />

<!-- custom Css-->
<link href="{{ URL::asset('build/css/custom.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

<!-- style Css-->
<link href="{{ URL::asset('build/css/style.css') }}" id="app-style" rel="stylesheet" type="text/css" />

{{-- @yield('css') --}}

<style>

    {{-- to make submit button away of cusom theme button --}}
    .text-end button[type="submit"] {
        margin-{{ (app()->isLocale('ar')) ? 'left' : 'right' }}: 50px;
    }

    {{-- to make all inputs content localized --}}
    input {
        text-align: {{ (app()->isLocale('ar')) ? 'right' : 'left' }};
    }
</style>
