<?php

namespace App\Domain\User\Action;

use App\Domain\User\Requests\UploadImageProfileRequest;
use App\Models\User;
use function Symfony\Component\String\u;

class UpdateImages
{


    public function handle(UploadImageProfileRequest $request, User $user)
    {

        if ($request->input('type') == 'cover') {
            $user->cover_path = $request->input('url');
        }
        if ($request->input('type') == 'avatar') {
            $user->avatar_path = $request->input('url');
        }
        $user->save();
        return $user;
    }

}
