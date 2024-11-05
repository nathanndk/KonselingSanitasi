<?php

// app/Enums/RoleUser.php

namespace App\Enums;

enum RoleUser: string
{
    case Admin = 'admin';
    case Kader = 'kader';
    case Petugas = 'petugas';
    case Puskesmas = 'puskesmas';
    case DinasKesehatan = 'dinas_kesehatan';
}
