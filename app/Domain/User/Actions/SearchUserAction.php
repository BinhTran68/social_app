<?php

namespace App\Domain\User\Actions;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class SearchUserAction
{
    public function findByField($field, $value): Builder
    {
        return User::query()->where($field, $value);
    }

    public function searchByKeyword($keyword):Builder
    {
        return User::where('name', 'like', "%$keyword%")
            ->orWhere('email', 'like', "%$keyword%")
            ->orWhere('username', 'like', "%$keyword%");
    }

}
