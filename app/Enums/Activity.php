<?php

namespace App\Enums;

enum Activity: string
{
    case Login = 'login';
    case Logout = 'logout';
}
