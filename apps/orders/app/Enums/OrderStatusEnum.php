<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case CREATED = "created";
    case IN_TRANSIT = "in_transit";
    case IN_REALIZATION = "in_realization";
    case CANCELLED = "cancelled";
    case COMPLETED = "completed";
}
