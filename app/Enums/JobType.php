<?php

namespace App\Enums;

enum JobType: string
{
    case PETANI = 'petani';
    case PNS = 'pns';
    case TNIPOLRI = 'tnipolri';
    case PEDAGANG = 'pedagang';
    case BURUH = 'buruh';
    case WIRASWASTA = 'wiraswasta';
    case SUPIR = 'supir';
}
