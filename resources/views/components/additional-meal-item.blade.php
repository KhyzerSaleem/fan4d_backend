<td colspan="4">
    <div class="d-flex">
        <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
            <img src="{{ $data->additional_meal->image }}" alt="" class="img-fluid d-block">
        </div>
        <div class="flex-grow-1 ms-3">
            <h5 class="fs-15">{{ $data->additional_meal->title }}</h5>
            <h6 class="fs-15">{{ \Illuminate\Support\Str::limit($data->additional_meal->description,30) }}</h6>
        </div>
    </div>
</td>
<td>
    {{ $data->price}} @lang('SAR')
</td>

