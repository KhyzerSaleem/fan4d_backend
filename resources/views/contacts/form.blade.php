@extends('layouts.master')
@section('title')
    {{ $title }}
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

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <!-- end card header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0">
                            <tbody>
                            <tr>
                                <th class="ps-0" scope="row">الاسم :</th>
                                <td class="text-muted">{{$data->first_name}}</td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">البريد الإلكتروني :</th>
                                <td class="text-muted">{{$data->email}}</td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">عنوان الرسالة :</th>
                                <td class="text-muted">{{$data->subject}}</td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">محتوى الرسالة :</th>
                                <td class="text-muted">{{$data->message}}</td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">شوهد في :</th>
                                <td class="text-muted">{{$data->seen_at?->translatedformat('Y-m-d g:i a')}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

@endsection


