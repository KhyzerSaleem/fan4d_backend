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
        @slot('title')
            {{ $title }}
        @endslot
    @endcomponent


    <form id="my-form" autocomplete="off" class="needs-validation" method="post" action="{{ $route }}" enctype="multipart/form-data" novalidate>
        @csrf
        @isset($voucher)
            @method('PUT')
        @endisset
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
                            <div class="form-check form-switch form-switch-right form-switch-md">
                                <label for="input-group-showcode" class="form-label text-muted">
                                    @lang('is_active')
                                </label>
                                <input class="form-check-input" name="is_active" value="1"
                                       {{ isset($voucher)  ? ($voucher->is_active ? 'checked' : '') : 'checked' }} type="checkbox"
                                       id="input-group-showcode">
                            </div>
                        </div>
                    </div>
                    <!-- end card header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane mb-3 active" id="arabic-data" role="tabpanel">
                                <div class="mb-3">
                                    <label class="form-label" for="manufacturer-name-input">@lang('Title Ar')</label>
                                    <input type="text" class="form-control" id="title_ar" name="title_ar"
                                           placeholder="@lang('Enter Title Ar')"
                                           value="{{ isset($voucher) ? $voucher->title_ar : old('title_ar') }}"
                                           required>
                                    <div class="invalid-feedback">@lang('Please Enter a value')</div>
                                </div>
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label"--}}
{{--                                           for="manufacturer-name-input">@lang('Description Ar')</label>--}}
{{--                                    <textarea type="text" class="form-control" id="desc_ar"--}}
{{--                                              name="desc_ar">{{ isset($voucher) ? $voucher->desc_ar : old('desc_ar') }}</textarea>--}}
{{--                                    <div class="invalid-feedback">@lang('Please Enter a value')</div>--}}
{{--                                </div>--}}
                                <!-- end row -->
                            </div>
                            <!-- end tab-pane -->

                            <div class="tab-pane mb-3" id="english-data" role="tabpanel">
                                <div class="mb-3">
                                    <label class="form-label" for="manufacturer-name-input">@lang('Title En')</label>
                                    <input type="text" class="form-control" id="title_en" name="title_en"
                                           placeholder="@lang('Enter Title En')"
                                           value="{{ isset($voucher) ? $voucher->title_en : old('title_en') }}"
                                           required>
                                    <div class="invalid-feedback">@lang('Please Enter a value')</div>
                                </div>
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label"--}}
{{--                                           for="manufacturer-name-input">@lang('Description En')</label>--}}
{{--                                    <textarea type="text" class="form-control" id="desc_en"--}}
{{--                                              name="desc_en">{{ isset($voucher) ? $voucher->desc_en : old('desc_en') }}</textarea>--}}
{{--                                    <div class="invalid-feedback">@lang('Please Enter a value')</div>--}}
{{--                                </div>--}}
                                <!-- end row -->
                            </div>

                            <!-- end tab pane -->
                        </div>
{{--                        <div class="mb-3">--}}
{{--                            <label class="form-label" for="project-thumbnail-img">@lang('Main image')</label>--}}
{{--                            <input name="image" accept="image/*" type="file" class="dropify" data-height="100"--}}
{{--                                   @isset($voucher) data-default-file="{{ $voucher->image }}" @endisset/>--}}
{{--                        </div>--}}
                        <!-- end tab content -->
                    </div>
                    <!-- end card body -->

                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <!-- end card header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="mb-3">
                                <label class="form-label" for="code">@lang('Voucher Code')</label>
                                <input type="text" class="form-control" id="code" name="code"
                                       placeholder="@lang('Please Enter a value')" value="{{ isset($voucher) ? $voucher->code : old('code') }}" required>
                                <div class="invalid-feedback">@lang('Please Enter a valid value')</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">@lang('Start Date')</label>
                                <input type="text" class="form-control datepickr start_date" name="start_date" value="{{ isset($voucher) ? $voucher->start_date : old('start_date') }}" data-provider="flatpickr"
                                       data-date-format="Y-m-d">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">@lang('Expire Date')</label>
                                <input type="text" class="form-control datepickr expire_date" name="expire_date" value="{{ isset($voucher) ? $voucher->expire_date : old('expire_date') }}" data-provider="flatpickr"
                                       data-date-format="Y-m-d">
                            </div>
                            <input type="hidden" name="user_use_count" value="{{ isset($voucher) ? $voucher->user_use_count : 1 }}" >
{{--                            <div class="mb-3">--}}
{{--                                <label class="form-label" for="user_use_count">@lang('User Use Count')</label>--}}
{{--                                <input type="number" step="1" min="1" class="form-control" id="user_use_count" name="user_use_count"--}}
{{--                                       placeholder="@lang('Please Enter a number')" value="{{ isset($voucher) ? $voucher->user_use_count : old('user_use_count') }}" required>--}}
{{--                                <div class="invalid-feedback">@lang('Please Enter a valid value')</div>--}}
{{--                            </div>--}}
                            <div class="mb-3">
                                <label class="form-label" for="use_count">@lang('Use Count')</label>
                                <input type="number" step="1" min="1" class="form-control" id="use_count" name="use_count"
                                       placeholder="@lang('Please Enter a number')" value="{{ isset($voucher) ? $voucher->use_count : old('use_count') }}" required>
                                <div class="invalid-feedback">@lang('Please Enter a valid value')</div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="percent">@lang('Percent')</label>
                                <input type="number" step="1" min="1" max="100" class="form-control" id="percent" name="percent"
                                       placeholder="@lang('Please Enter a number')" value="{{ isset($voucher) ? $voucher->percent : old('percent') }}" required>
                                <div class="invalid-feedback">@lang('Please Enter a valid value')</div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="percent">اقل قيمة للطلب لتفعيل الخصم</label>
                                <input type="number" step="any" min="0" class="form-control" id="min_order_price" name="min_order_price"
                                        value="{{ isset($voucher) ? $voucher->min_order_price : old('min_order_price') }}" required>
                                <div class="invalid-feedback">@lang('Please Enter a valid value')</div>
                            </div>
{{--                            <div class="form-check form-switch form-switch-right form-switch-md mb-3">--}}
{{--                                <label class="form-label" for="percent">@lang('For First Order')</label>--}}
{{--                                <input class="form-check-input" name="for_first_order" value="1" {{ isset($voucher)  ? ($voucher->for_first_order ? 'checked' : '') : '' }} type="checkbox" id="input-group-showcode">--}}
{{--                                <div class="invalid-feedback">@lang('Please Enter a valid value')</div>--}}
{{--                            </div>--}}
                            <!-- end tab pane -->
                        </div>
                        <!-- end tab content -->
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

    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>

    <!--select2 cdn-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{--    <script src="{{ URL::asset('build/js/pages/select2.init.js') }}"></script>--}}

    <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
    {{--    <script src="{{ URL::asset('build/js/pages/ecommerce-product-create.init.js') }}"></script>--}}


    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/i18n/ar.js"></script>


    <script>
        const date = new Date();
        const locale = "{{ app()->getLocale() }}";

        const currentDay = date.getDate();
        const currentMonth = date.getMonth() + 1;
        const currentYear = date.getFullYear();

        let defaultStartDate = ['"'+currentYear+"-"+currentMonth+"-"+currentDay];
        let defaultExpireDate = ['"'+currentYear+"-"+currentMonth+"-"+currentDay];
        @isset($voucher)
            defaultStartDate = ['{{ \Carbon\Carbon::parse($voucher->start_date)->format('Y-m-d') }}'];
            defaultExpireDate = ['{{ \Carbon\Carbon::parse($voucher->expire_date)->format('Y-m-d') }}'];
        @endisset

        flatpickr('.start_date', {
            mode: 'single',
            locale: locale,
            defaultDate: defaultStartDate,
        });

        flatpickr('.expire_date', {
            mode: 'single',
            locale: locale,
            defaultDate: defaultExpireDate,
        });
    </script>
    <script>
        $('.dropify').dropify({
            messages: {
                'default': '{{ __('dropify_default') }}',
                'replace': '{{ __('dropify_replace') }}',
                'remove': '{{ __('dropify_remove') }}'
            }
        });

        {{--var productExists = {{ isset($voucher) ? 'true' : 'false' }};--}}
        {{--if (!productExists) {--}}
        {{--    $('#my-form').submit(function (event) {--}}
        {{--        // validate image--}}
        {{--        if (!$('.dropify').val()) {--}}
        {{--            event.preventDefault();--}}
        {{--            tostify('{{ __('please choose an image') }}', "danger")--}}
        {{--        }--}}
        {{--    })--}}
        {{--}--}}


    </script>

    <script>
        // Dropzone
        var dropzonePreviewNode = document.querySelector("#dropzone-preview-list");
        dropzonePreviewNode.itemid = "";
        var previewTemplate = dropzonePreviewNode.parentNode.innerHTML;
        dropzonePreviewNode.parentNode.removeChild(dropzonePreviewNode);
        var dropzone = new Dropzone(".dropzone", {
            paramName: 'image',
            url: '{{ route('products.uploadGallery') }}',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            method: "post",
            previewTemplate: previewTemplate,
            previewsContainer: "#dropzone-preview",
            maxFilesize: 10,
            maxFiles: 10,
            // addRemoveLinks: true,
            acceptedFiles: 'image/*',
            success: function (file, response) {
                // Check if the upload was successful
                if (response && response.success && response.fileName) {
                    var imageName = response.fileName;
                    console.log("Image uploaded successfully. Name: " + imageName);

                    // Get the hidden input element
                    var hiddenInput = document.getElementById('imageNames');

                    hiddenInput.value += imageName + ',';
                } else {
                    console.error("Error uploading image.");
                }
            },
            error: function (file, errorMessage, xhr) {
                console.error("Error uploading image: " + errorMessage);
            }

        });
    </script>
@endsection

