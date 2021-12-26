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

    public function getActivityTypeOptions(): array
    {
        return $this->model::Enable()->select('id AS value', 'type_name AS text')->get()->toArray();
    }


    public function filter(array $where): \Illuminate\Database\Eloquent\Builder
    {
        $source = ActivityType::query();
        $whereCollection = collect($where);

        if ($whereCollection->has('q_type_name')) {
            $source->where('type_name', 'like', '%' . $whereCollection->get('q_type_name', '') . '%');
        }

        return $source;
    }
}
