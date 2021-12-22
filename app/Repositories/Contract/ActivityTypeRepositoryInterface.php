<?php

namespace App\Repositories\Contract;

//use Illuminate\Database\Eloquent\Model;

interface ActivityTypeRepositoryInterface
{
//    public function findByTypeCode(): Model;
    public function getActivityTypeOptions(): array;
}
