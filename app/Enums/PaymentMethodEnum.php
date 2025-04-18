<?php

namespace App\Enums;

enum PaymentMethodEnum: string
{
    case CREDIT = 'credit';
    case CASH = 'cash';
    case APPLE = 'apple';
    case MADA = 'mada';
}
