@extends('layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('css')

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
            <li class="breadcrumb-item"><a href="{{route('product_attributes.index',['id'=>$id])}}">@lang('product_attributes')</a></li>
        @endslot
        @slot('title')
            {{ $title }}
        @endslot
    @endcomponent


    <form id="my-form" autocomplete="off" class="needs-validation" method="post" action="{{ $route }}"
          enctype="multipart/form-data" novalidate>
        @csrf
        @isset($product)
            @method('PUT')
        @endisset
        <input type="hidden" name="product_id" value="{{$id}}" required>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                    </div>
                    <!-- end card header -->
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="categories" class="form-label text-muted">@lang('Select attribute')</label>
                            <select class="js-example-basic-multiple" id="attribute_id" name="attribute_id"
                                    required>
                                @foreach($attributes as $row)
                                    <option value="{{ $row->id }}"
                                            @if(isset($data) && $data->attribute_id == $row->id ) selected @endif>{{ $row->{'title_'.app()->getLocale()} }}</option>
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
            </div>
            <!-- end col -->
            <div class="text-end mb-3">
                <button type="submit" class="btn btn-success w-sm">@lang('Submit')</button>
            </div>
        </div>
        <!-- end row -->
    </form>

@endsection

@section('script')
    <script src="{{ URL::asset('build/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>

    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>

    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>

    <!--select2 cdn-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{--    <script src="{{ URL::asset('build/js/pages/select2.init.js') }}"></script>--}}

    <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
    {{--    <script src="{{ URL::asset('build/js/pages/ecommerce-product-create.init.js') }}"></script>--}}

    <script src="{{ URL::asset('build/js/app.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/i18n/ar.js"></script>

    <script src="{{ URL::asset('build/js/select2/ar.js') }}"></script> <!-- Arabic language file -->

    <script>
        $(document).ready(function () {
            // Determine the language code dynamically (e.g., 'en' or 'ar')
            var languageCode = "{{ app()->getLocale() }}";

            // Initialize Select2 with dynamic language and custom translation
            $('.js-example-basic-multiple').select2({
                language: languageCode,
            });
        });
    </script>
@endsection

