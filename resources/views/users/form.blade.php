@extends('layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"
          type="text/css"/>
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/classic.min.css') }}"/>
    <link rel="stylesheet" href="{{ URL::asset('build/css/custom.css') }}"/>
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('Home')
        @endslot
        @slot('parent')
            <li class="breadcrumb-item"><a href="{{route('users.index')}}">العملاء</a></li>
        @endslot
        @slot('title')
            {{ $title }}
        @endslot
    @endcomponent
    <form id="my-form" autocomplete="off" class="needs-validation" method="post" action="{{ $route }}"
          enctype="multipart/form-data" novalidate>
        @csrf
        @isset($data)
            @method('PUT')
        @endisset
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title">بيانات العميل</h4>
                    </div>
                    <!-- end card header -->
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="manufacturer-name-input">الاسم</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="{{ isset($data) ? $data->name : old('name') }}" required>
                            <div class="invalid-feedback">@lang('Please Enter a value')</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="manufacturer-name-input">البريد الإلكتروني</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   value="{{ isset($data) ? $data->email : old('email') }}" required>
                            <div class="invalid-feedback">@lang('Please Enter a value')</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="manufacturer-name-input">رقم الهاتف</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                   value="{{ isset($data) ? $data->phone : old('phone') }}" required>
                            <div class="invalid-feedback">@lang('Please Enter a value')</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="manufacturer-name-input">الدولة</label>
                            <select id="city_id" class="js-example-basic-single" name="city_id" required>
                                @foreach(\App\Models\City::get() as $city)
                                    <option
                                        value="{{ $city->id }}"
                                        @if(isset($data)) @if($data->city_id == $city->id) selected @endif @endif >{{ $city->title }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">@lang('Please Enter a value')</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="manufacturer-name-input">خصم اضافي (%) </label>
                            <input type="number" step="any" min="0" max="100" class="form-control" id="discount"
                                   name="discount"
                                   value="{{ isset($data) ? $data->discount : old('discount') }}">
                            <div class="invalid-feedback">@lang('Please Enter a value')</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="manufacturer-name-input">كلمة المرور</label>
                            <input type="password" class="form-control" id="password"
                                   placeholder="@lang('translation.Enter Password')" name="password"
                                   @if(!isset($data)) required @endif >
                            <div class="invalid-feedback">@lang('Please Enter a value')</div>
                        </div>
                        <div class="mb-3">
                            <label for="userpassword">@lang('translation.Confirm Password')</label>
                            <input id="password-confirm" type="password" name="password_confirmation"
                                   class="form-control" @if(!isset($data)) required @endif
                                   placeholder="@lang('translation.Enter confirm password')">
                            <div class="invalid-feedback">@lang('translation.Please Enter a value')</div>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
                <div class="text-end mb-3">
                    <button type="submit" class="btn btn-success w-sm">@lang('Submit')</button>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </form>

@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!--select2 cdn-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ URL::asset('build/js/pages/select2.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/custom.js') }}"></script>
@endsection

