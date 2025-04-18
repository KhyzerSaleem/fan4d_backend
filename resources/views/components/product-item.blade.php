<tr class="border-top border-top-double">
    <td>
        <a href="{{ route('products.edit', $item->product->id) }}">
            <div class="d-flex">

                <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
                    <img src="{{ $item->product->image }}" alt="" class="img-fluid d-block">
                </div>
                <div class="flex-grow-1 ms-3">
                    <h5 class="fs-15">{{ $item->product->title }}</h5>
                    <h5 class="fs-15">{{ $item->product->category->title }}</h5>
                    <h6 class="fs-15">{{ \Illuminate\Support\Str::limit($item->product->description,30) }}</h6>
                </div>

            </div>
        </a>
    </td>
    <td>
        <div class="table-responsive">
            <table class="table table-borderless mb-0">
                <tbody>
                @foreach($item->options as $option)
                    <tr>
                        <th class="ps-0"
                            scope="row">{{$option->productAttributeOption->product_attribute->attribute->title}} :
                        </th>
                        <td class="text-muted">{{$option->productAttributeOption->title}}</td>
                        <td class="text-muted">{{$option->price}}  @lang('SAR')</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </td>
    <td>
        {{$item->product->price}}
    </td>
    <td>
        {{ $item->quantity}}
    </td>
    <td>
        {{ $item->count}}
    </td>
    <td> {{ $item->price ?? 0 }} @lang('SAR') </td>

</tr>
@if(isset($item->designs))

    <tr class="border-top border-top-double">
        <td>
            <h3>التصاميم</h3>
        </td>
        <td colspan="5" style="    display: flex;">
            @foreach($item->designs as $design)
                <div style="    padding-left: 20px;">
                <a href="{{$design->file}}" target="_blank" download="{{basename($design->file)}}" >
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

@endif
