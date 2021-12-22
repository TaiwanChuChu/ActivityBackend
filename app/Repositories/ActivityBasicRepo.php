<?php

namespace App\Repositories;

use App\Models\ActivityBasic;
use App\Repositories\Contract\ActivityBasicRepositoryInterface;

class ActivityBasicRepo extends Repository implements ActivityBasicRepositoryInterface
{

    public function model(): string
    {
        return ActivityBasic::class;
    }

}
