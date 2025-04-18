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
                                    <h5 class="text-primary">@lang('translation.Forgot Password?')</h5>
                                    <p class="text-muted">@lang('translation.Reset password with')@lang('translation.Yamluck')</p>


                                    <lord-icon src="https://cdn.lordicon.com/rhvddzym.json" trigger="loop"
                                               colors="primary:#0ab39c" class="avatar-xl">
                                    </lord-icon>
                                </div>


                                <div class="alert alert-borderless alert-warning text-center mb-2 mx-2" role="alert">
                                    @lang('translation.Enter your email and instructions will be sent to you!')
                                </div>
                                <div class="p-2">
                                    @if (session('status'))
                                        <div class="alert alert-success text-center mb-4" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="useremail" class="form-label">@lang('translation.Email')</label>
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                name="email" placeholder="@lang('translation.Enter email')" value="{{ old('email') }}"
                                                id="email">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="text-end">
                                            <button class="btn btn-primary w-md waves-effect waves-light"
                                                type="submit">@lang('translation.Send')</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="mt-4 text-center">
                            <p class="mb-0">@lang('translation.Wait, I remember my password...') <a href="{{ route('login') }}"
                                    class="fw-semibold text-primary text-decoration-underline"> @lang('translation.Click here') </a> </p>
                        </div>

                    </div>
                </div>

@endsection
