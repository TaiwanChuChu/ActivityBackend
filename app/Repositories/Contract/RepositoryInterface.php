<?php

namespace App\Repositories\Contract;

use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    public function findById(int $id): Model;
}
