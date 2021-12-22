<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysMenu extends Model
{
    use HasFactory;

    public function parent()
    {
        return $this->belongsTo(self::class, 'upper_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'upper_id', 'id');
    }
}
