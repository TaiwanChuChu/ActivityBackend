<?php

namespace App\Repositories;

use App\Repositories\Contract\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

abstract class Repository implements RepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * Instantiate a new repository instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = app($this->model());
    }

    /**
     * @return string
     */
    abstract public function model(): string;

    public function findById(int $id): Model
    {
        return $this->model->findOrFail($id);
    }

    public function exists($id): bool
    {
        return !$this->findById($id) instanceof ModelNotFoundException;
    }

    public function create(array $data): bool
    {
        return $this->model->create($data) instanceof \Illuminate\Database\Eloquent\Model;
    }

    public function update(array $data, $id): bool
    {
        return tap($this->model->where($this->model->getKeyName(), '=', $id)->first(),
                function ($instance) use ($data) {
                    if ($instance) {
                        $instance->fill($data)->save();
                    }
                }) != null;
    }

    public function delete($id): bool
    {
        return $this->model->destroy($id) > 0;
    }

    public function deleteMulti(array $ids): bool
    {
        if (count($ids) <= 0) {
            return false;
        }
        return $this->model->destroy($ids) > 0;
    }
}
