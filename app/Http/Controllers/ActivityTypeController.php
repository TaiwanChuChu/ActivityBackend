<?php

namespace App\Http\Controllers;

use App\Models\ActivityType;
use App\Models\User;
use App\Repositories\ActivityTypeRepo;
use App\Repositories\Contract\ActivityTypeRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\ActivityTypeResource;
use App\Http\Requests\ActivityTypeRequest;
use App\Http\Resources\ActivityTypeCollection;
use Illuminate\Support\Facades\Log;

class ActivityTypeController extends Controller
{
    /**
     * @var ActivityTypeRepo
     */
    private $activityTypeRepo;

    public function __construct(ActivityTypeRepositoryInterface $activityTypeRepository)
    {
        $this->activityTypeRepo = $activityTypeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = ActivityType::all();

        return (new ActivityTypeCollection(ActivityType::all()))->additional([
            'status' => 'ok',
            'code' => Response::HTTP_OK,
        ])->response()->setStatusCode(200);
    }

    public function filter(Request $request)
    {
        $source = ActivityType::query();

        if ($request->filled('searchCondition.q_type_name')) {
            $source->where('type_name', 'like', '%' . $request->searchCondition['q_type_name'] . '%');
        }

        $options = $request->options;

        $request->merge(['total' => $source->count()]);
        $sortDesc = $options['sortDesc'] ? $options['sortDesc'][0] : true;
        $sortBy = $options['sortBy'] ? $options['sortBy'][0] : 'id';

        $page = $options['page'] ?? 0;
        $itemPage = $options['itemsPerPage'] ?? 10;
        $skip = $page > 1 ? ($page - 1) * $itemPage : 0;


        return (new ActivityTypeCollection($source->skip($skip)->take($itemPage)->orderBy($sortBy, ($sortDesc ? 'DESC' : 'ASC'))->get()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ActivityTypeRequest $request): JsonResponse
    {
        $data = $request->only('type_code', 'type_name', 'state');

        if ($this->activityTypeRepo->create($data)) {
            return response()->json(['status' => 'ok', 'code' => Response::HTTP_OK, 'message' => '資料新增成功!'], Response::HTTP_OK);
        }
        return response()->json(['status' => 'ok', 'code' => Response::HTTP_BAD_REQUEST, 'message' => '資料新增失敗!'], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return ActivityTypeResource
     */
    public function show($id)
    {
        return (new ActivityTypeResource($this->activityTypeRepo->findById($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActivityTypeRequest $request, $id)
    {
        $data = $request->only('type_name', 'state');
//        $result = ActivityType::where('id', '=', $id)->update($data);
        if ($this->activityTypeRepo->update($id, $data)) {
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
        if ($this->activityTypeRepo->delete($id)) {
            return response()->json(['status' => 'ok', 'code' => Response::HTTP_OK, 'message' => '資料刪除成功!'], Response::HTTP_OK);
        }
        return response()->json(['status' => 'ok', 'code' => Response::HTTP_BAD_REQUEST, 'message' => '資料刪除失敗!'], Response::HTTP_BAD_REQUEST);
    }
}
