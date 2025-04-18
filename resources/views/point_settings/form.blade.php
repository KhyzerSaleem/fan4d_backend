@extends('layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('Home')
        @endslot
        @slot('title')
            {{ $title }}
        @endslot
    @endcomponent


    <form id="my-form" autocomplete="off" class="needs-validation" method="post" action="{{ $route }}"
          enctype="multipart/form-data" novalidate>
        @csrf
        @isset($category)
            @method('PUT')
        @endisset
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body">
                        {{--                        <div class="row">--}}
                        {{--                            <div class="col-md-3">--}}
                        {{--                                <div class="mb-3">--}}
                        {{--                                    <label class="form-label" for="manufacturer-name-input">النقاط</label>--}}
                        {{--                                    <input type="text" min="0" class="form-control" id="key" name="points"--}}
                        {{--                                           value="{{ isset($data) ? $data->points : old('key') }}" required>--}}
                        {{--                                    <div class="invalid-feedback">@lang('Please Enter a value')</div>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                            <div class="col-md-1">--}}
                        {{--                                <div class="mb-3">--}}
                        {{--                                <span>--}}

                        {{--                                <i class="ri-arrow-left-fill"></i>--}}
                        {{--                                </span>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                            <div class="col-md-3">--}}
                        {{--                                <div class="mb-3">--}}
                        {{--                                    <label class="form-label" for="manufacturer-name-input">المبلغ (ريال سعودي)</label>--}}
                        {{--                                    <input type="text" step="any" min="0" class="form-control" id="money" name="money"--}}
                        {{--                                           value="{{ isset($data) ? $data->money : old('money') }}" required>--}}
                        {{--                                    <div class="invalid-feedback">@lang('Please Enter a value')</div>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        <div class="formCost d-flex gap-2 align-items-center mt-3">

                            {{--                            <span class="fw-semibold text-muted"> <i class="ri-arrow-left-fill"></i></span>--}}

                        </div>
                        <h3>عند تحويل مبلغ الطلب الى نقاط في محفظه العميل</h3>
                        <div class="formCost d-flex gap-2 align-items-center mt-3">
                            <div>
                                <label class="form-label" for="manufacturer-name-input">المبلغ (ريال سعودي)</label>

                                <input class="form-control form-control-lg" required type="number" min="0"
                                       id="order_money" value="{{$data['order_money']}}" name="order_money">
                            </div>
                            <span style="padding-top: 24px;    font-size: -webkit-xxx-large; "
                                  class="fw-semibold text-muted"> <i class="ri-arrow-left-fill"></i></span>
                            <div>
                                <label class="form-label" for="manufacturer-name-input">النقاط</label>
                                <input class="form-control form-control-lg" required type="number" step="any" min="0"
                                       id="order_points" value="{{$data['order_points']}}" name="order_points">
                            </div>
                        </div>

                        <h3>عند تحويل النقاط الى مبلغ للاستخدام</h3>
                        <div class="formCost d-flex gap-2 align-items-center mt-3">
                            <div>
                                <label class="form-label" for="manufacturer-name-input">النقاط</label>
                                <input class="form-control form-control-lg" required type="number" min="0"
                                       id="reward_points" value="{{$data['reward_points']}}" name="reward_points">
                            </div>
                            <span style="padding-top: 24px;    font-size: -webkit-xxx-large; "
                                  class="fw-semibold text-muted"> <i class="ri-arrow-left-fill"></i></span>
                            <div>
                                <label class="form-label" for="manufacturer-name-input">المبلغ (ريال سعودي)</label>
                                <input class="form-control form-control-lg" required type="number" step="any" min="0"
                                       id="reward_money" value="{{$data['reward_money']}}" name="reward_money">
                            </div>
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
    <script src="{{ URL::asset('build/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>

    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>

    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>

    <script src="{{ URL::asset('build/js/app.js') }}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

@endsection

