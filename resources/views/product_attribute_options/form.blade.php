@extends('layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('css')
    <link href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

    <style>
        .img-fluid {
            width: 100% !important;
            height: 100% !important;
        }

        .select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__choice__remove {
            position: static;
        }
    </style>
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('Home')
        @endslot
        @slot('parent')
            <li class="breadcrumb-item"><a href="{{route('products.index')}}">@lang('Products')</a></li>
            <li class="breadcrumb-item"><a
                    href="{{route('product_attributes.index',['id'=>$product_id])}}">@lang('product_attributes')</a>
            </li>
            <li class="breadcrumb-item"><a
                    href="{{route('product_attribute_options.index',['id'=>$id])}}">@lang('product_attribute_options')</a>
            </li>
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
        <input type="hidden" name="product_attribute_id" value="{{$id}}" required>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0 flex-grow-1" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#arabic-data"
                                   role="tab">
                                    <img src="{{URL::asset('build/images/flags/sa.svg')}}" alt="user-image"
                                         class="me-2 rounded" height="18">
                                    <span class="align-middle">@lang('Arabic')</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#english-data"
                                   role="tab">
                                    <img src="{{ URL::asset('build/images/flags/us.svg') }}" alt="user-image"
                                         class="me-2 rounded" height="20">
                                    <span class="align-middle">@lang('English')</span>
                                </a>
                            </li>
                        </ul>
                        <div class="flex-shrink-0">
                            {{--                            <div class="form-check form-switch form-switch-right form-switch-md">--}}
                            {{--                                <label for="input-group-showcode" class="form-label text-muted">--}}
                            {{--                                    @lang('is_active')--}}
                            {{--                                </label>--}}
                            {{--                                <input class="form-check-input" name="is_active" value="1"--}}
                            {{--                                       {{ isset($data)  ? ($data->is_active ? 'checked' : '') : 'checked' }} type="checkbox"--}}
                            {{--                                       id="input-group-showcode">--}}
                            {{--                            </div>--}}
                        </div>
                    </div>
                    <!-- end card header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane mb-3 active" id="arabic-data" role="tabpanel">
                                <div class="mb-3">
                                    <label class="form-label required"
                                           for="manufacturer-name-input">@lang('Title Ar')</label>
                                    <input type="text" class="form-control" id="title_ar" name="title_ar"
                                           placeholder="@lang('Enter Title Ar')"
                                           value="{{ isset($data) ? $data->title_ar : old('title_ar') }}"
                                           required>
                                    <div class="invalid-feedback">@lang('Please Enter a value')</div>
                                </div>
                                <!-- end row -->
                            </div>
                            <!-- end tab-pane -->

                            <div class="tab-pane mb-3" id="english-data" role="tabpanel">
                                <div class="mb-3">
                                    <label class="form-label required "
                                           for="manufacturer-name-input">@lang('Title En')</label>
                                    <input type="text" class="form-control" id="title_en" name="title_en"
                                           placeholder="@lang('Enter Title En')"
                                           value="{{ isset($data) ? $data->title_en : old('title_en') }}"
                                           required>
                                    <div class="invalid-feedback">@lang('Please Enter a value')</div>
                                </div>

                                <!-- end row -->
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="percent">@lang('Price')</label>
                                    <input type="number" step="any" min="0" class="form-control" id="price"
                                           name="price"
                                           placeholder="@lang('Please Enter a number')"
                                           value="{{ isset($data) ? $data->price : old('price') }}" required>
                                    <div class="invalid-feedback">@lang('Please Enter a valid value')</div>
                                </div>
                            </div>
                            @if($have_image)
                                <div class="mb-3">
                                    <label class="form-label" for="project-thumbnail-img">@lang('Image')</label>
                                    <input name="image" accept="image/*" type="file" class="dropify" data-height="100" required
                                           data-required="true"
                                           @isset($data) data-default-file="{{ $data->image }}" @endisset/>
                                </div>
                            @endif
                        </div>
                        <!-- end tab content -->
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>

            <div class="text-end mb-3">
                <button type="submit" class="btn btn-success w-sm">@lang('Submit')</button>
            </div>
        </div>
        <!-- end row -->
    </form>

@endsection

@section('script')
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>

    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
    <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
    <script>
        $('.dropify').dropify({
            messages: {
                'default': '{{ __('dropify_default') }}',
                'replace': '{{ __('dropify_replace') }}',
                'remove': '{{ __('dropify_remove') }}'
            }
        });
        if ({{$have_image}}) {
            $('#my-form').submit(function (event) {
// validate image
                if (!$('.dropify').val()) {
                    event.preventDefault();
                    tostify('{{ __('please choose an image') }}', "danger")
                }
            })
        }

    </script>
@endsection

