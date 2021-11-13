<?php

namespace App\Repositories;

use App\Models\ActivityType;
use App\Repositories\Contract\ActivityTypeRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ActivityTypeRepo extends Repository implements ActivityTypeRepositoryInterface
{
    public function model(): string
    {
        return ActivityType::class;
    }
}
