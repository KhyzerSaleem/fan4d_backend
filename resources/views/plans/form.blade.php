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
        @isset($data)
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
                                    <img src="{{URL::asset('build/images/flags/sa.svg')}}" alt="user-image"
                                         class="me-2 rounded" height="18">
                                    <span class="align-middle">@lang('Arabic')</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#english-data"
                                   role="tab">
                                    <img src="{{ URL::asset('build/images/flags/us.svg') }}" alt="user-image"
                                         class="me-2 rounded" height="20">
                                    <span class="align-middle">@lang('English')</span>
                                </a>
                            </li>
                        </ul>
                        <div class="flex-shrink-0">
                            <div class="form-check form-switch form-switch-right form-switch-md">
                                <label for="input-group-showcode" class="form-label text-muted">
                                    @lang('is_active')
                                </label>
                                <input class="form-check-input" name="is_active" value="1"
                                       {{ isset($data)  ? ($data->is_active ? 'checked' : '') : 'checked' }} type="checkbox"
                                       id="input-group-showcode">
                            </div>
                        </div>
                    </div>
                    <!-- end card header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="tab-content">
                                    <div class="tab-pane mb-3 active" id="arabic-data" role="tabpanel">
                                        <div class="mb-3">
                                            <label class="form-label"
                                                   for="manufacturer-name-input">@lang('Title Ar')</label>
                                            <input type="text" class="form-control" id="title_ar" name="title_ar"
                                                   placeholder="@lang('Enter Title Ar')"
                                                   value="{{ isset($data) ? $data->title_ar : old('title_ar') }}"
                                                   required>
                                            <div class="invalid-feedback">@lang('Please Enter a value')</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"
                                                   for="manufacturer-name-input">@lang('Description Ar')</label>
                                            <textarea type="text" class="form-control" id="desc_ar"
                                                      name="desc_ar">{{ isset($data) ? $data->desc_ar : old('desc_ar') }}</textarea>
                                            <div class="invalid-feedback">@lang('Please Enter a value')</div>
                                        </div>
                                        <!-- end row -->
                                    </div>
                                    <!-- end tab-pane -->

                                    <div class="tab-pane mb-3" id="english-data" role="tabpanel">
                                        <div class="mb-3">
                                            <label class="form-label"
                                                   for="manufacturer-name-input">@lang('Title En')</label>
                                            <input type="text" class="form-control" id="title_en" name="title_en"
                                                   placeholder="@lang('Enter Title En')"
                                                   value="{{ isset($data) ? $data->title_en : old('title_en') }}"
                                                   required>
                                            <div class="invalid-feedback">@lang('Please Enter a value')</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"
                                                   for="manufacturer-name-input">@lang('Description En')</label>
                                            <textarea type="text" class="form-control" id="desc_en"
                                                      name="desc_en">{{ isset($data) ? $data->desc_en : old('desc_en') }}</textarea>
                                            <div class="invalid-feedback">@lang('Please Enter a value')</div>
                                        </div>
                                        <!-- end row -->
                                    </div>

                                    <!-- end tab pane -->
                                </div>
                                <div class="mb-3">
                                    <div class="input-group">
                                                                    <span class="input-group-text"
                                                                          id="inputGroup-sizing-default">السعر الافتراضي</span>

                                        <input type="number" step="any" class="form-control"
                                               name="price" value="{{ isset($data) ? $data->price : old('price') }}"
                                               required
                                               aria-label="Sizing example input"
                                               placeholder="ادخل السعر الافتراضي"
                                               aria-describedby="inputGroup-sizing-default">

                                        <label class="input-group-text"
                                               for="inputGroupSelect02">ريال سعودي</label>
                                        <div
                                            class="invalid-feedback">@lang('Please Enter a value')</div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="project-thumbnail-img">@lang('Main image')</label>
                                    <input name="image" accept="image/*" type="file" class="dropify" data-height="100"
                                           @isset($data) data-default-file="{{ $data->image }}" @endisset/>
                                </div>
                                <!-- end tab content -->
                            </div>
                            <div class="col-md-6">

                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">صور الخطة</h4>
                                    </div><!-- end card header -->

                                    <div class="card-body">

                                        {{--                        <h5 class="fs-14 mb-1">@lang('translations.Product Images')</h5>--}}
                                        <p class="text-muted">اضف الصور الاضافية للخطة</p>

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
                                                                <img data-dz-thumbnail class="img-fluid rounded d-block"
                                                                     src="@isset($category) {{ $category->main_image }} @endisset"
                                                                     alt="Dropzone-Image"/>
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
                                                            <button data-dz-remove
                                                                    class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <!-- end dropzon-preview -->
                                    </div>
                                    <!-- end card body -->
                                </div>

                            </div>
                        </div>
                        <hr>
                        <h3>اختيار الوجبات</h3>
                        <ul class="nav nav-pills nav-customs nav-danger mb-3"
                            role="tablist">

                            @foreach(\App\Models\DayMealCount::active()->get() as $key => $day)
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link @if($key == 0) active @endif "
                                       data-bs-toggle="tab"
                                       href="#plan_day_meals_tab_{{$day->id}}"
                                       role="tab"
                                       aria-selected="true">{{$day->title}}</a>
                                </li>
                            @endforeach

                        </ul>
                        <div class="tab-content text-muted">
                            @foreach(\App\Models\DayMealCount::active()->get() as $key => $day)
                                <div
                                    class="tab-pane @if($key == 0 ) active show @endif "
                                    id="plan_day_meals_tab_{{$day->id}}"
                                    role="tabpanel">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <i class="ri-checkbox-circle-fill text-success"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <span style="font-weight: bold;">@lang('meal count')</span>
                                            : {{ $day->meal_count }}
                                        </div>
                                    </div>
                                    <div class="d-flex mt-2">
                                        <div class="flex-shrink-0">
                                            <i class="ri-checkbox-circle-fill text-success"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <span style="font-weight: bold;">@lang('description')</span>
                                            : {{ $day->description }}
                                        </div>
                                    </div>
                                    <div class="d-flex mt-2">
                                        <div class="flex-shrink-0"
                                             style="padding-top: 10px;">
                                            <i class="ri-checkbox-circle-fill text-success"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <div class="row">
                                                <input type="hidden" name="plan_meals[{{$day->id}}][day_id]"
                                                       value="{{$day->id}}">
                                                @if(isset($data))
                                                    @php
                                                        $plan_day_meal_ids = \App\Models\PlanDayMeal::where('plan_id',$data->id)->where('day_id',$day->id)->get()->pluck('meal_id')->toArray();

                                                    @endphp

                                                @endif
                                                @for($i = 1 ; $i <= $day->meal_count; $i++)

                                                    <div class="mb-3">
                                                        <div class="col-lg-12">
                                                            <h6 class="fw-semibold">الوجبة رقم {{$i}}</h6>
                                                            <select class="js-example-basic-multiple select2"
                                                                    name="plan_meals[{{$day->id}}][meal_ids][]">
                                                                @foreach(\App\Models\Meal::whereHas('categories')->active()->get() as $meal)
                                                                    @php
                                                                        // Check if meal ID is in the plan_day_meal_ids array
                                                                        $index = array_search($meal->id, $plan_day_meal_ids);
                                                                        $is_selected = $index !== false; // If index is found, the meal is selected

                                                                        // Remove the ID from the array after it's been checked
                                                                        if ($is_selected) {
                                                                            unset($plan_day_meal_ids[$index]);
                                                                        }
                                                                    @endphp
                                                                    <option value="{{$meal->id}}"
                                                                            @if(isset($data) )
                                                                                {{ $is_selected ? 'selected' : '' }}
                                                                        @endif
                                                                    >{{$meal->title}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                @endfor
                                            </div>
                                            {{--                                            <div class="row">--}}
                                            {{--                                                <div class="col-lg-4">--}}
                                            {{--                                                    <div class="input-group">--}}
                                            {{--                                                        @if(isset($data))--}}
                                            {{--                                                            @php--}}
                                            {{--                                                                $exists_day = \App\Models\PlanPackageDay::whereHas('plan_package',function ($w)  use($data,$category,$package){--}}
                                            {{--$w->whereHas('plan_category',function ($q) use($data,$category){--}}
                                            {{--                                                                                            $q->where('plan_id',$data->id)->where('category_id',$category->id);--}}
                                            {{--                                                                                        })->where('package_id',$package->id);--}}

                                            {{--})->where('day_meal_count_id', $day->id)->first();--}}
                                            {{--                                                            if(isset($exists_day)){--}}

                                            {{--                                                                $current_day_price = $exists_day->price;--}}

                                            {{--                                                            }else{--}}
                                            {{--                                                                $current_day_price = 0;--}}
                                            {{--                                                            }--}}
                                            {{--                                                            @endphp--}}
                                            {{--                                                        @endif--}}
                                            {{--                                                        <span class="input-group-text"--}}
                                            {{--                                                              id="inputGroup-sizing-default">@lang('The price')</span>--}}
                                            {{--                                                        <input type="hidden"--}}
                                            {{--                                                               name="day_prices[{{$category->id}}][{{$package->id}}][{{$day->id}}][day_id]"--}}
                                            {{--                                                               value="{{$day->id}}">--}}

                                            {{--                                                        <input type="number" step="any"--}}
                                            {{--                                                               class="form-control"--}}
                                            {{--                                                               name="day_prices[{{$category->id}}][{{$package->id}}][{{$day->id}}][day_price]"--}}
                                            {{--                                                               value="@if(isset($data)){{$current_day_price}}@else 0 @endif"--}}
                                            {{--                                                               required--}}
                                            {{--                                                               aria-label="Sizing example input"--}}
                                            {{--                                                               placeholder="ادخل السعر"--}}
                                            {{--                                                               aria-describedby="inputGroup-sizing-default">--}}

                                            {{--                                                        <label class="input-group-text"--}}
                                            {{--                                                               for="inputGroupSelect02">ريال--}}
                                            {{--                                                            سعودي</label>--}}
                                            {{--                                                        <div--}}
                                            {{--                                                            class="invalid-feedback">@lang('Please Enter a value')</div>--}}
                                            {{--                                                    </div>--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}
                                        </div>
                                    </div>


                                </div>
                            @endforeach
                        </div>
                        <hr>
                        <h3>الاقسام</h3>
                        <ul class="nav nav-tabs nav-justified nav-border-top nav-border-top-success mb-3"
                            role="tablist">
                            @foreach(\App\Models\Category::active()->get() as $key => $category)
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link @if($key == 0) active @endif " data-bs-toggle="tab"
                                       href="#nav-border-{{$category->id}}"
                                       role="tab" aria-selected="true">
                                        {{$category->title}}
                                    </a>
                                </li>
                            @endforeach

                        </ul>
                        <div class="tab-content text-muted">
                            @foreach(\App\Models\Category::active()->get() as $key => $category)
                                <input type="hidden" name="calories[{{$category->id}}][category_id]"
                                       value="{{$category->id}}">
                                <div class="tab-pane @if($key == 0) active show @endif "
                                     id="nav-border-{{$category->id}}" role="tabpanel">
                                    <h1> {{$category->title}}</h1>
                                    <div class="mb-3">
                                        <p class="mb-0">
                                            <span style="font-weight: bold;">@lang('description')</span> :
                                            {{$category->description}}
                                        </p>
                                    </div>
                                    {{--                                    <div class="row">--}}
                                    {{--                                        <div class="col-lg-4">--}}
                                    {{--                                            <div class="input-group">--}}
                                    {{--                                                <span class="input-group-text"--}}
                                    {{--                                                      id="inputGroup-sizing-default">@lang('Calories number')</span>--}}
                                    {{--                                                @if(isset($data))--}}
                                    {{--                                                    @php--}}
                                    {{--                                                        $exists_category = \App\Models\PlanCategory::where('plan_id', $data->id)->where('category_id',$category->id)->first();--}}
                                    {{--                                                    if(isset($exists_category)){--}}
                                    {{--                                                        $current_calory = $exists_category->calories;--}}
                                    {{--                                                    }else{--}}
                                    {{--                                                        $current_calory = 0;--}}
                                    {{--                                                    }--}}
                                    {{--                                                    @endphp--}}
                                    {{--                                                @else--}}
                                    {{--                                                    @php--}}
                                    {{--                                                        $current_calory = 0;--}}
                                    {{--                                                    @endphp--}}
                                    {{--                                                @endif--}}
                                    {{--                                                <input type="text" class="form-control"--}}
                                    {{--                                                       name="calories[{{$category->id}}][calory]"--}}
                                    {{--                                                       value="{{$current_calory}}"--}}
                                    {{--                                                       required--}}
                                    {{--                                                       aria-label="Sizing example input"--}}
                                    {{--                                                       placeholder="@lang('Enter quantity of calories')"--}}
                                    {{--                                                       aria-describedby="inputGroup-sizing-default">--}}

                                    {{--                                                <label class="input-group-text" for="inputGroupSelect02">جرام /--}}
                                    {{--                                                    الوجبة</label>--}}
                                    {{--                                                <div class="invalid-feedback">@lang('Please Enter a value')</div>--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div><div class="row">--}}
                                    {{--                                        <div class="col-lg-4">--}}
                                    {{--                                            <div class="input-group">--}}
                                    {{--                                                <span class="input-group-text"--}}
                                    {{--                                                      id="inputGroup-sizing-default">@lang('Calories number')</span>--}}
                                    {{--                                                @if(isset($data))--}}
                                    {{--                                                    @php--}}
                                    {{--                                                        $exists_category = \App\Models\PlanCategory::where('plan_id', $data->id)->where('category_id',$category->id)->first();--}}
                                    {{--                                                    if(isset($exists_category)){--}}
                                    {{--                                                        $current_calory = $exists_category->calories;--}}
                                    {{--                                                    }else{--}}
                                    {{--                                                        $current_calory = 0;--}}
                                    {{--                                                    }--}}
                                    {{--                                                    @endphp--}}
                                    {{--                                                @else--}}
                                    {{--                                                    @php--}}
                                    {{--                                                        $current_calory = 0;--}}
                                    {{--                                                    @endphp--}}
                                    {{--                                                @endif--}}
                                    {{--                                                <input type="text" class="form-control"--}}
                                    {{--                                                       name="calories[{{$category->id}}][calory]"--}}
                                    {{--                                                       value="{{$current_calory}}"--}}
                                    {{--                                                       required--}}
                                    {{--                                                       aria-label="Sizing example input"--}}
                                    {{--                                                       placeholder="@lang('Enter quantity of calories')"--}}
                                    {{--                                                       aria-describedby="inputGroup-sizing-default">--}}

                                    {{--                                                <label class="input-group-text" for="inputGroupSelect02">جرام /--}}
                                    {{--                                                    الوجبة</label>--}}
                                    {{--                                                <div class="invalid-feedback">@lang('Please Enter a value')</div>--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}
                                    <br>
                                    <h3>@lang('packages info')</h3>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div
                                                class="nav nav-pills flex-column nav-pills-tab custom-verti-nav-pills text-center"
                                                role="tablist" aria-orientation="vertical">
                                                @foreach(\App\Models\Package::active()->get() as $key => $package)
                                                    <a class="nav-link @if($key == 0 ) active show @endif "
                                                       id="custom-v-pills-home-tab"
                                                       data-bs-toggle="pill"
                                                       href="#package_tab_{{$package->id}}_{{$category->id}}"
                                                       role="tab"
                                                       aria-controls="custom-v-pills-home" aria-selected="true">
                                                        {{$package->title}}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div> <!-- end col-->
                                        <div class="col-lg-9">
                                            <div class="tab-content text-muted mt-3 mt-lg-0">
                                                @foreach(\App\Models\Package::active()->get() as $key => $package)
                                                    <div class="tab-pane fade @if($key == 0 ) active show @endif"
                                                         style="background-color: aliceblue;"
                                                         id="package_tab_{{$package->id}}_{{$category->id}}"
                                                         role="tabpanel" aria-labelledby="custom-v-pills-home-tab">
                                                        <div class="d-flex mb-4">
                                                            <div class="d-flex mt-2">
                                                                <div class="flex-shrink-0">
                                                                    <i class="ri-checkbox-circle-fill text-info"></i>
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <span
                                                                        style="font-weight: bold;">@lang('description')</span>
                                                                    : {{$package->description}}
                                                                </div>
                                                            </div>

                                                        </div>
                                                        @if(isset($data))
                                                            @php
                                                                $exists_package = \App\Models\PlanPackage::whereHas('plan_category',function ($q) use($data,$category){
                                                                                            $q->where('plan_id',$data->id)->where('category_id',$category->id);
                                                                                        })->where('package_id', $package->id)->first();
                                                            if(isset($exists_package)){

                                                                $current_start_price = $exists_package->start_price;

                                                            }else{
                                                                $current_start_price = 0;
                                                            }
                                                            @endphp
                                                        @endif
                                                        <input type="hidden"
                                                               name="package_prices[{{$category->id}}][{{$package->id}}][package_id]"
                                                               value="{{$package->id}}">
                                                        <div class="row">
                                                            {{--                                                            <div class="col-lg-4">--}}
                                                            {{--                                                                <div class="input-group">--}}
                                                            {{--                                                                    <span class="input-group-text"--}}
                                                            {{--                                                                          id="inputGroup-sizing-default">@lang('package price')</span>--}}
                                                            {{--                                                                   --}}


                                                            {{--                                                                    <input type="number" step="any" class="form-control"--}}
                                                            {{--                                                                           name="package_prices[{{$category->id}}][{{$package->id}}][price]"--}}
                                                            {{--                                                                           value="@if(isset($data)){{$current_start_price}}@else 0 @endif"--}}
                                                            {{--                                                                           required--}}
                                                            {{--                                                                           aria-label="Sizing example input"--}}
                                                            {{--                                                                           placeholder="ادخل سعر الباقة"--}}
                                                            {{--                                                                           aria-describedby="inputGroup-sizing-default">--}}

                                                            {{--                                                                    <label class="input-group-text"--}}
                                                            {{--                                                                           for="inputGroupSelect02">ريال سعودي</label>--}}
                                                            {{--                                                                    <div--}}
                                                            {{--                                                                        class="invalid-feedback">@lang('Please Enter a value')</div>--}}
                                                            {{--                                                                </div>--}}
                                                            {{--                                                            </div>--}}
                                                        </div>

                                                        <br>
                                                        {{--                                                       //Here Days                                         --}}
                                                        <ul class="nav nav-pills nav-customs nav-danger mb-3"
                                                            role="tablist">

                                                            @foreach(\App\Models\DayMealCount::active()->get() as $key => $day)
                                                                <li class="nav-item" role="presentation">
                                                                    <a class="nav-link @if($key == 0) active @endif "
                                                                       data-bs-toggle="tab"
                                                                       href="#day_tab_{{$category->id}}_{{$day->id}}_{{$package->id}}"
                                                                       role="tab"
                                                                       aria-selected="true">{{$day->title}}</a>
                                                                </li>
                                                            @endforeach

                                                        </ul>
                                                        <div class="tab-content text-muted">
                                                            @foreach(\App\Models\DayMealCount::active()->get() as $key => $day)
                                                                <div
                                                                    class="tab-pane @if($key == 0 ) active show @endif "
                                                                    id="day_tab_{{$category->id}}_{{$day->id}}_{{$package->id}}"
                                                                    role="tabpanel">
                                                                    <div class="d-flex">
                                                                        <div class="flex-shrink-0">
                                                                            <i class="ri-checkbox-circle-fill text-success"></i>
                                                                        </div>
                                                                        <div class="flex-grow-1 ms-2">
                                                                            <span
                                                                                style="font-weight: bold;">@lang('meal count')</span>
                                                                            : {{ $day->meal_count }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-flex mt-2">
                                                                        <div class="flex-shrink-0">
                                                                            <i class="ri-checkbox-circle-fill text-success"></i>
                                                                        </div>
                                                                        <div class="flex-grow-1 ms-2">
                                                                            <span
                                                                                style="font-weight: bold;">@lang('description')</span>
                                                                            : {{ $day->description }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-flex mt-2">
                                                                        <div class="flex-shrink-0"
                                                                             style="padding-top: 10px;">
                                                                            <i class="ri-checkbox-circle-fill text-success"></i>
                                                                        </div>
                                                                        <div class="flex-grow-1 ms-2">
                                                                            <div class="row">
                                                                                <div class="col-lg-4">
                                                                                    <div class="input-group">
                                                                                        @if(isset($data))
                                                                                            @php
                                                                                                $exists_day = \App\Models\PlanPackageDay::whereHas('plan_package',function ($w)  use($data,$category,$package){
    $w->whereHas('plan_category',function ($q) use($data,$category){
                                                                                                                            $q->where('plan_id',$data->id)->where('category_id',$category->id);
                                                                                                                        })->where('package_id',$package->id);

})->where('day_meal_count_id', $day->id)->first();
                                                                                            if(isset($exists_day)){

                                                                                                $current_day_price = $exists_day->price;

                                                                                            }else{
                                                                                                $current_day_price = 0;
                                                                                            }
                                                                                            @endphp
                                                                                        @else
                                                                                            @php
                                                                                                $current_day_price = 0;
                                                                                            @endphp
                                                                                        @endif
                                                                                        <span class="input-group-text"
                                                                                              id="inputGroup-sizing-default">@lang('The price')</span>
                                                                                        <input type="hidden"
                                                                                               name="day_prices[{{$category->id}}][{{$package->id}}][{{$day->id}}][day_id]"
                                                                                               value="{{$day->id}}">

                                                                                        <input type="number" step="any"
                                                                                               class="form-control"
                                                                                               name="day_prices[{{$category->id}}][{{$package->id}}][{{$day->id}}][day_price]"
                                                                                               value="{{$current_day_price}}"
                                                                                               required
                                                                                               aria-label="Sizing example input"
                                                                                               placeholder="ادخل السعر"
                                                                                               aria-describedby="inputGroup-sizing-default">

                                                                                        <label class="input-group-text"
                                                                                               for="inputGroupSelect02">ريال
                                                                                            سعودي</label>
                                                                                        <div
                                                                                            class="invalid-feedback">@lang('Please Enter a value')</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div> <!-- end col-->
                                    </div>
                                </div>
                            @endforeach
                        </div>
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

    <!--select2 cdn-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{--    <script src="{{ URL::asset('build/js/pages/select2.init.js') }}"></script>--}}

    <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
    {{--    <script src="{{ URL::asset('build/js/pages/ecommerce-product-create.init.js') }}"></script>--}}

    <script src="{{ URL::asset('build/js/app.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/i18n/ar.js"></script>



    <script src="{{ URL::asset('build/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>

    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>

    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>

    <script src="{{ URL::asset('build/js/app.js') }}"></script>

    <script src="{{ URL::asset('build/js/select2/ar.js') }}"></script> <!-- Arabic language file -->


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
    <script>
        $('.dropify').dropify({
            messages: {
                'default': '{{ __('dropify_default') }}',
                'replace': '{{ __('dropify_replace') }}',
                'remove': '{{ __('dropify_remove') }}'
            }
        });

        var categoryExists = {{ isset($data) ? 'true' : 'false' }};
        if (!categoryExists) {
            $('#my-form').submit(function (event) {
                // validate image
                if (!$('.dropify').val()) {
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
            url: '{{ route('products.uploadGallery') }}',
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
            success: function (file, response) {
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
            error: function (file, errorMessage, xhr) {
                console.error("Error uploading image: " + errorMessage);
            }

        });
    </script>
    @isset($data)
        <script>

            // existing images
            let existingImages = @json($data->images);

            // Loop through each existing image
            existingImages.forEach(function (image) {
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
                `














                                                                                                                                                                                    ;

                                                                                                                                                                                                    // Append the preview template to the Dropzone preview area
                                                                                                                                                                                                    $('#dropzone-preview').append(previewTemplate);
                                                                                                                                                                                                });
</script>
        <script>
            // Add event listener to the remove buttons
            $(document).on('click', '.remove-image', function (event) {
                event.preventDefault();
                var imageContainer = $(this).closest('#dropzone-preview-list');
                var imageId = imageContainer.data('image-id');

                // Remove the image from the Dropzone preview
                dropzone.removeFile(imageContainer[0]);

                // Send an AJAX request to delete the image from the database
                $.ajax({
                    url: '{{ route('plans.removeGallery') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        image_id: imageId
                    },
                    success: function (response) {
                        // Handle success response if needed
                        var tostifyClass = "danger";
                        if (response.success) {
                            tostifyClass = "success";
                            imageContainer.remove();
                        }
                        tostify(response.message, tostifyClass);

                    },
                    error: function (xhr, status, error) {
                        // Handle error response if needed
                        console.log('asd');
                        tostify("{{ __('Operation Failed') }}", "danger");
                    }
                });
            });

        </script>
    @endisset

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

