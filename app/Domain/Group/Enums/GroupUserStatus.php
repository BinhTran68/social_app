<?php

namespace App\Domain\Group\Enums;

enum GroupUserStatus:string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
}
