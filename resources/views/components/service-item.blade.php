<td>
    <div class="d-flex">
        <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
            <img src="{{ $service->main_image }}" alt="" class="img-fluid d-block">
        </div>
        <div class="flex-grow-1 ms-3">
            <h5 class="fs-15"><a href="{{ route('services.edit', $service->id) }}" class="link-primary">{{ $service->title }}</a></h5>
        </div>
    </div>
</td>
<td>
    @php
        $itemOptions = $item->itemOptions()->get()->groupBy('product_id');
        $optionsPrice = 0;
    @endphp
    @foreach($itemOptions as $options)
        @foreach($options as $option)
            <p class="text-muted mb-0">
                @if($loop->first)
                    <span class="text-primary">
                        <b>@lang('Product') :</b>
                    ( {{ @optional($option->product)->title }} )
                    </span>
                    <br>
                @endif
                * <b>{{ $option->attribute_title }} :</b>
                <span class="fw-medium">{{ $option->option_title }}</span>
                ( <span class="fw-medium">{{ $option->additional_price }}</span> ) @lang('SAR')
                @php
                    $optionsPrice += $option->additional_price
                @endphp
            </p>
        @endforeach
            <br>
    @endforeach
</td>
{{--<td> @lang('Service') </td>--}}
<td> {{ $item->total_price }} @lang('SAR') </td>
<td> {{ $item->quantity }} </td>
<td class="fw-medium text-end">
    {{ ( ($item->total_price + $optionsPrice) * $item->quantity ) ?? 0 }} @lang('SAR')
</td>
