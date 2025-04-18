@extends('layouts.master')
@section('title')
    بيانات العميل
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

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">بيانات العميل</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">  @lang('Home')</a></li>
                        <li class="breadcrumb-item"><a href="{{route('users.index')}}"> العملاء</a></li>
                        <li class="breadcrumb-item active">بيانات العميل</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->


    <div class="row">
        <div class="col-xxl-4">
            <div class="card">
                <div class="card-body p-4">
                    <div>
                        <div class="mt-4 text-center">
                            <h5 class="mb-1">{{$data->name}}</h5>
                            <p class="text-muted">{{$data->date_of_birth}}</p>
                        </div>
                        <div class="table-responsive">
                            <table class="table mb-0 table-borderless">
                                <tbody>
                                <tr>
                                    <th><span class="fw-medium">رقم الجوال</span></th>
                                    <td>({{$data->country_code}}){{$data->phone}} </td>
                                </tr>
                                <tr>
                                    <th><span class="fw-medium">البريد الإلكتروني</span></th>
                                    <td>{{$data->email}}</td>
                                </tr>


                                <tr>
                                    <th><span class="fw-medium">اسم الشركة</span></th>
                                    <td>{{$data->company_name}}</td>
                                </tr>
                                <tr>
                                    <th><span class="fw-medium">المسمى الوظيفي</span></th>
                                    <td>{{$data->job_name}}</td>
                                </tr>

                                <tr>
                                    <th><span class="fw-medium">الدولة</span></th>
                                    <td>{{$data->city?->title}}</td>
                                </tr>
                                <tr>
                                    <th><span class="fw-medium">النوع</span></th>
                                    <td>{{trans($data->gender)}}</td>
                                </tr>
                                <tr>
                                    <th><span class="fw-medium">شهادة القيمة المضافة</span></th>
                                    <td>
                                        <p>{{$data->value_added_certificate}}</p>
                                        @isset($data->value_added_certificate_file)
                                            <a href="{{$data->value_added_certificate_file}}" target="_blank" download="{{basename($data->value_added_certificate_file)}}" >
                                                <div class="avatar-sm flex-shrink-0" >
                                            <span class="avatar-title bg-light rounded fs-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text text-primary icon-dual-primary"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                            </span>
                                                </div>
                                                {{--                    <span>{{basename($design->file)}}</span>--}}
                                            </a>
                                        @endisset
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--end card-body-->
                <div class="card-body border-top border-top-dashed p-4">
                    <div>
                        <h6 class="text-muted text-uppercase fw-semibold mb-4">نقاط العميل</h6>
                        <div>
                            <div>
                                <div class="bg-light px-3 py-2 rounded-2 mb-2">
                                    <div class="d-flex align-items-center">

                                        <div class="flex-shrink-0">
                                            <h6 class="mb-0 center">{{$data->points}}</h6>
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fw-semibold mb-4">محفظة العميل</h6>
                        <div>
                            <div>
                                <div class="bg-light px-3 py-2 rounded-2 mb-2">
                                    <div class="d-flex align-items-center">

                                        <div class="flex-shrink-0">
                                            <h6 class="mb-0 center">{{$data->money}}</h6>
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>
                </div>

            </div>
            <!--end card-->
        </div>
        <!--end col-->

        <div class="col-xxl-8">

            <div class="card" id="customerList">
                <div class="card-header border-bottom-dashed">

                    <div class="row g-4 align-items-center">
                        <div class="col-sm">
                            <div>
                                <h5 class="card-title mb-0">الطلبات</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body border-bottom-dashed border-bottom">

                    <div class="row g-3">
                        <div class="col-xl-12">
                            <div class="row g-3">
                                <div class="col-sm-3">
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
                                <div class="col-sm-4">
                                    <div>
                                        <select class="form-control" data-plugin="choices" data-choices
                                                data-choices-search-false name="choices-single-default"
                                                id="status">
                                            <option value="" disabled selected>@lang('Status')</option>
                                            <option value="all">@lang('All')</option>
                                            @foreach(\App\Models\Order::STATUS as $status)
                                                <option value="{{$status}}">@lang($status)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!--end col-->

                                <div class="col-sm-2 filter-div">
                                    <div>
                                        <button type="button" class="btn btn-primary w-200" onclick="SearchData();">
                                            <i class="ri-equalizer-fill me-2 align-bottom"></i>@lang('Filters')
                                        </button>
                                    </div>
                                </div>

                                <div class="col-sm-2 refresh-dev">
                                    <div>
                                        <button type="button" class="btn btn-info w-200"
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
            var is_winner = $('#is_winner').val();

            if (search_key !== '' || from_date !== '' || to_date !== '' || status !== '' || is_winner !== '') {

                $('#myDataTable').DataTable().destroy();
                load_data(search_key, from_date, to_date, status, is_winner);
            }
        }

        function load_data(search_key = '', from_date = '', to_date = '', status = '', is_winner = '') {
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
                    url: '{{ route('users.orders.data',$data->id) }}',
                    data: {
                        search_key: search_key,
                        from_date: from_date,
                        to_date: to_date,
                        status: status,
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
@endsection

