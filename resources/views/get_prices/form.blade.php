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
                                <th class="ps-0" scope="row">اسم العميل :</th>
                                <td class="text-muted">{{$data->user->name}}</td>
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
                            <tr>
                                <th class="ps-0" scope="row">الملفات :</th>
                                <td class="text-muted" style="    display: flex;">
                                    @foreach($data->files as $file)
                                        <div style="    padding-left: 20px;">
                                            <a href="{{$file->file}}" target="_blank" download="{{basename($file->file)}}" >
                                                <div class="avatar-sm flex-shrink-0" >
                                            <span class="avatar-title bg-light rounded fs-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text text-primary icon-dual-primary"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                            </span>
                                                </div>
                                                {{--                    <span>{{basename($design->file)}}</span>--}}
                                            </a>
                                        </div>
                                    @endforeach
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end card body -->
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i
                            class="ri-user-2-line align-bottom me-1 text-muted"></i>رد الادارة</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('get_prices.reply', $data->id) }}">
                        @csrf
                        <div class="row">
                            <div class="mb-3">
                                <textarea  required class="form-control" rows="5" name="reply" >{{$data->reply}}</textarea>
                            </div>
                            <div class="text-end mb-3">
                                <button type="submit" class="btn btn-success w-sm">حفظ</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!--end card-->
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

@endsection


