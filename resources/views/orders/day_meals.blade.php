@extends('layouts.master')
@section('title')
    وجبات اليوم
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
                <h4 class="mb-sm-0 font-size-18">وجبات اليوم</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">  @lang('Home')</a></li>
                        <li class="breadcrumb-item"><a href="{{route('orders.index')}}">  الحجوزات</a></li>
                        <li class="breadcrumb-item"><a href="{{route('orders.show',$order->id)}}">  تفاصيل الحجز</a></li>
                            <li class="breadcrumb-item active">وجبات اليوم</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->


    <div class="row">
        @foreach($data as $row)
            @php
                $meal_category = \App\Models\MealCategory::where('meal_id', $row->meal->id)->where('category_id', $row->user_plan_day->user_plan->plan_package_day->plan_package->plan_category->category_id)->first();
       if ($meal_category) {
           $calories = $meal_category->calories;
       } else {
           $calories = 0;
       }
            @endphp
        <div class="col-xl-3 col-md-6">
            <div class="card card-height-100">
                <div class="card-body">
{{--                    <div class="dropdown float-end">--}}
{{--                        <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                            <span class="text-muted fs-18"><i class="mdi mdi-dots-vertical"></i></span>--}}
{{--                        </a>--}}
{{--                        <div class="dropdown-menu dropdown-menu-end">--}}
{{--                            <a class="dropdown-item" href="#!">Favorite</a>--}}
{{--                            <a class="dropdown-item" href="#!">Apply Now</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="mb-4 pb-2">
                        <img src="{{$row->meal->image}}" alt="" class="avatar-sm">
                    </div>
                    <h6 class="fs-15 fw-semibold">{{$row->meal->title}}</h6>
                    <p class="text-muted mb-0">{{$row->meal->description}} </p>

                    <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="{{$calories}}">{{$calories}}</span></h2>
                    <span>كالوري</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

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

