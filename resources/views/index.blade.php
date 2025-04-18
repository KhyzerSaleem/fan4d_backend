@extends('layouts.master')
@section('title')
    @lang('Dashboard')
@endsection
@section('css')
    <!--datatable css-->
    <link href="{{ URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css')}}" rel="stylesheet" type="text/css"/>
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

    <div class="row">
        <div class="col">

            <div class="h-100">
                <div class="row mb-3 pb-1">
                    <div class="col-12">
                        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                            <div class="flex-grow-1">
                                <h4 class="fs-16 mb-1">@lang('Good Morning,') {{ auth()->user()->name }}!</h4>
                                <p class="text-muted mb-0">@lang('Here\'s what\'s happening with your store today.')</p>
                            </div>
                            {{--                        <div class="mt-3 mt-lg-0">--}}
                            {{--                            <form action="javascript:void(0);">--}}
                            {{--                                <div class="row g-3 mb-0 align-items-center">--}}
                            {{--                                    <div class="col-sm-auto">--}}
                            {{--                                        <div class="input-group">--}}
                            {{--                                            <input type="text" name="date" class="form-control border-0 dash-filter-picker shadow" data-provider="flatpickr" data-range-date="true" data-date-format="Y-m-d" data-deafult-date="">--}}
                            {{--                                            <div class="input-group-text bg-primary border-primary text-white">--}}
                            {{--                                                <i class="ri-calendar-2-line"></i>--}}
                            {{--                                            </div>--}}
                            {{--                                        </div>--}}
                            {{--                                    </div>--}}
                            {{--                                    <!--end col-->--}}
                            {{--                                    <div class="col-auto">--}}
                            {{--                                        <button type="button" class="btn btn-soft-success"><i class="ri-add-circle-line align-middle me-1"></i>--}}
                            {{--                                            @lang('translation.Add Product')</button>--}}
                            {{--                                    </div>--}}
                            {{--                                    <!--end col-->--}}
                            {{--                                    <div class="col-auto">--}}
                            {{--                                        <a class="btn btn-soft-info btn-icon waves-effect waves-light"><i class="ri-refresh-line"></i></a>--}}
                            {{--                                    </div>--}}
                            {{--                                    <!--end col-->--}}
                            {{--                                </div>--}}
                            {{--                                <!--end row-->--}}
                            {{--                            </form>--}}
                            {{--                        </div>--}}
                        </div><!-- end card header -->
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->

                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                            @lang('Categories')</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                class="counter-value categories-count"
                                                data-target="{{\App\Models\Category::get()->count()}}">0</span>
                                        </h4>
                                        <a href="{{ route('categories.index') }}"
                                           class="text-decoration-underline">عرض</a>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-success-subtle rounded fs-3">
                                        <i class="ri-gift-2-line text-success"></i>
                                    </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->

                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                            الباقات</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                class="counter-value brands-count"
                                                data-target="0">0</span></h4>
                                        <a href="#"
                                           class="text-decoration-underline">عرض</a>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-info-subtle rounded fs-3">
                                        <i class="ri-honour-line text-info"></i>
                                    </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->

                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                            اعداد عدد وجبات اليوم</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                class="counter-value products-count"
                                                data-target="0">0</span>
                                        </h4>
                                        <a href="#"
                                           class="text-decoration-underline">عرض</a>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-warning-subtle rounded fs-3">
                                        <i class="ri-shirt-line text-warning"></i>
                                    </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->

                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                            الوجبات</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                class="counter-value services-count"
                                                data-target="0">0</span>
                                        </h4>
                                        <a href="#"
                                           class="text-decoration-underline">عرض</a>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-primary-subtle rounded fs-3">
                                        <i class="ri-apps-2-line text-primary"></i>
                                    </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                            @lang('Users')</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                class="counter-value users-count"
                                                data-target="0">0</span>
                                        </h4>
                                        <a href="{{ route('users.index') }}" class="text-decoration-underline">عرض</a>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-primary-subtle rounded fs-3">
                                        <i class="ri-hand-heart-line text-secondary"></i>
                                    </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                            الحجوزات</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                class="counter-value orders-count"
                                                data-target="0">0</span>
                                        </h4>
                                        <a href="{{ route('orders.index') }}" class="text-decoration-underline">عرض</a>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-primary-subtle rounded fs-3">
                                        <i class="ri-shopping-cart-2-line text-danger"></i>
                                    </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                            الحجوزات قيد المراجعة</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                class="counter-value pending-orders-count"
                                                data-target="0">0</span>
                                        </h4>
                                        <a href="{{ route('orders.index') }}" class="text-decoration-underline">عرض</a>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-primary-subtle rounded fs-3">
                                        <i class="ri-shopping-cart-2-line text-danger"></i>
                                    </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                            الحجوزات المنتهية</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                class="counter-value completed-orders-count"
                                                data-target="0">0</span>
                                        </h4>
                                        <a href="{{ route('orders.index') }}" class="text-decoration-underline">عرض</a>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-primary-subtle rounded fs-3">
                                        <i class="ri-shopping-cart-2-line text-danger"></i>
                                    </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div> <!-- end row-->

                {{--            <div class="row">--}}
                {{--                <div class="col-xl-4">--}}
                {{--                    <!-- card -->--}}
                {{--                    <div class="card card-height-100">--}}
                {{--                        <div class="card-header align-items-center d-flex">--}}
                {{--                            <h4 class="card-title mb-0 flex-grow-1">Sales by Locations</h4>--}}
                {{--                            <div class="flex-shrink-0">--}}
                {{--                                <button type="button" class="btn btn-soft-primary btn-sm">--}}
                {{--                                    Export Report--}}
                {{--                                </button>--}}
                {{--                            </div>--}}
                {{--                        </div><!-- end card header -->--}}

                {{--                        <!-- card body -->--}}
                {{--                        <div class="card-body">--}}

                {{--                            <div id="sales-by-locations" data-colors='["--vz-light", "--vz-success", "--vz-primary"]' style="height: 269px" dir="ltr"></div>--}}

                {{--                            <div class="px-2 py-2 mt-1">--}}
                {{--                                <p class="mb-1">Canada <span class="float-end">75%</span></p>--}}
                {{--                                <div class="progress mt-2" style="height: 6px;">--}}
                {{--                                    <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="75">--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}

                {{--                                <p class="mt-3 mb-1">Greenland <span class="float-end">47%</span>--}}
                {{--                                </p>--}}
                {{--                                <div class="progress mt-2" style="height: 6px;">--}}
                {{--                                    <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: 47%" aria-valuenow="47" aria-valuemin="0" aria-valuemax="47">--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}

                {{--                                <p class="mt-3 mb-1">Russia <span class="float-end">82%</span></p>--}}
                {{--                                <div class="progress mt-2" style="height: 6px;">--}}
                {{--                                    <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: 82%" aria-valuenow="82" aria-valuemin="0" aria-valuemax="82">--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                        <!-- end card body -->--}}
                {{--                    </div>--}}
                {{--                    <!-- end card -->--}}
                {{--                </div>--}}
                {{--                <!-- end col -->--}}
                {{--            </div>--}}

            </div> <!-- end .h-100-->

        </div> <!-- end col -->

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


@endsection
