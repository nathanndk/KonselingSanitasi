<?php

namespace App\Enums;

enum TingkatResiko: string
{
    case Rendah = 'R';
    case Sedang = 'S';
    case Tinggi = 'T';
    case SangatTinggi = 'ST';

    public static function getValues(): array
    {
        return [
            self::Rendah->value,
            self::Sedang->value,
            self::Tinggi->value,
            self::SangatTinggi->value,
        ];
    }
}
