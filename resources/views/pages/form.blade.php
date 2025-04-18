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


    <form id="my-form" autocomplete="off" class="needs-validation" enctype="multipart/form-data" method="post" action="{{ $route }}" novalidate>
        @csrf
        @isset($page)
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
                            <div class="tab-pane active" id="arabic-data" role="tabpanel">
                                <div>
                                    <label>@lang('translation.Description Ar')</label>

                                    <div class="ckeditor-classic" id="desc_ar">
                                        <input type="hidden" name="desc_ar" value="{{ isset($page) ? $page->desc_ar : old('desc_ar') }}">
                                    </div>
                                </div>
                                <!-- end row -->
                            </div>
                            <!-- end tab-pane -->

                            <div class="tab-pane" id="english-data" role="tabpanel">
                                <div>
                                    <label>@lang('translation.Description En')</label>

                                    <div class="ckeditor-classic" id="desc_en">
                                        <input type="hidden" name="desc_en" value="{{ isset($page) ? $page->desc_en : old('desc_en') }}">
                                    </div>
                                </div>
                                <!-- end row -->
                            </div>
                            <!-- end tab pane -->
                            <div class="mb-3 mt-3">
                                <label class="form-label" for="project-thumbnail-img">@lang('Image')</label>
                                <input name="image" accept="image/*" type="file" class="dropify" data-height="100" @isset($page) data-default-file="{{ $page->image }}" @endisset/>
                            </div>
                        </div>
                        <!-- end tab content -->
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
                <div class="text-end mb-3">
                    <button type="submit" class="btn btn-success w-sm">@lang('translation.Submit')</button>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </form>

@endsection

@section('script')
    <script src="{{ URL::asset('build/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>

    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>

    <script src="{{ URL::asset('build/js/app.js') }}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>

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
                    invalidFeedback.innerText = '@lang('translation.Please Enter a value')';

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
                        if (! editorContent.trim()) { // if empty
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
                        }else {
                            invalidFeedback.style.display = 'none';
                        }
                    });
                })
                .catch(function (error) {
                    console.error(error);
                });
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
    </script>
@endsection

