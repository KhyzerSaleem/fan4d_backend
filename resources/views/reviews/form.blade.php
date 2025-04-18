@extends('layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"
          type="text/css"/>
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/classic.min.css') }}"/>
    <link rel="stylesheet" href="{{ URL::asset('build/css/custom.css') }}"/>

    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('translation.Home')
        @endslot
        @slot('title')
            {{ $title }}
        @endslot
    @endcomponent


    <form id="my-form" autocomplete="off" class="needs-validation" enctype="multipart/form-data" method="post"
          action="{{ $route }}" novalidate>
        @csrf
        @isset($slider)
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
                                    @lang('translation.is_active')
                                </label>
                                <input class="form-check-input" name="is_active" value="1"
                                       {{ isset($slider)  ? ($slider->is_active ? 'checked' : '') : 'checked' }} type="checkbox"
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
                                           value="{{ isset($slider) ? $slider->title_ar : old('title_ar') }}"
                                           required>
                                    <div class="invalid-feedback">@lang('Please Enter a value')</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="manufacturer-name-input">@lang('job_name_ar')</label>
                                    <input type="text" class="form-control" id="job_name_ar" name="job_name_ar"
                                           placeholder="@lang('Enter Title Ar')"
                                           value="{{ isset($slider) ? $slider->job_name_ar : old('job_name_ar') }}"
                                           required>
                                    <div class="invalid-feedback">@lang('Please Enter a value')</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"
                                           for="manufacturer-name-input">@lang('Description Ar')</label>
                                    <textarea type="text" class="form-control" id="desc_ar"
                                              name="desc_ar">{{ isset($slider) ? $slider->desc_ar : old('desc_ar') }}</textarea>
                                    <div class="invalid-feedback">@lang('Please Enter a value')</div>
                                </div>
                                <!-- end row -->
                            </div>
                            <!-- end tab-pane -->

                            <div class="tab-pane mb-3" id="english-data" role="tabpanel">
                                <div class="mb-3">
                                    <label class="form-label" for="manufacturer-name-input">@lang('Title En')</label>
                                    <input type="text" class="form-control" id="title_en" name="title_en"
                                           placeholder="@lang('Enter Title En')"
                                           value="{{ isset($slider) ? $slider->title_en : old('title_en') }}"
                                           required>
                                    <div class="invalid-feedback">@lang('Please Enter a value')</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="manufacturer-name-input">@lang('job_name_en')</label>
                                    <input type="text" class="form-control" id="job_name_en" name="job_name_en"
                                           placeholder="@lang('Enter Title Ar')"
                                           value="{{ isset($slider) ? $slider->job_name_en : old('job_name_en') }}"
                                           required>
                                    <div class="invalid-feedback">@lang('Please Enter a value')</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"
                                           for="manufacturer-name-input">@lang('Description En')</label>
                                    <textarea type="text" class="form-control" id="desc_en"
                                              name="desc_en">{{ isset($slider) ? $slider->desc_en : old('desc_en') }}</textarea>
                                    <div class="invalid-feedback">@lang('Please Enter a value')</div>
                                </div>
                                <!-- end row -->
                            </div>

                            <!-- end tab pane -->
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="project-thumbnail-img">@lang('Image')</label>
                            <input name="image" accept="image/*" type="file" class="dropify" data-height="100"
                                   @isset($slider) data-default-file="{{ $slider->image }}" @endisset/>
                        </div>
                        <!-- end tab pane -->

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

    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>

    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>

    <script src="{{ URL::asset('build/js/app.js') }}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!--select2 cdn-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ URL::asset('build/js/pages/select2.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/custom.js') }}"></script>

    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>

    <script>
        $('.dropify').dropify({
            messages: {
                'default': '{{ __('dropify_default') }}',
                'replace': '{{ __('dropify_replace') }}',
                'remove': '{{ __('dropify_remove') }}'
            }
        });

        var sliderExists = {{ isset($slider) ? 'true' : 'false' }};
        if (!sliderExists) {
            $('#my-form').submit(function (event) {
                // validate image
                if (!$('.dropify').val()) {
                    event.preventDefault();
                    tostify('{{ __('please choose an image') }}', "danger")
                }
            })
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let type = $('#type').val();
            if (type == 'url') {
                $('#urlDiv').css('display', 'block');
            } else if (type == 'product') {
                $('#productDiv').css('display', 'block');
            } else if (type == 'service') {
                $('#serviceDiv').css('display', 'block');
            }
        });
    </script>

    <script>
        $('#type').change(function (e) {
            let type = $(this).val();

            // Hide all divs initially
            $('#urlDiv, #productDiv, #serviceDiv').css('display', 'none');
            $('#url, #product_id, #service_id').prop('disabled', true);
            $('#url, #product_id, #service_id').prop('required', false);

            if (type == 'url') {
                $('#urlDiv').css('display', 'block');
                $('#url').prop('disabled', false);
                $('#url').prop('required', true);
            } else if (type == 'product') {
                $('#productDiv').css('display', 'block');
                $('#product_id').prop('disabled', false);
                $('#product_id').prop('required', true);
            } else if (type == 'service') {
                $('#serviceDiv').css('display', 'block');
                $('#service_id').prop('disabled', false);
                $('#service_id').prop('required', true);
            }
        });
    </script>

@endsection

