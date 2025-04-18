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
            @lang('translation.Home')
        @endslot
        @slot('title')
            {{ $title }}
        @endslot
    @endcomponent


    <form id="my-form" autocomplete="off" class="needs-validation" method="post" action="{{ $route }}" enctype="multipart/form-data" novalidate>
        @csrf
        @isset($role)
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
                                    <img src="{{URL::asset('build/images/flags/sa.svg')}}" alt="user-image" class="me-2 rounded" height="18">
                                    <span class="align-middle">@lang('translation.Arabic')</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#english-data"
                                   role="tab">
                                    <img src="{{ URL::asset('build/images/flags/us.svg') }}" alt="user-image" class="me-2 rounded" height="20">
                                    <span class="align-middle">@lang('translation.English')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- end card header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane mb-3 active" id="arabic-data" role="tabpanel">
                                <div class="mb-3">
                                    <label class="form-label" for="manufacturer-name-input">@lang('Title Ar')</label>
                                    <input type="text" class="form-control" id="display_name_ar" name="display_name_ar"
                                           placeholder="@lang('Enter Title Ar')" value="{{ isset($role) ? $role->display_name_ar : old('display_name_ar') }}" required>
                                    <div class="invalid-feedback">@lang('Please Enter a value')</div>
                                </div>
                                <!-- end row -->
                            </div>
                            <!-- end tab-pane -->

                            <div class="tab-pane mb-3" id="english-data" role="tabpanel">
                                <div class="mb-3">
                                    <label class="form-label" for="manufacturer-name-input">@lang('Title En')</label>
                                    <input type="text" class="form-control" id="display_name_en" name="display_name_en"
                                           placeholder="@lang('Enter Title En')" value="{{ isset($role) ? $role->display_name_en : old('display_name_en') }}" required>
                                    <div class="invalid-feedback">@lang('Please Enter a value')</div>
                                </div>
                                <!-- end row -->
                            </div>
                            <!-- end tab pane -->
                        </div>
                        <!-- end tab content -->
                    </div>
                    <!-- end card body -->
                </div>
                @foreach($permissions as $key => $modelPermissions)
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">@lang( str_replace('App\Models\\', '', $key) . 's')
                                <input class="form-check-input mx-2 parent-checkbox" type="checkbox">
                            </h4>
                            <div class="form-check mb-2">

                            </div>
                        </div>
                        <!-- end card header -->
                        <div class="card-body">
                            <div class="row">
                                @foreach($modelPermissions as $permission)
                                    <div class="col-lg-4 col-md-6">
                                        <div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input formCheck{{ $key }} child-checkbox" type="checkbox" id="formCheck{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}"
                                                @if(isset($rolePermissions) && in_array($permission->id,$rolePermissions)) checked @endif>
                                                <label class="form-check-label" for="formCheck{{ $permission->id }}">
                                                    {{ $permission->{'display_name_'.app()->getLocale()} }}
                                                </label>
                                            </div>
                                        </div>
                                    </div><!--end col-->
                                @endforeach
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                @endforeach
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script src="{{ URL::asset('build/js/app.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Check initial status of parent-checkboxes and set them accordingly
            $('.card').each(function() {
                var allChecked = $(this).find('.child-checkbox').length === $(this).find('.child-checkbox:checked').length;
                $(this).find('.parent-checkbox').prop('checked', allChecked);
            });

            // Event handler for parent-checkbox change
            $('.parent-checkbox').change(function() {
                var isChecked = $(this).prop('checked'); // Get the checked status of the parent checkbox
                // Find and check/uncheck all child-checkboxes based on the parent checkbox status
                $(this).closest('.card').find('.child-checkbox').prop('checked', isChecked);
            });

            // Event handler for child-checkbox change
            $('.child-checkbox').change(function() {
                // Check if at least one child-checkbox is unchecked
                var isUnchecked = $('.child-checkbox').filter(':not(:checked)').length > 0;
                // Uncheck the parent-checkbox if at least one child-checkbox is unchecked
                $(this).closest('.card').find('.parent-checkbox').prop('checked', !isUnchecked);
            });
        });
    </script>

@endsection

