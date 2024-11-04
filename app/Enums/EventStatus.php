<?php

namespace App\Enums;


enum EventStatus:string
{
    case Cancelled = 'cancelled';
    case Pending = 'pending';
    case Approved = 'approved';
    case Completed = 'completed';
}
