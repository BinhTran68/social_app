<?php

namespace App\Domain\Group\Controllers;

use App\Domain\Group\Actions\UpdateImageProfileAction;
use App\Domain\Group\Requests\UpdateImageGroupProfileRequest;
use App\Models\Group;

class GroupViewController
{

    public function updateImages(UpdateImageGroupProfileRequest $request, Group $group, UpdateImageProfileAction $updateImageProfileAction)
    {
        return $updateImageProfileAction->handle($request,$group);
    }
}
