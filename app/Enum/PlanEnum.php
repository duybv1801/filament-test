<?php

namespace App\Enum;

enum PlanEnum:int
{
    case HAVE_PLAN = 1;
    case NOT_PLAN = 0;


    public static function toArray(): array
    {
        return array_column(PlanEnum::cases(), 'value');
    }    
}

