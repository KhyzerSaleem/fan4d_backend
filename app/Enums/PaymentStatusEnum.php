<?php

namespace App\Enums;

enum PaymentStatusEnum: string
{
    case PARTIAL_PAID = 'partial_paid';
    case PAID = 'paid';
    case UNPAID = 'unpaid';
}
