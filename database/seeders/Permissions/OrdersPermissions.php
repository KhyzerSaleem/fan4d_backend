<?php

return [
    [
        'name' => 'orders_list',
        'display_name_ar' => 'قائمة الطلبات',
        'display_name_en' => 'List Orders',
        'model' => \App\Models\Order::class,
    ],
    [
        'name' => 'orders_show_details',
        'display_name_ar' => 'تفاصيل الطلب',
        'display_name_en' => 'Order Details',
        'model' => \App\Models\Order::class,
    ],
    [
        'name' => 'orders_print_invoice',
        'display_name_ar' => 'طباعة الفاتورة',
        'display_name_en' => 'Print Invoice',
        'model' => \App\Models\Order::class,
    ],
    [
        'name' => 'orders_change_status',
        'display_name_ar' => 'تغيير الحالة',
        'display_name_en' => 'Change Status',
        'model' => \App\Models\Order::class,
    ],
];
