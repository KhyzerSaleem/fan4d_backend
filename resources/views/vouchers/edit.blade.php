@include('vouchers.form',[
    'title' => __('Edit Voucher'),
    'route' => route('vouchers.update',$voucher->id)
    ])
