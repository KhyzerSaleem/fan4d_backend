<?php

namespace App\Enums;

enum NotificationActionEnum: string
{
    case General = 'general';
    case Change_status = 'change_status';
    case manual_send = 'manual_send';
    case notify_end_reservation = 'notify_end_reservation';

}
