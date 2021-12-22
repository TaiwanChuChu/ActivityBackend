<?php

namespace App\Components;

class DataTable implements IDataTable
{
    public function response(\Illuminate\Database\Eloquent\Builder $source, array $options, $collection)
    {
        request()->merge(['total' => $source->count()]);
        // todo: 多排序
        $sortDesc = $options['sortDesc'] ? $options['sortDesc'][0] : true;
        $sortBy = $options['sortBy'] ? $options['sortBy'][0] : 'id';

        $page = $options['page'] ?? 0;
        $itemPage = $options['itemsPerPage'] ?? 10;
        $skip = $page > 1 ? ($page - 1) * $itemPage : 0;
        return (new $collection($source->skip($skip)->take($itemPage)->orderBy($sortBy, ($sortDesc ? 'DESC' : 'ASC'))->get()));

    }
}
