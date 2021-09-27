<?php

namespace App\Http\Controllers;

use App\Models\ActivityType;
use Illuminate\Http\Request;
use App\Models\ActivityApply;
use App\Models\ActivityBasic;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\ActivityApplyRequest;
use App\Http\Resources\ActivityAppliesResource;
use App\Http\Resources\ActivityAppliesCollection;

class ActivityApplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $source = ActivityApply::with('activityBasics')->where('user_id', '=', auth()->user()->id);
        return new ActivityAppliesCollection($source->get());
    }

    public function filter(Request $request)
    {
        $with = [
            'activityBasics' => function ($query) use ($request) {
                $this->extracted($request, $query);
            },
            'activityTypes' => function ($query) use ($request) {
                if ($request->filled('searchCondition.type_code')) {
                    $query->where('type_code', 'like', '%' . $request->searchCondition['type_code'] . '%');
                }
                $query->where('state', '=', '1');
            },
        ];
        $source = ActivityApply::with($with)
            ->whereHas('activityBasics', function ($query) use ($request) {
                $this->extracted($request, $query);
            })
            ->whereHas('activityTypes', function ($query) use ($request) {
                if ($request->filled('searchCondition.type_code')) {
                    $query->where('type_code', 'like', '%' . $request->searchCondition['type_code'] . '%');
                }
                $query->where('state', '=', '1');
            })
            ->where('user_id', '=', auth()->user()->id);

        $options = $request->options;

        $activityTypeOp = ActivityType::where('state', '=', true)->select('id AS value', 'type_name AS text')->get()->toArray();

        $request->merge(['total' => $source->count()]);
        $request->merge(['activityTypeOption' => array_merge([['value' => false, 'text' => '全部']], $activityTypeOp)]);

        $sortDesc = $options['sortDesc'] ? $options['sortDesc'][0] : true;
        $sortBy = $options['sortBy'] ? $options['sortBy'][0] : 'id';

        $page = $options['page'] ?? 0;
        $itemPage = $options['itemsPerPage'] ?? 10;
        $skip = $page > 1 ? ($page - 1) * $itemPage : 0;

//        return response()->json(['ss' => $source->skip($skip)->take($itemPage)->orderBy($sortBy, ($sortDesc ? 'DESC' : 'ASC'))->get()], Response::HTTP_OK);

        return (new ActivityAppliesCollection($source->skip($skip)->take($itemPage)->orderBy($sortBy, ($sortDesc ? 'DESC' : 'ASC'))->get()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActivityApplyRequest $request)
    {
        $result = ActivityApply::insert(['activity_id' => $request->activity_id, 'CreateID' => auth()->user()->id, 'user_id' => auth()->user()->id]);
        if ($result) {
            return response()->json(['status' => 'ok', 'code' => Response::HTTP_OK, 'message' => '資料新增成功!'], Response::HTTP_OK);
        }
        return response()->json(['status' => 'ok', 'code' => Response::HTTP_BAD_REQUEST, 'message' => '資料新增失敗!'], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ActivityApply::findOrFail($id)->toJson();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActivityApplyRequest $request, $id)
    {
        $result = ActivityApply::where('id', '=', $id)->update($request->all());
        if ($result) {
            return response()->json(['status' => 'ok', 'code' => Response::HTTP_OK, 'message' => '資料更新成功!'], Response::HTTP_OK);
        }
        return response()->json(['status' => 'ok', 'code' => Response::HTTP_BAD_REQUEST, 'message' => '資料更新失敗!'], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = ActivityApply::where('id', '=', $id)->delete();
        if ($result) {
            return response()->json(['status' => 'ok', 'code' => Response::HTTP_OK, 'message' => '資料刪除成功!'], Response::HTTP_OK);
        }
        return response()->json(['status' => 'ok', 'code' => Response::HTTP_BAD_REQUEST, 'message' => '資料刪除失敗!'], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param Request $request
     * @param $query
     */
    public function extracted(Request $request, $query): void
    {
        if ($request->filled('searchCondition.q_theme')) {
            $query->where('theme', 'like', '%' . $request->searchCondition['q_theme'] . '%');
        }
        if ($request->filled('searchCondition.q_activityType')) {
            $query->where('activity_type_id', '=', $request->searchCondition['q_activityType']);
        }
        if ($request->filled('searchCondition.q_apply_sdate')) {
            $query->where('apply_sdate', '>=', $request->searchCondition['q_apply_sdate']);
        }
        if ($request->filled('searchCondition.q_apply_edate')) {
            $query->where('apply_edate', '<=', $request->searchCondition['q_apply_edate']);
        }
        if ($request->filled('searchCondition.q_sdate')) {
            $query->where('sdate', '>=', $request->searchCondition['q_sdate']);
        }
        if ($request->filled('searchCondition.q_edate')) {
            $query->where('edate', '<=', $request->searchCondition['q_edate']);
        }
    }
}
