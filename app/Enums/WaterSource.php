<?php

namespace App\Enums;

enum WaterSource: string
{
    case SUMUR = 'sumur';
    case PDAM = 'pdam';
    case AIR_HUJAN = 'air_hujan';
    case LAINNYA = 'lainnya';
}
