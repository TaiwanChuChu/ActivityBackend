<?php

namespace App\Http\Controllers;

use App\Models\ActivityType;
use Illuminate\Http\Request;
use App\Models\ActivityApply;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ActivityTypeResource;
use App\Http\Requests\ActivityTypeRequest;
use App\Http\Resources\ActivityTypeCollection;

class ActivityTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return (new ActivityTypeCollection(ActivityType::all()))->additional([
            'status' => 'ok', 
            'code' => Response::HTTP_OK,
        ])->response()->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActivityTypeRequest $request)
    {
        $result = ActivityType::insert($request->all());
        
        if($result) {
            return response()->json(['status' => 'ok', 'code' => Response::HTTP_OK, 'message' => '資料新增成功!'], Response::HTTP_OK);
        }
        return response()->json(['status' => 'ok', 'code' => Response::HTTP_BAD_REQUEST, 'message' => '資料新增失敗!'], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return (new ActivityTypeResource(ActivityType::findOrFail($id)))->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActivityTypeRequest $request, $id)
    {
        $result = ActivityType::where('id', '=', $id)->update($request->all());
        if($result) {
            return response()->json(['status' => 'ok', 'code' => Response::HTTP_OK, 'message' => '資料更新成功!'], Response::HTTP_OK);
        }
        return response()->json(['status' => 'ok', 'code' => Response::HTTP_BAD_REQUEST, 'message' => '資料更新失敗!'], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = ActivityType::where('id', '=', $id)->delete();
        if($result) {
            return response()->json(['status' => 'ok', 'code' => Response::HTTP_OK, 'message' => '資料刪除成功!'], Response::HTTP_OK);
        }
        return response()->json(['status' => 'ok', 'code' => Response::HTTP_BAD_REQUEST, 'message' => '資料刪除失敗!'], Response::HTTP_BAD_REQUEST);
    }
}
