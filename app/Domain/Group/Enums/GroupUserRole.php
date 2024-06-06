<?php

namespace App\Domain\Group\Enums;

enum GroupUserRole:string
{
    case ADMIN = 'admin' ;
    case SUB_ADMIN = 'sub_admin';
    case USER = 'user';
}
