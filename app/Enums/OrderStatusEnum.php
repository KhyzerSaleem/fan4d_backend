<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case IN_WAY = 'in_way';

    case COMPLETE = 'complete';
    case CANCELLED = 'cancelled';
}
