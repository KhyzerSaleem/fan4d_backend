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


    <form id="my-form" autocomplete="off" class="needs-validation" enctype="multipart/form-data" method="post" action="{{ $route }}" novalidate>
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0 flex-grow-1" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#arabic-data"
                                   role="tab">
                                    <img src="{{URL::asset('build/images/flags/sa.svg')}}" alt="user-image" class="me-2 rounded" height="18">
                                    <span class="align-middle">@lang('Arabic')</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#english-data"
                                   role="tab">
                                    <img src="{{ URL::asset('build/images/flags/us.svg') }}" alt="user-image" class="me-2 rounded" height="20">
                                    <span class="align-middle">@lang('English')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- end card header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="arabic-data" role="tabpanel">
                                @foreach($settings as $setting)
                                    @if (str_ends_with($setting->key,'_ar'))
                                        <div class="mb-3">
                                            <label class="form-label" for="{{ $setting->key }}">@lang($setting->key )</label>
                                            <input type="text" class="form-control" id="{{ $setting->key }}" name="{{ $setting->key }}"
                                                   placeholder="@lang('Enter') @lang($setting->key )" value="{{ isset($setting) ? $setting->value : old('value') }}" required>
                                            <div class="invalid-feedback">@lang('Please Enter a value')</div>
                                        </div>
                                    @endif
                                @endforeach
                                <!-- end row -->
                            </div>
                            <!-- end tab-pane -->

                            <div class="tab-pane" id="english-data" role="tabpanel">
                                @foreach($settings as $setting)
                                    @if (str_ends_with($setting->key,'_en'))
                                        <div class="mb-3">
                                            <label class="form-label" for="{{ $setting->key }}">@lang($setting->key)</label>
                                            <input type="text" class="form-control" id="{{ $setting->key }}" name="{{ $setting->key }}"
                                                   placeholder="@lang('Enter') @lang($setting->key )" value="{{ isset($setting) ? $setting->value : old('value') }}" required>
                                            <div class="invalid-feedback">@lang('Please Enter a value')</div>
                                        </div>
                                    @endif
                                @endforeach
                                <!-- end row -->
                            </div>
                            <!-- end tab pane -->
                        </div>
                        <!-- end tab content -->
                    </div>
                    <!-- end card body -->
                </div>
                <div class="card">

                    <!-- end card header -->
                    <div class="card-body">
                        <div class="row">
                            @foreach($settings as $setting)
                                @if (! str_ends_with($setting->key,'_ar') && ! str_ends_with($setting->key,'_en'))
                                    @empty($setting->image)
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="{{ $setting->key }}">@lang($setting->key)</label>
                                            <input type="text" class="form-control" id="{{ $setting->key }}" name="{{ $setting->key }}"
                                                   placeholder="@lang('Enter') @lang($setting->key )" value="{{ isset($setting) ? $setting->value : old('value') }}" required>
                                            <div class="invalid-feedback">@lang('Please Enter a value')</div>
                                        </div>
                                    @else
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="{{ $setting->key }}">@lang($setting->key)</label>
                                            <input name="{{ $setting->key }}" accept="image/*" type="file" id="{{ $setting->key }}" class="dropify" data-height="100" data-default-file="{{ $setting->image }}"/>
                                        </div>
                                    @endempty

                                @endif
                            @endforeach
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

    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>

    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>

    <script src="{{ URL::asset('build/js/app.js') }}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>

    <script>
        $('.dropify').dropify({
            messages: {
                'default': '{{ __('dropify_default') }}',
                'replace': '{{ __('dropify_replace') }}',
                'remove': '{{ __('dropify_remove') }}'
            }
        });
    </script>
@endsection

