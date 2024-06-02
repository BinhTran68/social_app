<?php

namespace App\Domain\Group\Enum;

enum GroupUserStatus:string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
}
