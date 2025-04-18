@extends('layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/classic.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('build/css/custom.css') }}" />
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

    <div class="row justify-content-center">
        <div class="col-xxl-9">
            <div class="card" id="demo">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-header border-bottom-dashed p-4">
                            <div class="d-flex">
                                <div class="flex-grow-1">
{{--                                    <img src="{{ URL::asset('build/images/logo-dark.png') }}" class="card-logo card-logo-dark" alt="logo dark" height="17">--}}
{{--                                    <img src="{{ URL::asset('build/images/logo-light.png') }}" class="card-logo card-logo-light" alt="logo light" height="17">--}}
                                    <h1 style="font-weight: bolder">@lang('translation.Yamluck')</h1>
                                    <div class="mt-sm-5 mt-4">
                                        <h6 class="text-muted text-uppercase fw-semibold">@lang('translation.Address')</h6>
                                        <p class="text-muted mb-1" id="address-details">{{ optional($order->address)->address }}</p>
                                    </div>
                                </div>
                                <div class="flex-shrink-0 mt-sm-0 mt-3">
                                    <h6><span class="text-muted fw-normal">@lang('translation.registration_number'):</span>
                                        <span id="legal-register-no">{{ $settings['registration_number'] }}</span>
                                    </h6>
                                    <h6><span class="text-muted fw-normal">@lang('translation.email'):</span>
                                        <span id="email">{{ $settings['email'] }}</span>
                                    </h6>
                                    <h6><span class="text-muted fw-normal">@lang('translation.website'):</span> <a href="{{ $settings['website'] }}" class="link-primary" target="_blank" id="website">{{ $settings['website'] }}</a></h6>
                                    <h6 class="mb-0"><span class="text-muted fw-normal">@lang('translation.Contact No'): {{ $settings['phone'] }}</span><span id="contact-no">  </span></h6>
                                </div>
                            </div>
                        </div>
                        <!--end card-header-->
                    </div>
                    <!--end col-->
                    <div class="col-lg-12">
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-lg-4 col-4">
                                    <p class="text-muted mb-2 text-uppercase fw-semibold">@lang('translation.Invoice No')</p>
                                    <h5 class="fs-14 mb-0"><span id="invoice-no">{{ $order->order_num }}</span></h5>
                                </div>
                                <!--end col-->
                                <div class="col-lg-4 col-4">
                                    <p class="text-muted mb-2 text-uppercase fw-semibold">@lang('translation.Order Date')</p>
                                    <h5 class="fs-14 mb-0"><span id="invoice-date">{{ \Carbon\Carbon::parse($order->created_at)->toDateString() }}</span> </h5>
                                </div>
                                <div class="col-lg-4 col-4">
                                    <p class="text-muted mb-2 text-uppercase fw-semibold">@lang('translation.Order Time')</p>
                                    <h5 class="fs-14 mb-0"><span id="invoice-date">{{ localizedTime($order->created_at) }}</span> </h5>
                                </div>
                                <!--end col-->
                                <div class="col-lg-4 col-4">
                                    <p class="text-muted mb-2 text-uppercase fw-semibold">@lang('translation.Order Status')</p>
                                    @php
                                        if ($order->status == \App\Enums\OrderStatusEnum::PENDING->value) {
                                            $class = "bg-warning-subtle text-warning";
                                        }elseif ($order->status == \App\Enums\OrderStatusEnum::SHIPPED->value) {
                                            $class = "bg-primary-subtle text-primary";
                                        }elseif ($order->status == \App\Enums\OrderStatusEnum::DELIVERED->value) {
                                            $class = "bg-success-subtle text-success";
                                        }else {
                                            $class = "bg-danger-subtle text-danger";
                                        }
                                    @endphp
                                    <span class="badge {{$class}} fs-11" id="payment-status">{{ __('translation.'.$order->status) }}</span>
                                </div>
                                <div class="col-lg-4 col-4">
                                    <p class="text-muted mb-2 text-uppercase fw-semibold">@lang('translation.Payment Method')</p>
                                    <h5 class="fs-14 mb-0"><span id="invoice-date">{{ $order->payment_method }}</span> </h5>
                                </div>
                                <!--end col-->
                                <div class="col-lg-4 col-4">
                                    <p class="text-muted mb-2 text-uppercase fw-semibold">@lang('translation.Total Amount')</p>
                                    <h5 class="fs-14 mb-0">
                                        <span id="total-amount">{{ $order->total }}</span>
                                        @lang('translation.SAR')
                                    </h5>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end col-->
{{--                    <div class="col-lg-12">--}}
{{--                        <div class="card-body p-4 border-top border-top-dashed">--}}
{{--                            <div class="row g-3">--}}
{{--                                <div class="col-6">--}}
{{--                                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Billing Address</h6>--}}
{{--                                    <p class="fw-medium mb-2" id="billing-name">David Nichols</p>--}}
{{--                                    <p class="text-muted mb-1" id="billing-address-line-1">305 S San Gabriel Blvd</p>--}}
{{--                                    <p class="text-muted mb-1"><span>Phone: +</span><span id="billing-phone-no">(123) 456-7890</span></p>--}}
{{--                                    <p class="text-muted mb-0"><span>Tax: </span><span id="billing-tax-no">12-3456789</span> </p>--}}
{{--                                </div>--}}
{{--                                <!--end col-->--}}
{{--                                <div class="col-6">--}}
{{--                                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Shipping Address</h6>--}}
{{--                                    <p class="fw-medium mb-2" id="shipping-name">David Nichols</p>--}}
{{--                                    <p class="text-muted mb-1" id="shipping-address-line-1">305 S San Gabriel Blvd</p>--}}
{{--                                    <p class="text-muted mb-1"><span>Phone: +</span><span id="shipping-phone-no">(123) 456-7890</span></p>--}}
{{--                                </div>--}}
{{--                                <!--end col-->--}}
{{--                            </div>--}}
{{--                            <!--end row-->--}}
{{--                        </div>--}}
{{--                        <!--end card-body-->--}}
{{--                    </div>--}}
                    <!--end col-->
                    <div class="col-lg-12">
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                    <thead>
                                    <tr class="table-active">
                                        <th scope="col" style="width: 50px;">#</th>
                                        <th scope="col">@lang('translation.Room')</th>
                                        <th scope="col">@lang('translation.Item Price')</th>
                                        <th scope="col">@lang('translation.Quantity')</th>
                                        <th scope="col" class="text-end">@lang('translation.Total Amount')</th>
                                    </tr>
                                    </thead>
                                    <tbody id="products-list">
                                    @foreach($order->items as $key => $item)
                                        <tr>
                                            <th scope="row">{{ $key+1 }}</th>
                                            <td class="text-center">
                                                <span class="fw-medium">{{ optional($item->room->product)->title }}</span>
                                                <p class="text-muted mb-0">
                                                    @lang('translation.Gift'):
                                                    {{ optional($item->room->gift)->title }}
                                                </p>
                                            </td>
                                            <td>{{ $item->price }} @lang('translation.SAR')</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td class="text-end">{{ $item->price * $item->quantity }} @lang('translation.SAR')</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <!--end table-->
                            </div>
                            <div class="border-top border-top-dashed mt-2">
                                <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto" style="width:250px">
                                    <tbody>
                                    <tr>
                                        <td>@lang('translation.Sub Total') :</td>
                                        <td class="text-end">{{ $order->sub_total }} @lang('translation.SAR')</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('translation.Shipping Fees') :</td>
                                        <td class="text-end">{{ $order->shipping_fee }} @lang('translation.SAR')</td>
                                    </tr>
                                    <tr class="border-top border-top-dashed fs-15">
                                        <th scope="row">@lang('translation.Total') (@lang('translation.SAR')) :</th>
                                        <th class="text-end">{{ $order->total }} @lang('translation.SAR')</th>
                                    </tr>
                                    </tbody>
                                </table>
                                </table>
                                <!--end table-->
                            </div>
{{--                            <div class="mt-3">--}}
{{--                                <h6 class="text-muted text-uppercase fw-semibold mb-3">Payment Details:</h6>--}}
{{--                                <p class="text-muted mb-1">Payment Method: <span class="fw-medium" id="payment-method">Mastercard</span></p>--}}
{{--                                <p class="text-muted mb-1">Card Holder: <span class="fw-medium" id="card-holder-name">David Nichols</span></p>--}}
{{--                                <p class="text-muted mb-1">Card Number: <span class="fw-medium" id="card-number">xxx xxxx xxxx 1234</span></p>--}}
{{--                                <p class="text-muted">Total Amount: <span class="fw-medium" id="">$ </span><span id="card-total-amount">755.96</span></p>--}}
{{--                            </div>--}}
{{--                            <div class="mt-4">--}}
{{--                                <div class="alert alert-info">--}}
{{--                                    <p class="mb-0"><span class="fw-semibold">NOTES:</span>--}}
{{--                                        <span id="note">All accounts are to be paid within 7 days from receipt of invoice. To be paid by cheque or--}}
{{--                                        credit card or direct payment online. If account is not paid within 7--}}
{{--                                        days the credits details supplied as confirmation of work undertaken--}}
{{--                                        will be charged the agreed quoted fee noted above.--}}
{{--                                    </span>--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                                <a href="javascript:window.print()" class="btn btn-success"><i class="ri-printer-line align-bottom me-1"></i> @lang('translation.Print')</a>
{{--                                <a href="javascript:void(0);" class="btn btn-primary"><i class="ri-download-2-line align-bottom me-1"></i> Download</a>--}}
                            </div>
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
            </div>
            <!--end card-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->

@endsection

@section('script')


    <script src="{{ URL::asset('build/js/pages/invoicedetails.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>

@endsection

