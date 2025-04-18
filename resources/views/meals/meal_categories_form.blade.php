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


    <form id="my-form" autocomplete="off" class="needs-validation" method="post" action="{{ $route }}"
          enctype="multipart/form-data" novalidate>
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <!-- end card header -->
                    <div class="card-body">

                        <div class="mb-3">
                            <h3><span style="color: green">اسم الوجبة :</span>{{$category->title}}</h3>
                        </div>
                        <ul class="nav nav-tabs nav-justified nav-border-top nav-border-top-success mb-3"
                            role="tablist">
                            @foreach(\App\Models\Category::active()->get() as $key => $category_row)
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link @if($key == 0) active @endif " data-bs-toggle="tab"
                                       href="#nav-border-{{$category_row->id}}"
                                       role="tab" aria-selected="true">
                                        {{$category_row->title}}
                                    </a>
                                </li>
                            @endforeach

                        </ul>
                        <div class="tab-content text-muted">
                            @foreach(\App\Models\Category::active()->get() as $key => $category_row)
                                <input type="hidden" name="calories[{{$category_row->id}}][category_id]"
                                       value="{{$category_row->id}}">
                                <div class="tab-pane @if($key == 0) active show @endif "
                                     id="nav-border-{{$category_row->id}}" role="tabpanel">
                                    <h1> {{$category_row->title}}</h1>
                                    <div class="mb-3">
                                        <p class="mb-0">
                                            <span style="font-weight: bold;">@lang('description')</span> :
                                            {{$category_row->description}}
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="input-group">
                                                <span class="input-group-text"
                                                      id="inputGroup-sizing-default">عدد الكالوريز الاساسية</span>
                                                @if(isset($category))
                                                    @php
                                                        $exists_category = \App\Models\MealCategory::where('meal_id', $category->id)->where('category_id',$category_row->id)->first();
                                                    if(isset($exists_category)){
                                                        $current_calory = $exists_category->calories;
                                                    }else{
                                                        $current_calory = 0;
                                                    }
                                                    @endphp
                                                @endif
                                                <input type="text" class="form-control"
                                                       name="calories[{{$category_row->id}}][calory]"
                                                       value="@if(isset($category)){{$current_calory}}@else 0 @endif"
                                                       required
                                                       aria-label="Sizing example input"
                                                       placeholder="@lang('Enter quantity of calories')"
                                                       aria-describedby="inputGroup-sizing-default">

                                                <label class="input-group-text" for="inputGroupSelect02">جرام /
                                                    الوجبة</label>
                                                <div class="invalid-feedback">@lang('Please Enter a value')</div>
                                            </div>
                                        </div>

                                    </div>
                                    </div>
                                    @foreach($category->attributes as $atr)
                                        <div class="mb-3">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="input-group">
                                                <span class="input-group-text"
                                                      id="inputGroup-sizing-default">{{$atr->attribute->title}}</span>
                                                    @if(isset($category))
                                                        @php
                                                            $exists_attr = \App\Models\MealCategoryAttribute::where('meal_id', $category->id)
                                                                                                            ->where('attribute_id',$atr->attribute_id)
                                                                                                            ->where('category_id',$category_row->id)
                                                                                                            ->first();
                                                        if(isset($exists_attr)){
                                                            $current_attr = $exists_attr->calories;
                                                        }else{
                                                            $current_attr = 0;
                                                        }
                                                        @endphp
                                                    @endif
                                                    <input type="hidden" name="attributes[{{$category_row->id}}][{{$atr->attribute_id}}][attribute_id]"
                                                           value="{{$atr->attribute_id}}">
                                                    <input type="text" class="form-control"
                                                           name="attributes[{{$category_row->id}}][{{$atr->attribute_id}}][calories]"
                                                           value="@if(isset($category)){{$current_attr}}@else 0 @endif"
                                                           required
                                                           aria-label="Sizing example input"
                                                           placeholder="@lang('Enter quantity of calories')"
                                                           aria-describedby="inputGroup-sizing-default">

                                                    <label class="input-group-text" for="inputGroupSelect02">
                                                        {{$atr->attribute->unit->title}}</label>
                                                    <div class="invalid-feedback">@lang('Please Enter a value')</div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    @endforeach
                                    <hr>

                                    <div class="card">
                                        <div class="card-header align-items-center d-flex">
                                            <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0 flex-grow-1" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-bs-toggle="tab" href="#arabic-data{{$category_row->id}}"
                                                       role="tab">
                                                        <img src="{{URL::asset('build/images/flags/sa.svg')}}" alt="user-image"
                                                             class="me-2 rounded" height="18">
                                                        <span class="align-middle">@lang('Arabic')</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#english-data{{$category_row->id}}"
                                                       role="tab">
                                                        <img src="{{ URL::asset('build/images/flags/us.svg') }}" alt="user-image"
                                                             class="me-2 rounded" height="20">
                                                        <span class="align-middle">@lang('English')</span>
                                                    </a>
                                                </li>
                                            </ul>

                                        </div>
                                        <!-- end card header -->
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <div class="tab-pane mb-3 active" id="arabic-data{{$category_row->id}}" role="tabpanel">
                                                    <div class="mb-3">
                                                        <label class="form-label"
                                                               for="manufacturer-name-input">طريقة التسخين</label>
                                                        <textarea class="form-control" id="heating_method_ar" name="heating_method[{{$category_row->id}}][ar]">{{ isset($category) ? $category->categories()->where('category_id',$category_row->id)->first()?->heating_method_ar : old('heating_method_ar') }}</textarea>
                                                        <div class="invalid-feedback">@lang('Please Enter a value')</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label"
                                                               for="manufacturer-name-input">التعليمات</label>
                                                        <textarea class="form-control" id="instructions_ar" name="instructions[{{$category_row->id}}][ar]">{{ isset($category) ? $category->categories()->where('category_id',$category_row->id)->first()?->instructions_ar : old('instructions_ar') }}</textarea>
                                                        <div class="invalid-feedback">@lang('Please Enter a value')</div>
                                                    </div>
                                                    <!-- end row -->
                                                </div>
                                                <!-- end tab-pane -->

                                                <div class="tab-pane mb-3" id="english-data{{$category_row->id}}" role="tabpanel">
                                                    <div class="mb-3">
                                                        <label class="form-label"
                                                               for="manufacturer-name-input">طريقة التسخين</label>
                                                        <textarea class="form-control" id="heating_method_en" name="heating_method[{{$category_row->id}}][en]">{{ isset($category) ? $category->categories()->where('category_id',$category_row->id)->first()?->heating_method_en : old('heating_method_en') }}</textarea>
                                                        <div class="invalid-feedback">@lang('Please Enter a value')</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label"
                                                               for="manufacturer-name-input">التعليمات</label>
                                                        <textarea class="form-control" id="instructions_en" name="instructions[{{$category_row->id}}][en]">{{ isset($category) ? $category->categories()->where('category_id',$category_row->id)->first()?->instructions_en : old('instructions_en') }}</textarea>
                                                        <div class="invalid-feedback">@lang('Please Enter a value')</div>
                                                    </div>
                                                    <!-- end row -->
                                                </div>

                                                <!-- end tab pane -->
                                            </div>

                                        </div>
                                        <!-- end card body -->

                                    </div>
                                </div>
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
        // Get all CKEditor instances with the class "ckeditor-classic"
        var ckClassicEditors = document.querySelectorAll(".ckeditor-classic");

        // Iterate over each CKEditor instance
        ckClassicEditors.forEach(function (editorElement) {
            ClassicEditor
                .create(editorElement)
                .then(function (editor) {
                    // Set a unique ID for each editor instance
                    var editorId = editorElement.getAttribute('id');

                    // Set initial height of the editor
                    editor.ui.view.editable.element.style.height = '200px';

                    // Set initial value
                    var hiddenInput = document.querySelector('input[name="' + editorId + '"]');
                    editor.setData(hiddenInput.value);

                    // Create an invalid feedback element
                    var invalidFeedback = document.createElement('div');
                    invalidFeedback.classList.add('invalid-feedback');
                    invalidFeedback.innerText = '@lang('Please Enter a value')';

                    // Append the invalid feedback element after the editor element
                    editorElement.parentNode.insertBefore(invalidFeedback, editorElement.parentElement.nextElementSibling);


                    // Listen for changes in the editor content
                    editor.model.document.on('change:data', function () {
                        // Get the content of the editor
                        var editorContent = editor.getData();

                        // Set the content in a hidden input field of a form
                        var hiddenInput = document.querySelector('input[name="' + editorId + '"]');
                        if (hiddenInput) {
                            hiddenInput.value = editorContent;
                        }

                        // Check if the editor content is empty
                        if (!editorContent.trim()) { // if empty
                            invalidFeedback.style.display = 'block';
                        } else {
                            invalidFeedback.style.display = 'none';
                        }
                    });

                    // Add event listener for form submission
                    var form = editorElement.closest('form');
                    form.addEventListener('submit', function (event) {
                        // Check if the editor content is empty
                        var editorContent = editor.getData();
                        if (!editorContent.trim()) {
                            // Prevent form submission
                            event.preventDefault();
                            // Show the invalid feedback
                            invalidFeedback.style.display = 'block';
                        } else {
                            invalidFeedback.style.display = 'none';
                        }
                    });
                })
                .catch(function (error) {
                    console.error(error);
                });
        });

    </script>

@endsection

