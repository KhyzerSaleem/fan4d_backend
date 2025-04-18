@extends('layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" type="text/css" />

@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('translation.Home')
        @endslot
        @slot('parent')
            <li class="breadcrumb-item"><a href="{{route('admins.index')}}">المشرفين</a></li>
        @endslot
        @slot('title')
            {{ $title }}
        @endslot
    @endcomponent


    <form id="my-form" autocomplete="off" class="needs-validation" method="post" action="{{ $route }}" enctype="multipart/form-data" novalidate>
        @csrf
        @isset($admin)
            @method('PUT')
        @endisset
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">

                    </div>
                    <!-- end card header -->
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="name">اسم المشرف</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="@lang('translation.Enter Name')" value="{{ isset($admin) ? $admin->name : old('name') }}" required>
                            <div class="invalid-feedback">@lang('translation.Please Enter a value')</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="email">@lang('translation.Email')</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   placeholder="@lang('translation.Enter Email')" value="{{ isset($admin) ? $admin->email : old('email') }}" required>
                            <div class="invalid-feedback">@lang('translation.Please Enter a value')</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="phone">@lang('translation.Phone')</label>
                            <input type="tel" class="form-control" id="phone" name="phone"
                                   placeholder="@lang('translation.Enter Phone')" value="{{ isset($admin) ? $admin->phone : old('phone') }}" required>
                            <div class="invalid-feedback">@lang('translation.Please Enter a value')</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="phone">@lang('translation.Password')</label>
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="@lang('translation.Enter Password')" @if(!isset($admin)) required @endif>
                            <div class="invalid-feedback">@lang('translation.Please Enter a value')</div>
                        </div>
                        <div class="mb-3">
                            <label for="userpassword">@lang('translation.Confirm Password')</label>
                            <input id="password-confirm" type="password" name="password_confirmation" class="form-control"  @if(!isset($admin)) required @endif
                                   placeholder="@lang('translation.Enter confirm password')">
                            <div class="invalid-feedback">@lang('translation.Please Enter a value')</div>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
{{--            <div class="col-lg-4">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h5 class="card-title mb-0">@lang('translation.Roles & Permissions')</h5>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <label for="role_id" class="form-label">@lang('translation.Select Role')</label>--}}
{{--                        <select id="role_id" class="js-example-basic-single" name="role_id" required>--}}
{{--                            <option value="" selected disabled>@lang('translation.Select Role')</option>--}}
{{--                            <option>1</option>--}}
{{--                            <option>2</option>--}}
{{--                            <option>3</option>--}}
{{--                            <option>4</option>--}}
{{--                            @foreach($roles as $role)--}}
{{--                                <option value="{{ $role->id }}" {{ isset($admin) && $admin->roles()->first() && optional($admin->roles())->first()->id == $role->id  ? 'selected' : '' }}>{{ $role->{'display_name_'.app()->getLocale()} }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                        <div class="invalid-feedback">--}}
{{--                            @lang('translation.Please Choose a value')--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-3">--}}

{{--                    </div>--}}
{{--                    <!-- end card body -->--}}
{{--                </div>--}}
{{--                <!-- end card -->--}}
{{--            </div>--}}
            <!-- end col -->
        </div>
        <div class="text-end mb-3">
            <button type="submit" class="btn btn-success w-sm">@lang('translation.Submit')</button>
        </div>
        <!-- end row -->
    </form>

@endsection

@section('script')

    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!--select2 cdn-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ URL::asset('build/js/pages/select2.init.js') }}"></script>

    <script src="{{ URL::asset('build/js/app.js') }}"></script>


@endsection

