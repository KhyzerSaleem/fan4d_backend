@extends('layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('css')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"/>
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <style>
        .dataTables_filter {
            display: none;
        }

        .dataTables_length {
            display: none;
        }

        .dt-buttons {
            margin-top: 3px;
            margin-bottom: 3px;
        }

    </style>
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
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="customerList">
                <div class="card-header border-bottom-dashed">

                    <div class="row g-4 align-items-center">
                        <div class="col-sm">
                            <div>
                                <h5 class="card-title mb-0">{{ $list }}</h5>
                            </div>
                        </div>
                        @if(isset($createRoute) && isset($add_new))
                            <div class="col-sm-auto">
                                <div class="d-flex flex-wrap align-items-start gap-2">
                                    <button type="button" class="btn btn-soft-primary bulk-status-btn"
                                            style="display: none;"><i
                                            class="ri-checkbox-circle-line align-bottom me-1"></i>
                                        @lang('Bulk Change Status')</button>
                                    <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()">
                                        <i
                                            class="ri-delete-bin-2-line"></i></button>
                                    <a href="{{ $createRoute }}" class="btn btn-success add-btn"
                                       id="create-btn"><i
                                            class="ri-add-line align-bottom me-1"></i> {{ $add_new }}</a>
                                    <button type="button" class="btn btn-soft-danger bulk-delete-btn"
                                            style="display: none;"><i
                                            class="ri-delete-bin-2-line align-bottom me-1"></i>
                                        @lang('Bulk Delete')</button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @if(isset($search_keys))
                <div class="card-body border-bottom-dashed border-bottom">

                        <div class="row g-3">
                            <div class="col-xl-3">
                                <div class="search-box">
                                    <input type="text" class="form-control search custom-search" id="custom-search"
                                           placeholder="@lang('Search for'){{ $search_keys }} ...">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xl-9">
                                <div class="row g-3">
                                    <div class="col-sm-4">
                                        <div class="">
                                            <input type="text" class="form-control" id="datepicker-range"
                                                   data-provider="flatpickr" data-range-date="true"
                                                   data-date-format="Y-m-d" data-deafult-date=""
                                                   placeholder="@lang('Select Date')">
                                        </div>
                                        <input type="hidden" name="from_date" id="from_date">
                                        <input type="hidden" name="to_date" id="to_date">
                                    </div>
                                    <!--end col-->
                                    <div class="col-sm-2">
                                        <div>
                                            @php
                                                $routes = ['attributes.index']; // Replace 'route1', 'route2', 'route3' with your actual route names
                                            @endphp
                                            @if(! in_array(Route::currentRouteName(), $routes))
                                                <select class="form-control" data-plugin="choices" data-choices
                                                        data-choices-search-false name="choices-single-default"
                                                        id="status">
                                                    <option value="" disabled selected>@lang('Status')</option>
                                                    <option value="all">@lang('All')</option>
                                                    <option value="1">@lang('Active')</option>
                                                    <option value="0">@lang('InActive')</option>
                                                </select>
                                            @endif
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <!--end col-->
                                    <div class="col-sm-2">
                                        <div>
                                            @php
                                                $routes = ['attributes.index']; // Replace 'route1', 'route2', 'route3' with your actual route names
                                            @endphp
                                            @if(! in_array(Route::currentRouteName(), $routes))
                                                <select class="form-control" data-plugin="choices" data-choices
                                                        data-choices-search-false name="choices-single-default"
                                                        id="foods_hsasia">
                                                    <option value="" disabled selected>@lang('elhsasia')</option>
                                                    <option value="all">@lang('All')</option>
                                                    <option value="1">@lang('have hasasia')</option>
                                                    <option value="0">@lang('not_have hasasia')</option>
                                                </select>
                                            @endif
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-sm-2 filter-div">
                                        <div>
                                            <button type="button" class="btn btn-primary w-100" onclick="SearchData();">
                                                <i class="ri-equalizer-fill me-2 align-bottom"></i>@lang('Filters')
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-sm-2 refresh-dev">
                                        <div>
                                            <button type="button" class="btn btn-info w-100"
                                                    onclick="window.location.reload()">
                                                <i class="ri-refresh-line me-2 align-bottom"></i>@lang('Refresh')
                                            </button>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                            </div>
                        </div>
                        <!--end row-->

                </div>
                @endif
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table id="myDataTable" class="table align-middle display" style="width: 100%;">
                                <thead class="table-light text-muted">
                                <tr>
                                    <th class="sort">#</th>
                                    @if(collect($columns)->contains('data', 'select'))
                                        <th style="width: 50px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="selectAll"
                                                       value="option">
                                            </div>
                                        </th>
                                    @endif
                                    @foreach($columns as $column)
                                        @isset($column['label'])
                                            <th data-sort="{{ $column['label'] }}">{{ trans($column['label']) }}</th>
                                        @endisset
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                <tr>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @include('components.modals')
                </div>
            </div>

        </div>
        <!--end col-->
    </div>
    <!--end row-->
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script src="{{ URL::asset('build/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/form-editor.init.js') }}"></script>

    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script src="{{ URL::asset('build/libs/flatpickr/l10n/ar.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            load_data();
        });

        function SearchData() {
            var search_key = $('#custom-search').val();
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            var status = $('#status').val();
            var foods_hsasia = $('#foods_hsasia').val();
            var is_winner = $('#is_winner').val();

            if (search_key !== '' || from_date !== '' || to_date !== '' || status !== ''|| foods_hsasia !== '' || is_winner !== '') {

                $('#myDataTable').DataTable().destroy();
                load_data(search_key, from_date, to_date, status,foods_hsasia, is_winner);
            }
        }

        function load_data(search_key = '', from_date = '', to_date = '', status = '', foods_hsasia = '', is_winner = '') {
            let languageUrl = ''; // Default to English language file

            // Check if the current locale is Arabic
            if ('{{ app()->getLocale() }}' === 'ar') {
                languageUrl = 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/ar.json'; // Use Arabic language file
            }
            let table = new DataTable('#myDataTable', {
                language: {
                    url: languageUrl,
                },
                processing: true,
                serverSide: true,
                // searching: false,
                ajax: {
                    url: '{{ $getDataRoute }}',
                    data: {
                        search_key: search_key,
                        from_date: from_date,
                        to_date: to_date,
                        status: status,
                        foods_hsasia: foods_hsasia,
                        is_winner: is_winner,
                    }
                },
                columns: {!! json_encode($columns) !!},
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'print', 'pdf', 'colvis'
                ]
            });
            // Toggle column visibility
            $('#toggleColumns').click(function () {
                table.buttons('.buttons-colvis').trigger();
            });

            const date = new Date();
            const locale = "{{ app()->getLocale() }}";

            flatpickr('#datepicker-range', {
                // Other Flatpickr options...
                mode: 'range',
                locale: locale, // Use the locale code for the desired language
                onChange: function (selectedDates) {
                    // Handle selected date range
                    $('#from_date').val(selectedDates[0] ? selectedDates[0].toISOString() : null);
                    $('#to_date').val(selectedDates[1] ? selectedDates[1].toISOString() : null);
                }
            });
        }
    </script>
    <script>
        $(document).ready(function () {
            // Listen for the modal's shown event
            $('.deleteRecordModal').on('shown.bs.modal', function (event) {
                // Get the button that triggered the modal
                var button = $(event.relatedTarget);

                // Extract the model ID from the button's data attribute
                var modelId = button.data('model-id');

                // Get the form within the modal
                var form = $(this).find('.deleteRecordForm');

                // Update the form action with the model ID
                var action = form.attr('action');
                form.attr('action', action.replace(':modelId', modelId));

                // Reset form action when modal is hidden
                $(this).on('hidden.bs.modal', function () {
                    form.attr('action', action); // Reset to original action
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#selectAll').change(function () {
                $('input[name="selectedItems[]"]').prop('checked', $(this).prop('checked'));

                // Show or hide the bulk delete button based on the selectAll checkbox status
                $('.bulk-delete-btn').toggle($(this).prop('checked'));
                $('.bulk-status-btn').toggle($(this).prop('checked'));

                updateSelectedItemsArray();
            });

            // Use event delegation to handle click events on checkboxes
            $(document).on('change', 'input[name="selectedItems[]"]', function () {
                // Show or hide the bulk delete button based on the check status
                $('.bulk-delete-btn').toggle($('input[name="selectedItems[]"]:checked').length > 0);
                $('.bulk-status-btn').toggle($('input[name="selectedItems[]"]:checked').length > 0);

                updateSelectedItemsArray();
            });

            $('.bulk-delete-btn').click(function () {
                // Open the confirmation modal and pass the selected item IDs
                var modal = $('.deleteMultiRecordModal');
                modal.find('.ids_input').val(selectedItems);
                modal.modal('show');
            });

            $('.bulk-status-btn').click(function () {
                // Open the confirmation modal and pass the selected item IDs
                var modal = $('.changeStatusMultiRecordModal');
                modal.find('.ids_input').val(selectedItems);
                modal.modal('show');
            });

            function updateSelectedItemsArray() {
                selectedItems = []; // Clear the array
                $('input[name="selectedItems[]"]:checked').each(function () {
                    selectedItems.push($(this).val());
                });
            }
        });

    </script>

    @isset($changeStatusRoute)
        <script>
            $(document).ready(function () {
                // Attach the change event listener to a parent element that exists in the DOM
                $(document).on('change', '.switch-status', function () {
                    var id = $(this).data('id');
                    var isActive = $(this).prop('checked') ? 1 : 0;

                    $.ajax({
                        url: '{{ $changeStatusRoute }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id,
                            is_active: isActive,
                        },
                        success: function (response) {
                            var className = 'success';
                            var text = response.success;
                            if (response.error) {
                                className = 'danger';
                                text = response.error;
                            }
                            Toastify({
                                newWindow: true,
                                text: text,
                                gravity: "top",
                                position: "right",
                                className: "bg-" + className,
                                stopOnFocus: true,
                                duration: 5000,
                                close: true,
                            }).showToast();
                        },
                        error: function (xhr, status, error) {
                            // Optionally, you can handle errors here
                        }
                    });
                });
            });

        </script>
    @endisset

    @isset($changeFirstOrderRoute)
        <script>
            $(document).ready(function () {
                // Attach the change event listener to a parent element that exists in the DOM
                $(document).on('change', '.switch-for-first-order', function () {
                    var id = $(this).data('id');
                    var isActive = $(this).prop('checked') ? 1 : 0;

                    $.ajax({
                        url: '{{ $changeFirstOrderRoute }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id,
                            for_first_order: isActive,
                        },
                        success: function (response) {
                            var className = 'success';
                            var text = response.success;
                            if (response.error) {
                                className = 'danger';
                                text = response.error;
                            }
                            Toastify({
                                newWindow: true,
                                text: text,
                                gravity: "top",
                                position: "right",
                                className: "bg-" + className,
                                stopOnFocus: true,
                                duration: 5000,
                                close: true,
                            }).showToast();
                        },
                        error: function (xhr, status, error) {
                            // Optionally, you can handle errors here
                        }
                    });
                });
            });

        </script>
    @endisset

    @isset($changeShowOnAppRoute)
        <script>
            $(document).ready(function () {
                // Attach the change event listener to a parent element that exists in the DOM
                $(document).on('change', '.switch-show-on-app', function () {
                    var id = $(this).data('id');
                    var isActive = $(this).prop('checked') ? 1 : 0;

                    $.ajax({
                        url: '{{ $changeShowOnAppRoute }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id,
                            show_on_app: isActive,
                        },
                        success: function (response) {
                            var className = 'success';
                            var text = response.success;
                            if (response.error) {
                                className = 'danger';
                                text = response.error;
                            }
                            Toastify({
                                newWindow: true,
                                text: text,
                                gravity: "top",
                                position: "right",
                                className: "bg-" + className,
                                stopOnFocus: true,
                                duration: 5000,
                                close: true,
                            }).showToast();
                        },
                        error: function (xhr, status, error) {
                            // Optionally, you can handle errors here
                        }
                    });
                });
            });

        </script>
    @endisset

    @isset($generateGroupsRoute)
        <script>
            $(document).ready(function () {
                // Listen for the modal's shown event
                $('.generateGroupsModal').on('shown.bs.modal', function (event) {
                    // Get the button that triggered the modal
                    var button = $(event.relatedTarget);

                    // Extract the model ID from the button's data attribute
                    var modelId = button.data('model-id');

                    // Get the form within the modal
                    var form = $(this).find('.generateGroupsForm');

                    // Update the form action with the model ID
                    var action = form.attr('action');
                    form.attr('action', action.replace(':modelId', modelId));

                    // Reset form action when modal is hidden
                    $(this).on('hidden.bs.modal', function () {
                        form.attr('action', action); // Reset to original action
                    });
                });
            });
        </script>
    @endisset

@endsection
