<?php

namespace App\Enum;

enum StatusEnum:int
{
    case AWAITING_CENSORSHIP = 1;
    case WAIT_CONFIRM = 2;
    case CONFIRMED = 3;
    case REJECT = 4;
    case CANCEL = 5;


    public static function toArray(): array
    {
        return array_column(StatusEnum::cases(), 'value');
    }  
}
