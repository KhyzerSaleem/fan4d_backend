@extends('layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"
          type="text/css"/>
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/classic.min.css') }}"/>
    <link rel="stylesheet" href="{{ URL::asset('build/css/custom.css') }}"/>
@endsection
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ $title }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">  @lang('Home')</a></li>
                        <li class="breadcrumb-item"><a href="{{route('orders.index')}}">  الطلبات</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-9">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title flex-grow-1 mb-0"><i class="ri-hashtag align-bottom me-1 text-muted"></i>رقم
                            الطلب : {{ $order->id }}</h5>
                        <div class="flex-shrink-0">
                            {{--                            <a href="{{ route('orders.invoice', $order->id) }}" class="btn btn-success btn-sm"><i class="ri-download-2-fill align-middle me-1"></i> @lang('translation.Invoice') </a>--}}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-nowrap align-middle table-borderless mb-0">
                            <thead class="table-light text-muted">
                            <tr>
                                <th scope="col">المنتج</th>
                                <th scope="col">المواصفات</th>
                                <th scope="col">سعر المنتج</th>
                                <th scope="col">الكمية</th>
                                <th scope="col">عدد التصاميم</th>
                                <th scope="col">السعر</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->items as $item)

                                @component('components.product-item', ['item' => $item])@endcomponent

                            @endforeach
                            <tr class="border-top border-top-dashed">
                                <td colspan="2"></td>

                                <td colspan="3" class="fw-medium p-0">
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                        <tr>
                                            <td>@lang('Sub Total') :</td>
                                            <td class="text-end"> {{ $order->sub_total ?? 0 }} @lang('SAR') </td>
                                        </tr>
                                        <tr>
                                            <td>الشحن :</td>
                                            <td class="text-end"> {{ $order->shipping_cost ?? 0 }} @lang('SAR') </td>
                                        </tr>
                                        <tr>
                                            <td>@lang('Discount') :</td>
                                            <td class="text-end"> {{ $order->discount ?? 0 }} @lang('SAR') </td>
                                        </tr>
                                        <tr>
                                            <td>@lang('Tax') :</td>
                                            <td class="text-end"> {{ $order->tax ?? 0 }} @lang('SAR') </td>
                                        </tr>
                                        <tr class="border-top border-top-dashed">
                                            <th scope="row">@lang('Total') (@lang('SAR')) :</th>
                                            <th class="text-end"> {{ $order->total ?? 0 }} @lang('SAR') </th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!--end card-->
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i
                                    class="ri-map-pin-line align-bottom me-1 text-muted"></i> تفاصيل العنوان</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-shrink-0">
                                    <p class="text-muted mb-0">الاسم :</p>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0">{{ $order->address->title }}</h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-shrink-0">
                                    <p class="text-muted mb-0">@lang('Address') :</p>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0">{{ $order->address->address }}</h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-shrink-0">
                                    <p class="text-muted mb-0">المدينه :</p>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0">{{ $order->address->city->title }}</h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-shrink-0">
                                    <p class="text-muted mb-0">المنطقة :</p>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0">{{ $order->address->area->title }}</h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-shrink-0">
                                    <p class="text-muted mb-0">المكان على الخريطة :</p>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <a href="https://www.google.com/maps?q={{ $order->address->lat }}{{ $order->address->lng }}" target="_blank">
                                        <i class="ri-map-pin-line" style="font-size: 24px;"></i>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div><!--end card-->
                </div>
                {{--                <div class="col-md-4">--}}
                {{--                    <div class="card">--}}
                {{--                        <div class="card-header">--}}
                {{--                            <h5 class="card-title mb-0"><i class="ri-secure-payment-line align-bottom me-1 text-muted"></i> @lang('Rate & Complain')</h5>--}}
                {{--                        </div>--}}
                {{--                        <div class="card-body">--}}
                {{--                            <div class="d-flex align-items-center mb-3">--}}
                {{--                                <div class="flex-shrink-0">--}}
                {{--                                    <p class="text-muted mb-0">@lang('Rate') :</p>--}}
                {{--                                </div>--}}
                {{--                                <div class="flex-grow-1 ms-2">--}}
                {{--                                    <h6 class="mb-0">--}}
                {{--                                        <div class="text-warning fs-15">--}}
                {{--                                            @for($i = 1; $i <= 5; $i++)--}}
                {{--                                                @if($i <= $order->rate)--}}
                {{--                                                <i class="ri-star-fill"></i>--}}
                {{--                                                @else--}}
                {{--                                                    <i class="ri-star-line"></i>--}}
                {{--                                                @endif--}}
                {{--                                            @endfor--}}

                {{--                                        </div>--}}
                {{--                                        @for--}}
                {{--                                    </h6>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                            <div class="d-flex align-items-center mb-3">--}}
                {{--                                <div class="flex-shrink-0">--}}
                {{--                                    <p class="text-muted mb-0">@lang('Comment') :</p>--}}
                {{--                                </div>--}}
                {{--                                <div class="flex-grow-1 ms-2">--}}
                {{--                                    <h6 class="mb-0">{{ $order->rate_comment ?? '-' }}</h6>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                            <div class="d-flex align-items-center mb-3">--}}
                {{--                                <div class="flex-shrink-0">--}}
                {{--                                    <p class="text-muted mb-0">@lang('Complain') :</p>--}}
                {{--                                </div>--}}
                {{--                                <div class="flex-grow-1 ms-2">--}}
                {{--                                    <h6 class="mb-0">{{ $order->complain ?? '-' }}</h6>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div><!--end card-->--}}
                {{--                </div>--}}
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i
                                    class="ri-secure-payment-line align-bottom me-1 text-muted"></i> @lang('Payment Details')
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="flex-shrink-0  mb-3">
                                @php
                                    if ($order->payment_status == 'unpaid') {
                       $class = "bg-primary-subtle text-primary";
                   }elseif ($order->payment_status == 'paid') {
                       $class = "bg-success-subtle text-success";
                   }else {
                       $class = "bg-warning-subtle text-warning";
                   }
                                @endphp
                                <p class="text-muted mb-3">الحالة : <span
                                        class="badge ' . {{$class}} . ' text-uppercase">  @lang($order->payment_status) </span>
                                </p>
                            </div>
                            @isset($order->payment_method)
                                <div class="d-flex align-items-center mb-3">
                                    <div class="flex-shrink-0">
                                        <p class="text-muted mb-0">@lang('Payment Method') :</p>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-0">{{ __($order->payment_method) }}</h6>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="flex-shrink-0">
                                        <p class="text-muted mb-0">@lang('Payment Status') :</p>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-0">{{ __($order->payment_status) }}</h6>
                                    </div>
                                </div>
                            @endisset
                        </div>
                    </div><!--end card-->
                </div>
            </div>
        </div><!--end col-->
        <div class="col-xl-3">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        <h5 class="card-title flex-grow-1 mb-0"><i
                                class="ri-loop-left-line align-bottom me-1 text-muted"></i> @lang('translation.Order Status')
                        </h5>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('orders.changeStatus', $order->id) }}">
                        @csrf
                        <div class="row">
                            <div class="mb-3">
                                <select id="status" class="js-example-basic-single" name="status">
                                    <option value="" disabled>@lang('translation.Status')</option>
                                    @foreach(\App\Models\Order::STATUS as $status)
                                        <option
                                            value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>{{ __($status) }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    @lang('Please Choose a value')
                                </div>
                            </div>
                            <div class="text-end mb-3">
                                <button type="submit" class="btn btn-success w-sm">@lang('Change')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!--end card-->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i
                            class="ri-book-line align-bottom me-1 text-muted"></i>يانات الطلب</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">تاريخ أنشاء الطلب :</p>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0">{{ \Carbon\Carbon::parse($order->created_at)->toDateString() }}
                                &nbsp; {{ \Carbon\Carbon::parse($order->created_at)->translatedFormat(__('date.time_format')) }}</h6>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">ملاحظات :</p>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0">
                                {{$order->notes}}
                            </h6>
                        </div>
                    </div>

                </div>
            </div><!--end card-->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i
                            class="ri-user-2-line align-bottom me-1 text-muted"></i> @lang('Customer Details')</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">@lang('User Name') :</p>
                        </div>
                        <div class="flex-grow-1 ms-2">
                           <a href="{{route('users.show', $order->user->id)}}"> <h6 class="mb-0">{{ $order->user->name  }}</h6></a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">@lang('Phone') :</p>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0">{{ $order->user->country_code }} - {{ $order->user->phone }}</h6>
                        </div>
                    </div>
                    @isset($order->user->email)
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <p class="text-muted mb-0">@lang('Email') :</p>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">{{ $order->user->email }}</h6>
                            </div>
                        </div>
                    @endisset
                </div>
            </div><!--end card-->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i
                            class="ri-user-2-line align-bottom me-1 text-muted"></i>ملاحظات عامة</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('orders.update.system_notes', $order->id) }}">
                        @csrf
                        <div class="row">
                            <div class="mb-3">
                                <textarea  required class="form-control" rows="5" name="system_notes" >{{$order->system_notes}}</textarea>
                            </div>
                            <div class="text-end mb-3">
                                <button type="submit" class="btn btn-success w-sm">حفظ</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!--end card-->

        </div><!--end col-->
    </div><!--end row-->

@endsection

@section('script')


    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>

    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>

    <script src="{{ URL::asset('build/js/app.js') }}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!--select2 cdn-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ URL::asset('build/js/pages/select2.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/custom.js') }}"></script>

@endsection

