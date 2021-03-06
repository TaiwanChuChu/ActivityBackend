<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($query) {
            $query->CreateID = auth()->user()->id;
        });

        static::updating(function ($query) {
            $query->UpdateID = auth()->user()->id;
        });
    }


}
