@extends('layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('css')
    <link href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .img-fluid {
            width: 100%!important;
            height: 100%!important;
        }
        .select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__choice__remove{
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
        @isset($service)
            @method('PUT')
        @endisset
        <div class="row">
            <div class="col-lg-8">
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
                        <div class="flex-shrink-0">
                            <div class="form-check form-switch form-switch-right form-switch-md">
                                <label for="input-group-showcode" class="form-label text-muted">
                                    @lang('is_active')
                                </label>
                                <input class="form-check-input" name="is_active" value="1" {{ isset($service)  ? ($service->is_active ? 'checked' : '') : 'checked' }} type="checkbox" id="input-group-showcode">
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
                                           placeholder="@lang('Enter Title Ar')" value="{{ isset($service) ? $service->title_ar : old('title_ar') }}" required>
                                    <div class="invalid-feedback">@lang('Please Enter a value')</div>
                                </div>
                                <div>
                                    <label>@lang('Description Ar')</label>

                                    <div class="ckeditor-classic" id="desc_ar">
                                        <input type="hidden" name="desc_ar" value="{{ isset($service) ? $service->desc_ar : old('desc_ar') }}">
                                    </div>
                                </div>
                                <!-- end row -->
                            </div>
                            <!-- end tab-pane -->

                            <div class="tab-pane mb-3" id="english-data" role="tabpanel">
                                <div class="mb-3">
                                    <label class="form-label" for="manufacturer-name-input">@lang('Title En')</label>
                                    <input type="text" class="form-control" id="title_en" name="title_en"
                                           placeholder="@lang('Enter Title En')" value="{{ isset($service) ? $service->title_en : old('title_en') }}" required>
                                    <div class="invalid-feedback">@lang('Please Enter a value')</div>
                                </div>
                                <div>
                                    <label>@lang('Description En')</label>

                                    <div class="ckeditor-classic" id="desc_en">
                                        <input type="hidden" name="desc_en" value="{{ isset($service) ? $service->desc_en : old('desc_en') }}">
                                    </div>
                                </div>
                                <!-- end row -->
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="sku">@lang('SKU')</label>
                                    <input type="text" class="form-control" id="sku" name="sku"
                                           placeholder="@lang('Please Enter a value')" value="{{ isset($service) ? $service->sku : old('sku') }}" required>
                                    <div class="invalid-feedback">@lang('Please Enter a valid value')</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="percent">@lang('Price Before Tax')</label>
                                    <input type="number" step="0.01" min="0.01" class="form-control" id="price_before_tax" name="price_before_tax"
                                           placeholder="@lang('Please Enter a number')" value="{{ isset($service) ? $service->price_before_tax : old('price_before_tax') }}" required>
                                    <div class="invalid-feedback">@lang('Please Enter a valid value')</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="discount">@lang('Discount Percent') (%)</label>
                                    <input type="number" step="0.1" min="0.1" class="form-control" id="discount" name="discount"
                                           placeholder="@lang('Please Enter a number')" value="{{ isset($service) ? $service->discount : old('discount') }}" required>
                                    <div class="invalid-feedback">@lang('Please Enter a valid value')</div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="project-thumbnail-img">@lang('Image')</label>
                                <input name="main_image" accept="image/*" type="file" class="dropify" data-height="100" data-required="true" @isset($service) data-default-file="{{ $service->main_image }}" @endisset/>
                            </div>
                            <!-- end tab pane -->
                        </div>
                        <!-- end tab content -->
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <div class="col-lg-4">

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">@lang('Please Select')</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="categories" class="form-label text-muted">@lang('Select Category')</label>
                            <select class="js-example-basic-multiple" id="categories" name="categories[]" multiple="multiple"
                                    multiple required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @if(isset($service) && $serviceCategories && in_array($category->id, $serviceCategories)) selected @endif>{{ $category->{'title_'.app()->getLocale()} }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                @lang('Please Choose a value')
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="modells" class="form-label text-muted">@lang('Select Modells')</label>
                            <select class="js-example-basic-multiple" id="modells" name="modells[]" multiple="multiple"
                                    multiple required>
                                @foreach($modells as $modell)
                                    <option value="{{ $modell->id }}" @if(isset($service) && $serviceModells && in_array($modell->id, $serviceModells)) selected @endif>{{ $modell->{'title_'.app()->getLocale()} }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                @lang('Please Choose a value')
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="productionYears" class="form-label text-muted">@lang('Select Production Years')</label>
                            <select class="js-example-basic-multiple" name="productionYears[]" multiple="multiple" required>
                                @isset($service)
                                    @foreach($productionYears as $productionYear)
                                        <option value="{{ $productionYear->id }}" @if(isset($service) && $serviceProductionYears && in_array($productionYear->id, $serviceProductionYears)) selected @endif>{{ $productionYear->year . '(' . optional($productionYear->modell)->title  .')' }}</option>
                                    @endforeach
                                @endisset
                            </select>
                            <div class="invalid-feedback">
                                @lang('Please Choose a value')
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="categories" class="form-label text-muted">@lang('Select Car Colors')</label>
                            <select class="js-example-basic-multiple" id="carColors" name="carColors[]" multiple="multiple"
                                    multiple required>
                                @foreach($carColors as $carColor)
                                    <option value="{{ $carColor->id }}" @if(isset($service) && $serviceCarColors && in_array($carColor->id, $serviceCarColors)) selected @endif>{{ $carColor->{'title_'.app()->getLocale()} }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                @lang('Please Choose a value')
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="products" class="form-label text-muted">@lang('Select Products')</label>
                            <select class="js-example-basic-multiple" name="products[]" multiple="multiple" required>
                                @isset($service)
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" @if(isset($service) && $serviceProducts && in_array($product->id, $serviceProducts)) selected @endif>{{ $product->{'title_'.app()->getLocale()} }}</option>
                                    @endforeach
                                @endisset
                            </select>
                            <div class="invalid-feedback">
                                @lang('Please Choose a value')
                            </div>
                        </div>
                    </div>

                    <!-- end card body -->
                </div>
                <!-- end card -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">@lang('Service Images')</h4>
                    </div><!-- end card header -->

                    <div class="card-body">

{{--                        <h5 class="fs-14 mb-1">@lang('translations.Service Images')</h5>--}}
                        <p class="text-muted">@lang('Add Service Gallery Images.')</p>

                        <div class="dropzone">
                            <div class="fallback">
                                <input name="file" accept="image/*" type="file" multiple="multiple">
                            </div>
                            <div class="dz-message needsclick">
                                <div class="mb-3">
                                    <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                                </div>
                                <h5>@lang('Drop files here or click to upload.')</h5>
                            </div>
                        </div>
                        <input type="hidden" name="imageNames" id="imageNames" value="">

                        <ul class="list-unstyled mb-0" id="dropzone-preview">
                            <li class="mt-2" id="dropzone-preview-list">
                                <!-- This is used as the file preview template -->
                                <div class="border rounded">
                                    <div class="d-flex p-2">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar-xl bg-light rounded">
                                                <img data-dz-thumbnail class="img-fluid rounded d-block" src="@isset($service) {{ $service->main_image }} @endisset" alt="Dropzone-Image" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
{{--                                            <div class="pt-1">--}}
{{--                                                <h5 class="fs-14 mb-1" data-dz-name>&nbsp;</h5>--}}
{{--                                                <p class="fs-13 text-muted mb-0" data-dz-size></p>--}}
{{--                                                <strong class="error text-danger" data-dz-errormessage></strong>--}}
{{--                                            </div>--}}
                                        </div>
                                        <div class="flex-shrink-0 ms-3">
                                            <button data-dz-remove class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <!-- end dropzon-preview -->
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


    <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>

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

        var serviceExists = {{ isset($service) ? 'true' : 'false' }};
        if (! serviceExists){
            $('#my-form').submit(function(event) {
                // validate image
                if(! $('.dropify').val()) {
                    event.preventDefault();
                    tostify('{{ __('please choose an image') }}', "danger")
                }
            })
        }


    </script>

    <script>
        // Dropzone
        var dropzonePreviewNode = document.querySelector("#dropzone-preview-list");
        dropzonePreviewNode.itemid = "";
        var previewTemplate = dropzonePreviewNode.parentNode.innerHTML;
        dropzonePreviewNode.parentNode.removeChild(dropzonePreviewNode);
        var dropzone = new Dropzone(".dropzone", {
            paramName: 'image',
            url: '{{ route('services.uploadGallery') }}',
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
            success: function(file, response) {
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
            error: function(file, errorMessage, xhr) {
                console.error("Error uploading image: " + errorMessage);
            }

        });
    </script>
    @isset($service)
        <script>

            // existing images
            let existingImages = @json($service->images);

            // Loop through each existing image
            existingImages.forEach(function(image) {
                // Create a preview template for the existing image
                var previewTemplate = `
                    <li class="mt-2" id="dropzone-preview-list" data-image-id="${image.id}">
                        <!-- This is used as the file preview template -->
                        <div class="border rounded">
                            <div class="d-flex p-2">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-xl bg-light rounded">
                                        <img data-dz-thumbnail class="img-fluid rounded d-block" src="${image.image}" alt="Dropzone-Image" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="pt-1">

                                    </div>
                                </div>
                                <div class="flex-shrink-0 ms-3">
                                    <button type="button" data-dz-remove class="btn btn-sm btn-danger remove-image">{{ __('Delete') }}</button>
                                </div>
                            </div>
                        </div>
                    </li>
                `;

                // Append the preview template to the Dropzone preview area
                $('#dropzone-preview').append(previewTemplate);
            });
        </script>
        <script>
        // Add event listener to the remove buttons
        $(document).on('click', '.remove-image', function(event) {
            event.preventDefault();
            var imageContainer = $(this).closest('#dropzone-preview-list');
            var imageId = imageContainer.data('image-id');

            // Remove the image from the Dropzone preview
            dropzone.removeFile(imageContainer[0]);

            // Send an AJAX request to delete the image from the database
            $.ajax({
                url: '{{ route('services.removeGallery') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    service_id: {{ $service->id }},
                    image_id: imageId
                },
                success: function(response) {
                    // Handle success response if needed
                    var tostifyClass = "danger";
                    if(response.success){
                        tostifyClass = "success";
                        imageContainer.remove();
                    }
                    tostify(response.message, tostifyClass);

                },
                error: function(xhr, status, error) {
                    // Handle error response if needed
                    console.log('asd');
                    tostify("{{ __('Operation Failed') }}", "danger");
                }
            });
        });

    </script>
    @endisset

    <script>
        $(document).ready(function() {
            // Determine the language code dynamically (e.g., 'en' or 'ar')
            var languageCode = "{{ app()->getLocale() }}";

            // Initialize Select2 with dynamic language and custom translation
            $('.js-example-basic-multiple').select2({
                language: languageCode,
            });
        });
    </script>

    <script>
        $('select[name="modells[]"]').change(function() {
            var modells = $(this).val();
            $.ajax({
                url: '{{ route('services.productionYears') }}',
                type: 'GET',
                data: {modells: modells},
                success: function(options) {
                    let productionYears = $('select[name="productionYears[]"]');
                    productionYears.html('');
                    options.forEach(function(option) {
                        // Append each value to the HTML element
                        productionYears.append('<option value="'+option.id+'">' + option.year + '(' + option.modell.title + ')' + '</option>');
                    });
                },
                error: function() {
                    alert('An error occurred while retrieving the options.');
                }
            });
        });
    </script>

    <script>
        $('select[name="categories[]"], select[name="modells[]"], ' +
            'select[name="productionYears[]"], select[name="carColors[]"]')
            .change(function() {
            var categories = $('select[name="categories[]"]').val();
            var modells = $('select[name="modells[]"]').val();
            var productionYears = $('select[name="productionYears[]"]').val();
            var carColors = $('select[name="carColors[]"]').val();

            loadProducts(categories, modells, productionYears, carColors);
        });


        function loadProducts(categories, modells, productionYears, carColors) {
            $.ajax({
                url: '{{ route('services.getProducts') }}',
                type: 'GET',
                data: {
                    categories: categories,
                    modells: modells,
                    productionYears: productionYears,
                    carColors: carColors,
                },
                success: function(options) {
                    let products = $('select[name="products[]"]');
                    products.html('');
                    options.forEach(function(option) {
                        // Append each value to the HTML element
                        products.append('<option value="' + option.id + '">' + option.title + '</option>');
                    });
                },
                error: function() {
                    alert('An error occurred while retrieving the options.');
                }
            });
        }
    </script>
@endsection

