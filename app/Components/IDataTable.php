<?php

namespace App\Components;

interface IDataTable
{
    public function response(\Illuminate\Database\Eloquent\Builder $source, array $options, $collection);
}
