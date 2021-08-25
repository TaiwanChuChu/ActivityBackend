<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityBasic;
use Illuminate\Http\Response;
use App\Http\Requests\ActivityBasicRequest;
use App\Http\Resources\ActivityBasicResource;
use App\Http\Resources\ActivityBasicCollection;
use App\Models\ActivityType;

class ActivityBasicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $source = ActivityBasic::with('activityType');
        request()->merge(['total' => $source->count()]);

        return new ActivityBasicCollection($source->skip(0)->take(10)->orderBy('id')->get());
    }

    public function filter(Request $request) 
    {
        $source = ActivityBasic::with('activityType');

        if($request->filled('searchCondition.q_theme')) {
            $source->where('theme', 'like', '%' . $request->searchCondition['q_theme'] . '%');
        }

        if($request->filled('searchCondition.q_activityType')) {
            $source->where('activity_type_id', '=', $request->searchCondition['q_activityType']);
            // return response()->json(['data~' => $source->get()->toArray(), 'query' => $source->toSql(), 'bindings' => $source->getBindings()], 200);
        }

        if($request->filled('searchCondition.q_apply_sdate')) {
            $source->where('apply_sdate', '>=', $request->searchCondition['q_apply_sdate']);
        }

        if($request->filled('searchCondition.q_apply_edate')) {
            $source->where('apply_edate', '<=', $request->searchCondition['q_apply_edate']);
        }

        if($request->filled('searchCondition.q_sdate')) {
            $source->where('sdate', '>=', $request->searchCondition['q_sdate']);
        }

        if($request->filled('searchCondition.q_edate')) {
            $source->where('edate', '<=', $request->searchCondition['q_edate']);
        }
        
        $options = $request->options;
        $activityTypeOp = ActivityType::where('state', '=', true)->select('id AS value', 'type_name AS text')->get()->toArray();

        $request->merge(['total' => $source->count()]);
        $request->merge(['activityTypeOption' => array_merge([['value' => false, 'text' => '全部']], $activityTypeOp)]);

        $sortDesc = $options['sortDesc'] ? $options['sortDesc'][0] : true;
        $sortBy = $options['sortBy'] ? $options['sortBy'][0] : 'id';

        $page = $options['page'] ?? 0;
        $itemPage = $options['itemsPerPage'] ?? 10;
        $skip = $page > 1 ? ($page - 1) * $itemPage : 0;
        // return response()->json(['data~' => $source->get()->toArray(), 'skip' => $skip, 'itemPage' => $itemPage], 200);

        return new ActivityBasicCollection($source->skip($skip)->take($itemPage)->orderBy($sortBy, ($sortDesc ? 'DESC' : 'ASC'))->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActivityBasicRequest $request)
    {
        $result = ActivityBasic::insert($request->all());
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
        return ActivityBasic::findOrFail($id)->toJson();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActivityBasicRequest $request, $id)
    {
        $result = ActivityBasic::where('id', '=', $id)->update($request->all());
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
        $result = ActivityBasic::where('id', '=', $id)->delete();
        if($result) {
            return response()->json(['status' => 'ok', 'code' => Response::HTTP_OK, 'message' => '資料刪除成功!'], Response::HTTP_OK);
        }
        return response()->json(['status' => 'ok', 'code' => Response::HTTP_BAD_REQUEST, 'message' => '資料刪除失敗!'], Response::HTTP_BAD_REQUEST);
    }
}
