<?php

namespace App\Http\Controllers;

use App\Contracts\IFormProcessor;
use App\Contracts\IFormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    private $_formProcessor;

    public function __construct(IFormProcessor $formProcessor)
    {
        $this->_formProcessor = $formProcessor;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function filter(Request $request)
    {
        Log::channel('system.info')->info(__CLASS__ . '@' . __FUNCTION__);
        return $this->_formProcessor->filter($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param IFormRequest $request
     * @return Response
     */
    public function store(IFormRequest $request)
    {
        return $this->_formProcessor->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return $this->_formProcessor->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param IFormRequest $request
     * @param int $id
     * @return Response
     */
    public function update(IFormRequest $request, int $id)
    {
        return $this->_formProcessor->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id)
    {
        return $this->_formProcessor->destroy($id);
    }

    public function deleteMulti(Request $request)
    {
        return $this->_formProcessor->deleteMulti($request);
    }
}
