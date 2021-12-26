<?php

namespace App\Components;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class DataTable implements IDataTable
{
    private $_source;
    private $_datatableOptions;

    public function __construct(DatatableOptions $datatableOptions)
    {
        $this->_datatableOptions = $datatableOptions;
    }

    /**
     * @param Builder $source
     * @param $collection
     * @return mixed
     */
    public function response(Builder $source, $collection)
    {
        $this->_source = $source;

        request()->merge(['total' => $source->count()]);

        $this->resolveOrderBy()->resolvePaginate();

        return (new $collection($this->_source->get()));
        // 指定Http Status Code
//            ->response()
//            ->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @description 解析 OrderBy 集合串至 Query
     * @param Collection $options
     * @return DataTable
     */
    protected function resolveOrderBy(): DataTable
    {
        if (count($sortBy = $this->_datatableOptions->getSortBy()) !== count($sortDesc = $this->_datatableOptions->getSortDesc())) {
            throw new \InvalidArgumentException('order by 欄位與排序方式數量不一致!');
//                report(new \InvalidArgumentException('order by 欄位與排序方式數量不一致!'));
        }

        $combine = collect(array_combine($sortBy, $sortDesc));

        tap([true => 'DESC', false => 'ASC'], function ($sortDescList) use ($combine) {
            $combine->each(function ($sortDesc, $sortBy) use ($sortDescList) {
                $this->_source->orderBy($sortBy, $sortDescList[$sortDesc]);
            });
        });

        return $this;
    }

    /**
     * @description 解析 Paginate 集合串至 Query
     * @param Collection $options
     * @return DataTable
     */
    protected function resolvePaginate(): DataTable
    {
        $page = $this->_datatableOptions->getPage();
        $itemPage = $this->_datatableOptions->getItemsPerPage();
        $skip = $page > 1 ? ($page - 1) * $itemPage : 0;
        $this->_source->skip($skip)->take($itemPage);

        return $this;
    }

    public function dd()
    {
        return $this->_source->dd();
    }
}
