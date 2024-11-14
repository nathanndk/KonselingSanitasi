<?php

namespace App\Enums;

enum EducationLevel: string
{
    case NO_SCHOOL = 'Tidak Sekolah';
    case ELEMENTARY = 'Tamat SD';
    case JUNIOR_HIGH = 'SMP';
    case HIGH_SCHOOL = 'SMA';
    case DIPLOMA_III = 'DIII';
    case DIPLOMA_IV = 'DIV';
    case BACHELOR = 'S1';
    case MASTER = 'S2';
    case DOCTORATE = 'S3';
}
