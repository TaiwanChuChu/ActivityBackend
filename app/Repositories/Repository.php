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
        return $this->findById($id) instanceof ModelNotFoundException || true;
    }

    public function create(array $data): bool
    {
        return $this->model->create($data) instanceof \Illuminate\Database\Eloquent\Model;
    }

    public function update($id, array $data): bool
    {
        if ($this->exists($id)) {
            $this->model->exists = true;
            $this->model->setTargetId($id);
            return $this->model->update($data);
        }
        return false;
    }

    public function delete($id): ?bool
    {
        if ($this->exists($id)) {
            $this->model->exists = true;
            $this->model->setTargetId($id);
            return $this->model->delete();
        }
        return false;
    }
}
