<?php

namespace App\Http\Controllers;

use App\Repositories\ActivityTypeRepo;
use App\Repositories\Contract\ActivityBasicRepositoryInterface;
use App\Repositories\Contract\ActivityTypeRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\ActivityBasic;
use Illuminate\Http\Response;
use App\Http\Requests\ActivityBasicRequest;
use App\Http\Resources\ActivityBasicResource;
use App\Http\Resources\ActivityBasicCollection;
use App\Models\ActivityType;
use Illuminate\Support\Facades\DB;

class ActivityBasicController extends Controller
{
    private $_activityTypeRepo;
    private $_activityBasicRepo;

    public function __construct(
        ActivityTypeRepositoryInterface    $activityTypeRepo
        , ActivityBasicRepositoryInterface $activityBasicRepo
    )
    {
        $this->_activityTypeRepo = $activityTypeRepo;
        $this->_activityBasicRepo = $activityBasicRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $source = ActivityBasic::with('activityType');
        request()->merge(['total' => $source->count()]);

        return (new ActivityBasicCollection($source->skip(0)->take(10)->orderBy('id')->get()))->additional(['fuck' => 'FUCK']);
    }

    public function create()
    {
        $form_source = [];
        $form_source['options']['activityOptions'] = $this->_activityTypeRepo->getActivityTypeOptions();
        return response()->json(['status' => 'ok', 'code' => Response::HTTP_OK, 'data' => $form_source], Response::HTTP_OK);
    }

    public function filter(Request $request)
    {
        $source = ActivityBasic::with([
            'activityType' => function ($query) use ($request) {
                if ($request->filled('searchCondition.q_activity_type_id')) {
                    $query->where('id', '=', $request->input('searchCondition.q_activity_type_id'));
                }
                $query->Enable();
            }
        ]);

        $source->whereHas('activityType', function ($query) use ($request) {
            if ($request->filled('searchCondition.q_activity_type_id')) {
                $query->where('id', '=', $request->input('searchCondition.q_activity_type_id'));
            }
            $query->Enable();
        })
            ->where(function ($query) use ($request) {
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
            });


        $options = $request->options;
        $activityTypeOp = $this->_activityTypeRepo->getActivityTypeOptions();

        $request->merge(['total' => $source->count()]);
        $request->merge(['activityTypeOption' => $activityTypeOp]);

        $sortDesc = $options['sortDesc'] ? $options['sortDesc'][0] : true;
        $sortBy = $options['sortBy'] ? $options['sortBy'][0] : 'id';

        $page = $options['page'] ?? 0;
        $itemPage = $options['itemsPerPage'] ?? 10;
        $skip = $page > 1 ? ($page - 1) * $itemPage : 0;

        return (new ActivityBasicCollection($source->skip($skip)->take($itemPage)->orderBy($sortBy, ($sortDesc ? 'DESC' : 'ASC'))->get()));
    }

    public function filter2(Request $request)
    {
        $source = ActivityBasic::with([
            'activityType' => function ($query) use ($request) {
                if ($request->filled('searchCondition.q_activity_type_id')) {
                    $query->where('id', '=', $request->input('searchCondition.q_activity_type_id'));
                }
                $query->Enable();
            }
        ]);

        $source->whereHas('activityType', function ($query) use ($request) {
            if ($request->filled('searchCondition.q_activity_type_id')) {
                $query->where('id', '=', $request->input('searchCondition.q_activity_type_id'));
            }
            $query->Enable();
        })
            ->where(function ($query) use ($request) {
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
                $query->whereNotExists(function($query){
                    $query->select(DB::raw('1'))
                        ->from('activity_applies')
                        ->whereColumn('activity_basics.id', 'activity_applies.activity_id')
                        ->where('activity_applies.user_id', '=', auth()->user()->id);
                });
            });


        $options = $request->options;
        $activityTypeOp = $this->_activityTypeRepo->getActivityTypeOptions();

        $request->merge(['total' => $source->count()]);
        $request->merge(['activityTypeOption' => $activityTypeOp]);

        $sortDesc = $options['sortDesc'] ? $options['sortDesc'][0] : true;
        $sortBy = $options['sortBy'] ? $options['sortBy'][0] : 'id';

        $page = $options['page'] ?? 0;
        $itemPage = $options['itemsPerPage'] ?? 10;
        $skip = $page > 1 ? ($page - 1) * $itemPage : 0;

        return (new ActivityBasicCollection($source->skip($skip)->take($itemPage)->orderBy($sortBy, ($sortDesc ? 'DESC' : 'ASC'))->get()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActivityBasicRequest $request)
    {
        $data = $request->only(
            'activity_type_id', 'theme', 'description', 'place'
            , 'apply_limit', 'apply_sdate', 'apply_edate', 'apply_state', 'sdate', 'edate'
        );

        if ($this->_activityBasicRepo->create($data)) {
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
        return (new ActivityBasicResource($this->_activityBasicRepo->findById($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActivityBasicRequest $request, $id)
    {
        $data = $request->only(
            'activity_type_id',
            'apply_edate',
            'apply_limit',
            'apply_sdate',
            'apply_state',
            'apply_state_text',
            'description',
            'edate',
            'place',
            'sdate',
            'theme'
        );

        if ($this->_activityBasicRepo->update($id, $data)) {
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
        if ($this->_activityBasicRepo->delete($id)) {
            return response()->json(['status' => 'ok', 'code' => Response::HTTP_OK, 'message' => '資料刪除成功!'], Response::HTTP_OK);
        }
        return response()->json(['status' => 'ok', 'code' => Response::HTTP_BAD_REQUEST, 'message' => '資料刪除失敗!'], Response::HTTP_BAD_REQUEST);
    }

    public function deleteMulti(Request $request) {
        if($request->exists('ids') === false) {
            return response()->json(['status' => 'ok', 'code' => Response::HTTP_BAD_REQUEST, 'message' => '資料刪除失敗!'], Response::HTTP_BAD_REQUEST);
        }

        if($this->_activityBasicRepo->deleteMulti($request->ids)) {
            return response()->json(['status' => 'ok', 'code' => Response::HTTP_OK, 'message' => '資料刪除成功!'], Response::HTTP_OK);
        }

        return response()->json(['status' => 'ok', 'code' => Response::HTTP_BAD_REQUEST, 'message' => '資料刪除失敗!'], Response::HTTP_BAD_REQUEST);
    }
}
