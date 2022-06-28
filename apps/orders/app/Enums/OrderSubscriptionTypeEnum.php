<?php

namespace App\Enums;

enum OrderSubscriptionTypeEnum: string
{

    case SENDER = "sender";
    case RECEIVER = "receiver";
    case EMPLOYER = "employer";
}
