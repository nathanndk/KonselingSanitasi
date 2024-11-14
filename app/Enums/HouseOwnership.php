<?php

namespace App\Enums;

enum HouseOwnership: string
{
    case SENDIRI = 'sendiri';
    case ORANGTUA = 'orangtua';
    case DINAS = 'dinas';
    case KONTRAK = 'kontrak';
}
