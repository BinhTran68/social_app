<?php

namespace App\Domain\Group\Enum;

enum GroupUserRole:string
{
    case ADMIN = 'admin' ;
    case SUB_ADMIN = 'sub_admin';
    case USER = 'user';
}
