@extends('layouts.master-without-nav')
@section('title')
    @lang('translation.password-reset')
@endsection
@section('content')

    <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">

                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">@lang('translation.Reset Password?')</h5>
                                    <p class="text-muted">@lang('translation.Reset password with')@lang('translation.Yamluck')</p>

                                    <lord-icon src="https://cdn.lordicon.com/dklbhvrt.json" trigger="loop"
                                        colors="primary:#0ab39c" class="avatar-xl">
                                    </lord-icon>

                                </div>

{{--                                <div class="alert border-0 alert-warning text-center mb-2 mx-2" role="alert">--}}
{{--                                    Enter your email and instructions will be sent to you!--}}
{{--                                </div>--}}
                                <div class="p-2">
                                    <form class="form-horizontal" method="POST" action="{{ route('password.update') }}">
                                        @csrf
                                        <input type="hidden" name="token" value="{{ $token }}">
                                        <div class="mb-3">
                                            <label for="useremail" class="form-label">@lang('translation.Email')</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="@lang('translation.Enter email')" value="{{ $email ?? old('email') }}" id="email">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="userpassword">@lang('translation.Password')</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="userpassword" placeholder="@lang('translation.Enter password')">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="userpassword">@lang('translation.Confirm Password')</label>
                                            <input id="password-confirm" type="password" name="password_confirmation" class="form-control" placeholder="@lang('translation.Enter confirm password')">
                                        </div>

                                        <div class="text-end">
                                            <button class="btn btn-primary w-md waves-effect waves-light" type="submit">@lang('translation.Reset')</button>
                                        </div>

                                    </form><!-- end form -->
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                    </div>
                </div>

@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/particles.js/particles.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/particles.app.js') }}"></script>
@endsection
