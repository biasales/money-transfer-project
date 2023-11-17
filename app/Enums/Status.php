<?php

namespace App\Enums;

enum Status: int
{
    case PENDING = 1;
    case APPROVED = 2;
    case CANCELLED = 3;
}