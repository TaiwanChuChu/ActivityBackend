<?php

namespace App\Http\Services\A01;

use App\Components\IDataTable;
use App\Http\Resources\ActivityTypeCollection;
use App\Http\Resources\ActivityTypeResource;
use App\Models\ActivityType;
use App\Repositories\Contract\ActivityTypeRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class A01110Services
{
    /**
     * @var ActivityTypeRepositoryInterface
     */
    private $_activityTypeRepo;

    public function __construct(ActivityTypeRepositoryInterface $activityTypeRepository)
    {
        $this->_activityTypeRepo = $activityTypeRepository;
    }

    public function filter($where)
    {
        return $this->_activityTypeRepo->filter($where);
    }

    public function store(array $data)
    {
        return $this->_activityTypeRepo->create($data);
    }

    public function show($id)
    {
        return $this->_activityTypeRepo->findById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update($data, $id)
    {
        return $this->_activityTypeRepo->update($data, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->_activityTypeRepo->delete($id);
    }

    public function deleteMulti($ids)
    {
        return $this->_activityTypeRepo->deleteMulti($ids);
    }

}
