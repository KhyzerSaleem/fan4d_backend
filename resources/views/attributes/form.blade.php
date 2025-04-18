@extends('layouts.master')
@section('title')
    {{ $title }}
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
                                       {{ isset($category)  ? ($category->is_active ? 'checked' : '') : 'checked' }} type="checkbox"
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
                                           value="{{ isset($category) ? $category->title_ar : old('title_ar') }}"
                                           required>
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
                                           value="{{ isset($category) ? $category->title_en : old('title_en') }}"
                                           required>
                                    <div class="invalid-feedback">@lang('Please Enter a value')</div>
                                </div>

                                <!-- end row -->
                            </div>

                            <!-- end tab pane -->
                        </div>
                        <!-- end tab content -->
                        <div class="mb-3">
                            <label for="categories" class="form-label text-muted">اختر النوع</label>
                            <select class="form-control" id="type" name="type"
                                    required>
                                @foreach(\App\Models\Attribute::TYPE as $type)
                                    <option value="{{ $type }}"
                                            @if(isset($category) && $category->type ==$type ) selected @endif>{{ trans('lang.'.$type) }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                @lang('Please Choose a value')
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



    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>

@endsection

