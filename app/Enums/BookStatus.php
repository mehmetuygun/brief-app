<?php

namespace App\Enums;

enum BookStatus: string
{
    case AVAILABLE = 'available';
    case OUT_WITH_A_MEMBER = 'out_with_a_member';
}
