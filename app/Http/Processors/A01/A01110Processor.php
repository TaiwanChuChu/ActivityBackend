<?php

namespace App\Http\Processors\A01;

use App\Components\IDataTable;
use App\Contracts\IFormProcessor;
use App\Http\Resources\ActivityTypeCollection;
use App\Http\Resources\ActivityTypeResource;
use App\Http\Services\A01\A01110Services;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class A01110Processor implements IFormProcessor
{
    private $_A01110Services;

    /**
     * @var IDataTable
     */
    private $_dataTable;

    public function __construct(A01110Services $A01110Services, IDataTable $dataTable)
    {
        $this->_A01110Services = $A01110Services;
        $this->_dataTable = $dataTable;
    }

    public function filter(Request $request)
    {
        $where = $request->get('searchCondition', []);

        return $this->_dataTable->response($this->_A01110Services->filter($where), ActivityTypeCollection::class);
    }

    public function show($id)
    {
        return (new ActivityTypeResource($this->_A01110Services->show($id)));
    }

    public function edit($id)
    {
        // TODO: Implement edit() method.
    }

    public function store(Request $request)
    {
        $data = $request->only('type_code', 'type_name', 'state');

        if ($this->_A01110Services->store($data)) {
            return response()->json(['status' => 'ok', 'code' => Response::HTTP_OK, 'message' => '資料新增成功!'], Response::HTTP_OK);
        }
        return response()->json(['status' => 'ok', 'code' => Response::HTTP_BAD_REQUEST, 'message' => '資料新增失敗!'], Response::HTTP_BAD_REQUEST);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only('type_name', 'state');

        if ($this->_A01110Services->update($data, $id)) {
            return response()->json(['status' => 'ok', 'code' => Response::HTTP_OK, 'message' => '資料更新成功!'], Response::HTTP_OK);
        }
        return response()->json(['status' => 'ok', 'code' => Response::HTTP_BAD_REQUEST, 'message' => '資料更新失敗!'], Response::HTTP_BAD_REQUEST);
    }

    public function destroy($id)
    {
        if ($this->_A01110Services->destroy($id)) {
            return response()->json(['status' => 'ok', 'code' => Response::HTTP_OK, 'message' => '資料刪除成功!'], Response::HTTP_OK);
        }
        return response()->json(['status' => 'ok', 'code' => Response::HTTP_BAD_REQUEST, 'message' => '資料刪除失敗!'], Response::HTTP_BAD_REQUEST);
    }

    public function deleteMulti($request)
    {
        if ($request->exists('ids') === false) {
            return response()->json(['status' => 'ok', 'code' => Response::HTTP_BAD_REQUEST, 'message' => '資料刪除失敗!'], Response::HTTP_BAD_REQUEST);
        }

        if ($this->_A01110Services->deleteMulti($request->ids)) {
            return response()->json(['status' => 'ok', 'code' => Response::HTTP_OK, 'message' => '資料刪除成功!'], Response::HTTP_OK);
        }

        return response()->json(['status' => 'ok', 'code' => Response::HTTP_BAD_REQUEST, 'message' => '資料刪除失敗!'], Response::HTTP_BAD_REQUEST);
    }

    public function mapService()
    {
        // TODO: Implement mapService() method.
    }
}
