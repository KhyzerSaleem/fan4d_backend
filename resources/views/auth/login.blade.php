@extends('layouts.master-without-nav')
@section('title')
@lang('signin')
@endsection
@section('content')

    <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4">

                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">@lang('Welcome Back !')</h5>
                                <p class="text-muted">@lang('Sign in to continue.')</p>
                            </div>
                            <div class="p-2 mt-4">
                                <form action="{{ route('login') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="username" class="form-label">@lang('Email') <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="@lang('Enter Email')" value="">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
{{--                                        <div class="float-end">--}}
{{--                                            <a href="{{ route('password.update') }}" class="text-muted">@lang('Forgot password?')</a>--}}
{{--                                        </div>--}}
                                        <label class="form-label" for="password-input">@lang('Password') <span class="text-danger">*</span></label>
                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                            <input type="password" class="form-control password-input pe-5 @error('password') is-invalid @enderror" name="password" placeholder="@lang('Enter password')" id="password-input" value="">
                                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" value="1" id="auth-remember-check">
                                        <label class="form-check-label" for="auth-remember-check">@lang('Remember me')</label>
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-primary w-100" type="submit">@lang('Sign In')</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->

{{--                    <div class="mt-4 text-center">--}}
{{--                        <p class="mb-0">@lang('Don\'t have an account ?') <a href="{{ route('register') }}" class="fw-semibold text-primary text-decoration-underline"> @lang('Signup') </a> </p>--}}
{{--                    </div>--}}

                </div>
            </div>

@endsection
@section('script')
<script src="{{ URL::asset('build/libs/particles.js/particles.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/particles.app.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/password-addon.init.js') }}"></script>

@endsection
